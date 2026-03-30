<x-app-layout>
    <style>
        /* ── Dashboard Layout ── */
        .dash-page {
            width: min(1100px, calc(100% - 2.5rem));
            margin: 2.5rem auto 4rem;
        }

        /* ── Page header ── */
        .dash-header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .dash-kicker {
            display: inline-block;
            font-size: 0.76rem;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            color: var(--ink-soft);
            margin-bottom: 0.3rem;
        }

        .dash-heading {
            margin: 0;
            font-family: 'Fraunces', serif;
            font-size: clamp(1.6rem, 3vw, 2.4rem);
            font-weight: 700;
            line-height: 1.1;
            letter-spacing: -0.01em;
            color: var(--ink);
        }

        .dash-btn-new {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.72rem 1.25rem;
            background: var(--ink);
            color: #f5fbf8;
            border-radius: 12px;
            font-family: 'Sora', system-ui, sans-serif;
            font-size: 0.88rem;
            font-weight: 600;
            text-decoration: none;
            box-shadow: 0 8px 20px rgba(18, 34, 38, 0.2);
            transition: transform 180ms ease, box-shadow 180ms ease;
            white-space: nowrap;
        }

        .dash-btn-new:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 28px rgba(18, 34, 38, 0.28);
        }

        /* ── Stats bar ── */
        .dash-stats {
            display: flex;
            gap: 0.75rem;
            margin-bottom: 1.6rem;
            flex-wrap: wrap;
        }

        .dash-stat {
            background: rgba(255, 255, 255, 0.72);
            border: 1px solid var(--line);
            border-radius: 14px;
            padding: 0.75rem 1.15rem;
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        .dash-stat-value {
            font-family: 'Fraunces', serif;
            font-size: 1.3rem;
            line-height: 1;
            color: var(--ink);
        }

        .dash-stat-label {
            font-size: 0.78rem;
            color: var(--ink-soft);
            line-height: 1.35;
        }

        /* ── Spreadsheet list ── */
        .dash-list {
            background: rgba(255, 255, 255, 0.78);
            border: 1px solid rgba(255, 255, 255, 0.65);
            box-shadow: 0 8px 40px rgba(13, 38, 46, 0.12);
            border-radius: 22px;
            overflow: hidden;
            animation: dashLiftIn 700ms cubic-bezier(0.2, 0.85, 0.26, 1) both;
        }

        .dash-list-header {
            display: grid;
            grid-template-columns: 1fr 160px 120px 80px 100px;
            gap: 0.5rem;
            padding: 0.75rem 1.4rem;
            background: rgba(18, 34, 38, 0.04);
            border-bottom: 1px solid var(--line);
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            color: var(--ink-soft);
        }

        .dash-row {
            display: grid;
            grid-template-columns: 1fr 160px 120px 80px 100px;
            gap: 0.5rem;
            align-items: center;
            padding: 0.95rem 1.4rem;
            border-bottom: 1px solid var(--line);
            transition: background 160ms ease;
            text-decoration: none;
            color: inherit;
        }

        .dash-row:last-child { border-bottom: none; }

        .dash-row:hover {
            background: rgba(31, 157, 116, 0.05);
        }

        /* Name cell */
        .dash-row-name {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            min-width: 0;
        }

        .dash-row-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: linear-gradient(145deg, rgba(31,157,116,0.15) 0%, rgba(31,157,116,0.06) 100%);
            border: 1px solid rgba(31, 157, 116, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .dash-row-icon svg { width: 16px; height: 16px; }

        .dash-row-title {
            font-size: 0.92rem;
            font-weight: 600;
            color: var(--ink);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Team cell */
        .dash-row-team {
            font-size: 0.82rem;
            color: var(--ink-soft);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .dash-badge-owner {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            background: rgba(31, 157, 116, 0.1);
            color: var(--accent-strong);
            border: 1px solid rgba(31, 157, 116, 0.22);
            border-radius: 999px;
            padding: 0.22rem 0.62rem;
            font-size: 0.72rem;
            font-weight: 600;
        }

        .dash-badge-shared {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            background: rgba(234, 179, 8, 0.1);
            color: #92660a;
            border: 1px solid rgba(234, 179, 8, 0.28);
            border-radius: 999px;
            padding: 0.22rem 0.62rem;
            font-size: 0.72rem;
            font-weight: 600;
        }

        /* Cells count */
        .dash-row-cells {
            font-size: 0.84rem;
            color: var(--ink-soft);
            text-align: center;
        }

        /* Date */
        .dash-row-date {
            font-size: 0.8rem;
            color: var(--ink-soft);
        }

        /* Actions */
        .dash-row-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 0.4rem;
        }

        .dash-action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
            border-radius: 8px;
            border: 1px solid var(--line);
            background: rgba(255, 255, 255, 0.7);
            color: var(--ink-soft);
            text-decoration: none;
            cursor: pointer;
            transition: background 160ms ease, color 160ms ease, border-color 160ms ease;
        }

        .dash-action-btn:hover {
            background: rgba(255, 255, 255, 0.95);
            color: var(--ink);
            border-color: rgba(18, 34, 38, 0.22);
        }

        .dash-action-btn.danger:hover {
            background: rgba(239, 68, 68, 0.08);
            color: #b91c1c;
            border-color: rgba(239, 68, 68, 0.3);
        }

        /* ── Empty state ── */
        .dash-empty {
            background: rgba(255, 255, 255, 0.78);
            border: 1px solid rgba(255, 255, 255, 0.65);
            box-shadow: 0 8px 40px rgba(13, 38, 46, 0.12);
            border-radius: 22px;
            padding: 5rem 2rem;
            text-align: center;
            animation: dashLiftIn 700ms cubic-bezier(0.2, 0.85, 0.26, 1) both;
        }

        .dash-empty-icon {
            width: 72px;
            height: 72px;
            margin: 0 auto 1.5rem;
            border-radius: 20px;
            background: linear-gradient(145deg, rgba(31,157,116,0.14), rgba(31,157,116,0.05));
            border: 1px solid rgba(31, 157, 116, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .dash-empty-icon svg { width: 32px; height: 32px; }

        .dash-empty h2 {
            margin: 0 0 0.6rem;
            font-family: 'Fraunces', serif;
            font-size: 1.5rem;
            color: var(--ink);
        }

        .dash-empty p {
            margin: 0 0 2rem;
            color: var(--ink-soft);
            font-size: 0.93rem;
            max-width: 36ch;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.65;
        }

        @keyframes dashLiftIn {
            from { transform: translateY(14px) scale(0.99); opacity: 0; }
            to   { transform: translateY(0)    scale(1);    opacity: 1; }
        }

        @media (max-width: 800px) {
            .dash-list-header,
            .dash-row {
                grid-template-columns: 1fr 90px 80px;
            }

            .dash-list-header > *:nth-child(3),
            .dash-row > *:nth-child(3),
            .dash-list-header > *:nth-child(4),
            .dash-row > *:nth-child(4) { display: none; }
        }

        @media (max-width: 560px) {
            .dash-page { width: calc(100% - 1.4rem); }
            .dash-list-header { display: none; }
            .dash-row { grid-template-columns: 1fr 80px; }
            .dash-row > *:nth-child(2),
            .dash-row > *:nth-child(3),
            .dash-row > *:nth-child(4) { display: none; }
        }
    </style>

    <div class="dash-page">

        {{-- Page Header --}}
        <div class="dash-header">
            <div>
                <div class="dash-kicker">{{ auth()->user()->name }}</div>
                <h1 class="dash-heading">Your workspace</h1>
            </div>
            <a href="{{ route('spreadsheets.create') }}" class="dash-btn-new">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" style="width:16px;height:16px;">
                    <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z"/>
                </svg>
                New spreadsheet
            </a>
        </div>

        {{-- Stats bar --}}
        @php
            $mine = $spreadsheets->where('owner_id', auth()->id());
            $shared = $spreadsheets->where('owner_id', '!=', auth()->id());
        @endphp
        <div class="dash-stats">
            <div class="dash-stat">
                <div class="dash-stat-value">{{ $spreadsheets->count() }}</div>
                <div class="dash-stat-label">Total<br>spreadsheets</div>
            </div>
            <div class="dash-stat">
                <div class="dash-stat-value">{{ $mine->count() }}</div>
                <div class="dash-stat-label">Owned<br>by me</div>
            </div>
            <div class="dash-stat">
                <div class="dash-stat-value">{{ $shared->count() }}</div>
                <div class="dash-stat-label">Shared<br>with me</div>
            </div>
            <div class="dash-stat">
                <div class="dash-stat-value">{{ $spreadsheets->sum('cells_count') }}</div>
                <div class="dash-stat-label">Total<br>cells</div>
            </div>
        </div>

        {{-- Spreadsheet list --}}
        @if ($spreadsheets->isEmpty())
            <div class="dash-empty">
                <div class="dash-empty-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#1f9d74">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 01-1.125-1.125M3.375 19.5h7.5c.621 0 1.125-.504 1.125-1.125m-9.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0 3.75h-7.5A1.125 1.125 0 0112 18.375m9.75-12.75c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125m19.5 0v1.5c0 .621-.504 1.125-1.125 1.125M2.25 5.625v1.5c0 .621.504 1.125 1.125 1.125m0 0h17.25m-17.25 0h7.5c.621 0 1.125.504 1.125 1.125M3.375 8.25c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125m17.25-3.75h-7.5c-.621 0-1.125.504-1.125 1.125m8.625-1.125c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-1.5-3.75c.621 0 1.125.504 1.125 1.125" />
                    </svg>
                </div>
                <h2>No spreadsheets yet</h2>
                <p>Create your first spreadsheet to start working with formulas, AI assistance, and real-time collaboration.</p>
                <a href="{{ route('spreadsheets.create') }}" class="dash-btn-new" style="display:inline-flex;">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" style="width:16px;height:16px;">
                        <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z"/>
                    </svg>
                    Create your first spreadsheet
                </a>
            </div>
        @else
            <div class="dash-list">
                {{-- Table header --}}
                <div class="dash-list-header">
                    <div>Name</div>
                    <div>Team</div>
                    <div>Last edited</div>
                    <div style="text-align:center">Cells</div>
                    <div></div>
                </div>

                {{-- Rows --}}
                @foreach ($spreadsheets as $sheet)
                    <div class="dash-row">
                        {{-- Name --}}
                        <div class="dash-row-name">
                            <div class="dash-row-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#1f9d74">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 01-1.125-1.125M3.375 19.5h7.5c.621 0 1.125-.504 1.125-1.125m-9.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0 3.75h-7.5A1.125 1.125 0 0112 18.375m9.75-12.75c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125m19.5 0v1.5c0 .621-.504 1.125-1.125 1.125M2.25 5.625v1.5c0 .621.504 1.125 1.125 1.125m0 0h17.25m-17.25 0h7.5c.621 0 1.125.504 1.125 1.125M3.375 8.25c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125m17.25-3.75h-7.5c-.621 0-1.125.504-1.125 1.125m8.625-1.125c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-1.5-3.75c.621 0 1.125.504 1.125 1.125" />
                                </svg>
                            </div>
                            <a href="{{ route('spreadsheets.show', $sheet) }}" class="dash-row-title" title="{{ $sheet->name }}">
                                {{ $sheet->name }}
                            </a>
                        </div>

                        {{-- Team --}}
                        <div class="dash-row-team">
                            @if ($sheet->owner_id === auth()->id())
                                <span class="dash-badge-owner">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" style="width:10px;height:10px;"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM12.735 14c.618 0 1.093-.561.872-1.139a6.002 6.002 0 0 0-11.215 0c-.22.578.254 1.139.872 1.139h9.47Z"/></svg>
                                    Mine
                                </span>
                            @else
                                <span class="dash-badge-shared">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" style="width:10px;height:10px;"><path d="M13.5 8.5a.5.5 0 0 1 0 1h-2.793l1.647 1.646a.5.5 0 0 1-.708.708l-2.5-2.5a.5.5 0 0 1 0-.708l2.5-2.5a.5.5 0 1 1 .708.708L10.707 8.5H13.5ZM7.5 4a.5.5 0 0 1-.5.5H4.207l1.647 1.646a.5.5 0 1 1-.708.708l-2.5-2.5a.5.5 0 0 1 0-.708l2.5-2.5a.5.5 0 1 1 .708.708L4.207 3.5H7a.5.5 0 0 1 .5.5Z"/></svg>
                                    Shared
                                </span>
                            @endif
                            @if ($sheet->team)
                                <span style="display:block; margin-top: 0.25rem; font-size: 0.75rem;">{{ $sheet->team->name }}</span>
                            @endif
                        </div>

                        {{-- Date --}}
                        <div class="dash-row-date">
                            {{ $sheet->updated_at->diffForHumans() }}
                        </div>

                        {{-- Cells count --}}
                        <div class="dash-row-cells">
                            {{ number_format($sheet->cells_count) }}
                        </div>

                        {{-- Actions --}}
                        <div class="dash-row-actions">
                            <a href="{{ route('spreadsheets.show', $sheet) }}"
                               class="dash-action-btn" title="Open">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" style="width:14px;height:14px;">
                                    <path d="M12.232 4.232a2.5 2.5 0 013.536 3.536l-1.225 1.224a.75.75 0 001.061 1.06l1.224-1.224a4 4 0 00-5.656-5.656l-3 3a4 4 0 00.225 5.865.75.75 0 00.977-1.138 2.5 2.5 0 01-.142-3.667l3-3z"/>
                                    <path d="M11.603 7.963a.75.75 0 00-.977 1.138 2.5 2.5 0 01.142 3.667l-3 3a2.5 2.5 0 01-3.536-3.536l1.225-1.224a.75.75 0 00-1.061-1.06l-1.224 1.224a4 4 0 105.656 5.656l3-3a4 4 0 00-.225-5.865z"/>
                                </svg>
                            </a>

                            @if ($sheet->owner_id === auth()->id())
                                <form method="POST" action="{{ route('spreadsheets.destroy', $sheet) }}"
                                      onsubmit="return confirm('Delete \'{{ addslashes($sheet->name) }}\'? This cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="dash-action-btn danger" title="Delete">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" style="width:14px;height:14px;">
                                            <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193v-.443A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z" clip-rule="evenodd"/>
                                        </svg>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
</x-app-layout>
