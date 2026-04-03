<x-guest-layout variant="login" title="Login">
    <div class="auth-layout">
        <div class="auth-shell">
            <section class="auth-card">
                @include('auth.partials.card-brand')

                <div class="auth-card__header">
                    <span class="auth-pill auth-pill--soft">Account sign in</span>
                    <h1 class="auth-title">Welcome back</h1>
                    <p class="auth-copy">Sign in to continue managing reports, advisories, and traffic operations from
                        the main dashboard.</p>
                </div>

                <x-auth-session-status class="auth-alert auth-alert--success" :status="session('status')" />
                @include('auth.partials.error-summary')

                <form method="POST" action="{{ route('login') }}" class="auth-form">
                    @csrf

                    <div class="auth-field">
                        <div class="auth-field__split">
                            <label for="email" class="auth-label">Email address</label>
                            <span class="auth-helper">Use the email tied to your account.</span>
                        </div>
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

                    <div class="auth-field" x-data="{ show: false }">
                        <div class="auth-field__split">
                            <label for="password" class="auth-label">Password</label>
                            @if (Route::has('password.request'))
                                <a class="auth-inline-link auth-inline-link--small"
                                    href="{{ route('password.request') }}">Forgot password?</a>
                            @endif
                        </div>
                        <div class="auth-input-wrap">
                            <span class="auth-input-icon" aria-hidden="true">
                                <i data-lucide="lock"></i>
                            </span>
                            <input id="password" :type="show ? 'text' : 'password'" name="password"
                                class="auth-input auth-input--with-icon auth-input--with-action"
                                placeholder="Enter your password" required autocomplete="current-password" />
                            <button type="button" @click="show = !show" class="auth-input-action"
                                :aria-label="show ? 'Hide password' : 'Show password'">
                                <span x-show="!show" aria-hidden="true"><i data-lucide="eye-off"></i></span>
                                <span x-show="show" x-cloak aria-hidden="true"><i data-lucide="eye"></i></span>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="auth-field__error" />
                    </div>

                    <div class="auth-meta-row">
                        <label class="auth-checkbox" for="remember_me">
                            <input id="remember_me" type="checkbox" name="remember" @checked(old('remember')) />
                            <span>Keep me signed in on this device</span>
                        </label>
                    </div>

                    <button type="submit" class="auth-submit auth-submit--primary">Sign in</button>
                </form>

                <div class="auth-footer auth-footer--stacked">
                    <p class="auth-footer__text">Need a new account?</p>
                    <div class="auth-link-cluster">
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="auth-inline-link auth-inline-link--small">Create
                                account</a>
                        @endif
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-guest-layout>
