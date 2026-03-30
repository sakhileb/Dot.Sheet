self.onmessage = (event) => {
    const message = event.data || {};
    if (message.type !== 'run') {
        return;
    }

    const body = String(message.body || '');
    const context = message.context || {};

    try {
        const fn = new Function(
            'context',
            `"use strict";
            const set = (cell, value) => ({ type: 'set', cell, value });
            const clear = (cell) => ({ type: 'clear', cell });
            const select = (cell) => ({ type: 'select', cell });
            const sheet = { set, clear, select };
            const result = (function () {
                ${body}
            })();
            return result;`
        );

        const result = fn(context);
        if (!Array.isArray(result)) {
            self.postMessage({ ok: false, error: 'Script must return an array of actions.' });
            return;
        }

        const actions = result
            .slice(0, 1000)
            .filter((action) => action && typeof action === 'object')
            .map((action) => ({
                type: String(action.type || '').toLowerCase(),
                cell: action.cell,
                row: action.row,
                col: action.col,
                value: action.value,
            }))
            .filter((action) => ['set', 'clear', 'select'].includes(action.type));

        self.postMessage({ ok: true, actions });
    } catch (error) {
        self.postMessage({
            ok: false,
            error: error instanceof Error ? error.message : String(error),
        });
    }
};
