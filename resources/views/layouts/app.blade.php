<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Dot.Sheet') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=sora:400,500,600,700|fraunces:600,700,800" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles

        <style>
            :root {
                --ink: #122226;
                --ink-soft: #355257;
                --paper: #f7f4eb;
                --accent: #1f9d74;
                --accent-strong: #0f7f5a;
                --card: rgba(255, 255, 255, 0.82);
                --line: rgba(18, 34, 38, 0.14);
                --shadow: 0 24px 70px rgba(13, 38, 46, 0.2);
            }

            *, *::before, *::after { box-sizing: border-box; }

            body {
                font-family: 'Sora', system-ui, sans-serif;
                color: var(--ink);
                background:
                    radial-gradient(900px 400px at 85% -10%, rgba(31, 157, 116, 0.24), transparent 70%),
                    radial-gradient(700px 500px at -10% 100%, rgba(234, 179, 8, 0.18), transparent 70%),
                    linear-gradient(160deg, #f8f5ef 0%, #eff6f2 45%, #f6f6f2 100%);
                background-attachment: fixed;
                min-height: 100vh;
            }

            body::before {
                content: '';
                position: fixed;
                inset: 0;
                pointer-events: none;
                opacity: 0.22;
                background-image: radial-gradient(rgba(20, 20, 20, 0.06) 0.55px, transparent 0.55px);
                background-size: 4px 4px;
                z-index: 0;
            }

            /* ── DS Nav overrides ── */
            .ds-nav {
                background: rgba(247, 244, 235, 0.88);
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
                border-bottom: 1px solid var(--line);
                position: sticky;
                top: 0;
                z-index: 50;
            }

            /* Keep relative stacking above grain */
            #app-content { position: relative; z-index: 1; }
        </style>
    </head>
    <body class="antialiased">
        <x-banner />

        <div id="app-content" class="min-h-screen">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header) || View::hasSection('header'))
                <header style="background: rgba(255,255,255,0.75); backdrop-filter: blur(10px); border-bottom: 1px solid var(--line); box-shadow: 0 2px 12px rgba(13,38,46,0.07);">
                    <div class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
                        @isset($header)
                            {{ $header }}
                        @else
                            @yield('header')
                        @endisset
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                @isset($slot)
                    {{ $slot }}
                @else
                    @yield('content')
                @endisset
            </main>
        </div>

        @stack('modals')

        @livewireScripts
    </body>
</html>
