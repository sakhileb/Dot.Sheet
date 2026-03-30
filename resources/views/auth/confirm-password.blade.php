<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <h1 class="auth-heading">Confirm your password.</h1>
        <p class="auth-sub">This is a secure area. Please re-enter your password to continue.</p>

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

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <div class="ds-field">
                <label class="ds-label" for="password">Password</label>
                <input class="ds-input" id="password" type="password" name="password"
                       required autocomplete="current-password" autofocus placeholder="••••••••" />
            </div>

            <button type="submit" class="ds-btn-primary">Confirm & continue</button>
        </form>
    </x-authentication-card>
</x-guest-layout>
