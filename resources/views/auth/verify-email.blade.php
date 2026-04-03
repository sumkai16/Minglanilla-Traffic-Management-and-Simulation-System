<x-guest-layout variant="login" title="Verify Email">
    <div class="auth-layout">
        <div class="auth-shell auth-shell--wide">
            <section class="auth-card">
                @include('auth.partials.card-brand')

                <div class="auth-card__header">
                    <span class="auth-pill auth-pill--soft">Email verification</span>
                    <h1 class="auth-title">Check your inbox</h1>
                    <p class="auth-copy">Open the verification message we sent, then confirm your email to unlock the rest of the portal.</p>
                </div>

                @if (session('status') == 'verification-link-sent')
                    <div class="auth-alert auth-alert--success" role="status">
                        A fresh verification link has been sent to your email address.
                    </div>
                @endif

                <div class="auth-stack">
                    <div class="auth-alert auth-alert--info" role="note">
                        If the message is not in your inbox, check your spam folder or request another verification email.
                    </div>

                    <div class="auth-button-group">
                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button type="submit" class="auth-submit auth-submit--primary">Resend verification email</button>
                        </form>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="auth-submit auth-submit--secondary">Log out</button>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-guest-layout>
