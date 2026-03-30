import './bootstrap';
import './formula-parser';
import Chart from 'chart.js/auto';
import Shepherd from 'shepherd.js';
import 'shepherd.js/dist/css/shepherd.css';

// Globals
window.FormulaParser = FormulaParser;
window.Chart = Chart;
window.Shepherd = Shepherd;

const scriptSandboxWorker =
	typeof Worker !== 'undefined'
		? new Worker(new URL('./workers/script-sandbox.worker.js', import.meta.url), { type: 'module' })
		: null;

window.runSpreadsheetScriptSandbox = (payload = {}) => {
	if (!scriptSandboxWorker) {
		return Promise.resolve({ ok: false, error: 'Web Worker is not supported in this browser.' });
	}

	return new Promise((resolve) => {
		const timeoutHandle = setTimeout(() => {
			cleanup();
			resolve({ ok: false, error: 'Script timed out.' });
		}, 3500);

		const cleanup = () => {
			clearTimeout(timeoutHandle);
			scriptSandboxWorker.removeEventListener('message', onMessage);
			scriptSandboxWorker.removeEventListener('error', onError);
		};

		const onMessage = (event) => {
			cleanup();
			resolve(event.data || { ok: false, error: 'Unknown worker response.' });
		};

		const onError = (event) => {
			cleanup();
			resolve({ ok: false, error: event.message || 'Worker execution failed.' });
		};

		scriptSandboxWorker.addEventListener('message', onMessage);
		scriptSandboxWorker.addEventListener('error', onError);
		scriptSandboxWorker.postMessage({
			type: 'run',
			body: payload.body || '',
			context: payload.context || {},
		});
	});
};
