<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <h1 class="auth-heading">Create account.</h1>
        <p class="auth-sub">Start your Dot.Sheet workspace today — it's free.</p>

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

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="ds-field">
                <label class="ds-label" for="name">Full name</label>
                <input class="ds-input" id="name" type="text" name="name"
                       value="{{ old('name') }}" required autofocus autocomplete="name"
                       placeholder="Jane Smith" />
            </div>

            <div class="ds-field">
                <label class="ds-label" for="email">Email address</label>
                <input class="ds-input" id="email" type="email" name="email"
                       value="{{ old('email') }}" required autocomplete="username"
                       placeholder="you@example.com" />
            </div>

            <div class="ds-field">
                <label class="ds-label" for="password">Password</label>
                <input class="ds-input" id="password" type="password" name="password"
                       required autocomplete="new-password" placeholder="Create a strong password" />
            </div>

            <div class="ds-field">
                <label class="ds-label" for="password_confirmation">Confirm password</label>
                <input class="ds-input" id="password_confirmation" type="password"
                       name="password_confirmation" required autocomplete="new-password"
                       placeholder="Repeat your password" />
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="ds-terms-row">
                    <input class="ds-checkbox" style="margin-top: 3px" type="checkbox"
                           name="terms" id="terms" required />
                    <label for="terms">
                        I agree to the
                        <a href="{{ route('terms.show') }}" target="_blank">Terms of Service</a>
                        and
                        <a href="{{ route('policy.show') }}" target="_blank">Privacy Policy</a>
                    </label>
                </div>
            @endif

            <button type="submit" class="ds-btn-primary">Create account</button>
        </form>

        <div class="ds-footer">
            <span></span>
            <span>Already have an account? <a class="ds-link" href="{{ route('login') }}">Sign in</a></span>
        </div>
    </x-authentication-card>
</x-guest-layout>
