<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <h1 class="auth-heading">Choose a new password.</h1>
        <p class="auth-sub">Make it strong and something you'll remember.</p>

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

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="ds-field">
                <label class="ds-label" for="email">Email address</label>
                <input class="ds-input" id="email" type="email" name="email"
                       value="{{ old('email', $request->email) }}" required autofocus
                       autocomplete="username" placeholder="you@example.com" />
            </div>

            <div class="ds-field">
                <label class="ds-label" for="password">New password</label>
                <input class="ds-input" id="password" type="password" name="password"
                       required autocomplete="new-password" placeholder="Create a strong password" />
            </div>

            <div class="ds-field">
                <label class="ds-label" for="password_confirmation">Confirm new password</label>
                <input class="ds-input" id="password_confirmation" type="password"
                       name="password_confirmation" required autocomplete="new-password"
                       placeholder="Repeat your new password" />
            </div>

            <button type="submit" class="ds-btn-primary">Reset password</button>
        </form>
    </x-authentication-card>
</x-guest-layout>
