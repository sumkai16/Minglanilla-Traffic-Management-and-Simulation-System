<x-guest-layout variant="login" title="Register">
    <div class="auth-layout">
        <div class="auth-shell auth-shell--wide">
            <section class="auth-card">
                @include('auth.partials.card-brand')

                <div class="auth-card__header">
                    <span class="auth-pill auth-pill--soft">New account</span>
                    <h1 class="auth-title">Create your portal account</h1>
                    <p class="auth-copy">Set up your access once, then move between report review, advisories, and coordination tools without friction.</p>
                </div>

                @include('auth.partials.error-summary')

                <form method="POST" action="{{ route('register') }}" class="auth-form">
                    @csrf

                    <div class="auth-grid auth-grid--2">
                        <div class="auth-field">
                            <label for="first_name" class="auth-label">First name</label>
                            <input type="text" name="first_name" id="first_name" class="auth-input"
                                placeholder="Juan" value="{{ old('first_name') }}" required autofocus
                                autocomplete="given-name" />
                            <x-input-error :messages="$errors->get('first_name')" class="auth-field__error" />
                        </div>

                        <div class="auth-field">
                            <label for="last_name" class="auth-label">Last name</label>
                            <input type="text" name="last_name" id="last_name" class="auth-input"
                                placeholder="Dela Cruz" value="{{ old('last_name') }}" required
                                autocomplete="family-name" />
                            <x-input-error :messages="$errors->get('last_name')" class="auth-field__error" />
                        </div>
                    </div>

                    <div class="auth-field">
                        <label for="email" class="auth-label">Email address</label>
                        <div class="auth-input-wrap">
                            <span class="auth-input-icon" aria-hidden="true">
                                <i data-lucide="mail"></i>
                            </span>
                            <input type="email" name="email" id="email" class="auth-input auth-input--with-icon"
                                placeholder="name@example.com" value="{{ old('email') }}" required autocomplete="username" />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="auth-field__error" />
                    </div>

                    <div class="auth-grid auth-grid--2">
                        <div class="auth-field" x-data="{ show: false }">
                            <div class="auth-field__split">
                                <label for="password" class="auth-label">Password</label>
                                <span class="auth-helper">Use at least 8 characters.</span>
                            </div>
                            <div class="auth-input-wrap">
                                <span class="auth-input-icon" aria-hidden="true">
                                    <i data-lucide="lock"></i>
                                </span>
                                <input type="password" name="password" id="password"
                                    class="auth-input auth-input--with-icon auth-input--with-action"
                                    placeholder="Create password" required autocomplete="new-password"
                                    :type="show ? 'text' : 'password'" />
                                <button type="button" @click="show = !show" class="auth-input-action"
                                    :aria-label="show ? 'Hide password' : 'Show password'">
                                    <span x-show="!show" aria-hidden="true"><i data-lucide="eye-off"></i></span>
                                    <span x-show="show" x-cloak aria-hidden="true"><i data-lucide="eye"></i></span>
                                </button>
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="auth-field__error" />
                        </div>

                        <div class="auth-field" x-data="{ show: false }">
                            <label for="password_confirmation" class="auth-label">Confirm password</label>
                            <div class="auth-input-wrap">
                                <span class="auth-input-icon" aria-hidden="true">
                                    <i data-lucide="lock"></i>
                                </span>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="auth-input auth-input--with-icon auth-input--with-action"
                                    placeholder="Repeat password" required autocomplete="new-password"
                                    :type="show ? 'text' : 'password'" />
                                <button type="button" @click="show = !show" class="auth-input-action"
                                    :aria-label="show ? 'Hide password confirmation' : 'Show password confirmation'">
                                    <span x-show="!show" aria-hidden="true"><i data-lucide="eye-off"></i></span>
                                    <span x-show="show" x-cloak aria-hidden="true"><i data-lucide="eye"></i></span>
                                </button>
                            </div>
                            <x-input-error :messages="$errors->get('password_confirmation')" class="auth-field__error" />
                        </div>
                    </div>

                    <button type="submit" class="auth-submit auth-submit--primary">Create account</button>
                </form>

                <div class="auth-footer auth-footer--stacked">
                    <p class="auth-footer__text">Already registered?</p>
                    <div class="auth-link-cluster">
                        <a href="{{ route('login') }}" class="auth-inline-link auth-inline-link--small">Return to sign in</a>
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-guest-layout>
