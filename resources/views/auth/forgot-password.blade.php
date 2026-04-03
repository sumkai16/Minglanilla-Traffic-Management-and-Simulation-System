<x-guest-layout variant="login" title="Forgot Password">
    <div class="auth-layout">
        <div class="auth-shell auth-shell--wide">
            <section class="auth-card">
                @include('auth.partials.card-brand')

                <div class="auth-card__header">
                    <span class="auth-pill auth-pill--soft">Password recovery</span>
                    <h1 class="auth-title">Reset your password</h1>
                    <p class="auth-copy">Enter your registered email address and we will send a secure reset link so you can regain access.</p>
                </div>

                <x-auth-session-status class="auth-alert auth-alert--success" :status="session('status')" />
                @include('auth.partials.error-summary')

                <form method="POST" action="{{ route('password.email') }}" class="auth-form">
                    @csrf

                    <div class="auth-field">
                        <label for="email" class="auth-label">Email address</label>
                        <div class="auth-input-wrap">
                            <span class="auth-input-icon" aria-hidden="true">
                                <i data-lucide="mail"></i>
                            </span>
                            <input id="email" type="email" name="email" class="auth-input auth-input--with-icon"
                                placeholder="name@example.com" value="{{ old('email') }}" required autofocus
                                autocomplete="username" />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="auth-field__error" />
                    </div>

                    <button type="submit" class="auth-submit auth-submit--primary">Send reset link</button>
                </form>

                <div class="auth-footer auth-footer--stacked">
                    <p class="auth-footer__text">Remembered your password?</p>
                    <div class="auth-link-cluster">
                        <a href="{{ route('login') }}" class="auth-inline-link auth-inline-link--small">Back to sign in</a>
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-guest-layout>
