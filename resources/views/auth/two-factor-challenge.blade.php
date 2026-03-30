<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <div x-data="{ recovery: false }">
            <h1 class="auth-heading">Two-factor auth.</h1>

            <p class="auth-sub" x-show="! recovery">
                Enter the code from your authenticator app to continue.
            </p>
            <p class="auth-sub" x-cloak x-show="recovery">
                Enter one of your emergency recovery codes to continue.
            </p>

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

            <form method="POST" action="{{ route('two-factor.login') }}">
                @csrf

                <div class="ds-field" x-show="! recovery">
                    <label class="ds-label" for="code">Authentication code</label>
                    <input class="ds-input" id="code" type="text" inputmode="numeric"
                           name="code" autofocus x-ref="code" autocomplete="one-time-code"
                           placeholder="6-digit code" />
                </div>

                <div class="ds-field" x-cloak x-show="recovery">
                    <label class="ds-label" for="recovery_code">Recovery code</label>
                    <input class="ds-input" id="recovery_code" type="text"
                           name="recovery_code" x-ref="recovery_code" autocomplete="one-time-code"
                           placeholder="xxxx-xxxx-xxxx" />
                </div>

                <button type="submit" class="ds-btn-primary">Verify &amp; sign in</button>
            </form>

            <div class="ds-footer">
                <span></span>
                <button type="button" class="ds-link" style="background:none;border:none;cursor:pointer;padding:0;font-size:0.84rem;"
                        x-show="! recovery"
                        x-on:click="recovery = true; $nextTick(() => { $refs.recovery_code.focus() })">
                    Use a recovery code
                </button>
                <button type="button" class="ds-link" style="background:none;border:none;cursor:pointer;padding:0;font-size:0.84rem;"
                        x-cloak x-show="recovery"
                        x-on:click="recovery = false; $nextTick(() => { $refs.code.focus() })">
                    Use authenticator code
                </button>
            </div>
        </div>
    </x-authentication-card>
</x-guest-layout>
