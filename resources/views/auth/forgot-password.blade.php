<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <h1 class="auth-heading">Reset password.</h1>
        <p class="auth-sub">Enter your email and we'll send you a reset link.</p>

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

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="ds-field">
                <label class="ds-label" for="email">Email address</label>
                <input class="ds-input" id="email" type="email" name="email"
                       value="{{ old('email') }}" required autofocus autocomplete="username"
                       placeholder="you@example.com" />
            </div>

            <button type="submit" class="ds-btn-primary">Send reset link</button>
        </form>

        <div class="ds-footer">
            <span></span>
            <a class="ds-link" href="{{ route('login') }}">Back to sign in</a>
        </div>
    </x-authentication-card>
</x-guest-layout>
