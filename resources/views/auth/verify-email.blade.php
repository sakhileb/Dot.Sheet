<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <h1 class="auth-heading">Verify your email.</h1>
        <p class="auth-sub">Click the link we sent to your inbox to activate your account. Didn't get it? We'll send another.</p>

        @if (session('status') == 'verification-link-sent')
            <div class="ds-status">A new verification link has been sent to your email address.</div>
        @endif

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="ds-btn-primary">Resend verification email</button>
        </form>

        <div class="ds-footer">
            <a class="ds-link" href="{{ route('profile.show') }}">Edit profile</a>
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit" class="ds-link" style="background:none;border:none;cursor:pointer;padding:0;font-size:0.84rem;">Sign out</button>
            </form>
        </div>
    </x-authentication-card>
</x-guest-layout>
