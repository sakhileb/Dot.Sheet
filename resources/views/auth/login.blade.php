<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <h1 class="auth-heading">Welcome back.</h1>
        <p class="auth-sub">Sign in to your Dot.Sheet workspace.</p>

        @session('status')
            <div class="ds-status">{{ $value }}</div>
        @endsession

        @if ($errors->any())
            <div class="ds-error-box">
                <div class="ds-error-title">Whoops! Something went wrong.</div>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="ds-field">
                <label class="ds-label" for="email">Email address</label>
                <input class="ds-input" id="email" type="email" name="email"
                       value="{{ old('email') }}" required autofocus autocomplete="username"
                       placeholder="you@example.com" />
            </div>

            <div class="ds-field">
                <label class="ds-label" for="password">Password</label>
                <input class="ds-input" id="password" type="password" name="password"
                       required autocomplete="current-password" placeholder="••••••••" />
            </div>

            <div class="ds-checkbox-row">
                <input class="ds-checkbox" type="checkbox" id="remember_me" name="remember" />
                <label class="ds-checkbox-label" for="remember_me">Keep me signed in</label>
            </div>

            <button type="submit" class="ds-btn-primary">Sign in</button>
        </form>

        <div class="ds-footer">
            @if (Route::has('password.request'))
                <a class="ds-link" href="{{ route('password.request') }}">Forgot password?</a>
            @else
                <span></span>
            @endif

            @if (Route::has('register'))
                <span>No account? <a class="ds-link" href="{{ route('register') }}">Sign up free</a></span>
            @endif
        </div>
    </x-authentication-card>
</x-guest-layout>
