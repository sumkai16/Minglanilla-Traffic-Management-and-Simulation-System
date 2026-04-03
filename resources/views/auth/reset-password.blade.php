<x-guest-layout variant="login" title="Reset Password">
    <div class="auth-layout">
        <div class="auth-shell auth-shell--wide">
            <section class="auth-card">
                @include('auth.partials.card-brand')

                <div class="auth-card__header">
                    <span class="auth-pill auth-pill--soft">Create new password</span>
                    <h1 class="auth-title">Choose a new password</h1>
                    <p class="auth-copy">Finish the recovery flow by confirming the email address and setting a new password for your account.</p>
                </div>

                <x-auth-session-status class="auth-alert auth-alert--success" :status="session('status')" />
                @include('auth.partials.error-summary')

                <form method="POST" action="{{ route('password.store') }}" class="auth-form">
                    @csrf

                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <div class="auth-field">
                        <label for="email" class="auth-label">Email address</label>
                        <div class="auth-input-wrap">
                            <span class="auth-input-icon" aria-hidden="true">
                                <i data-lucide="mail"></i>
                            </span>
                            <input id="email" type="email" name="email" class="auth-input auth-input--with-icon"
                                placeholder="name@example.com" value="{{ old('email', $request->email) }}" required
                                autofocus autocomplete="username" />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="auth-field__error" />
                    </div>

                    <div class="auth-grid auth-grid--2">
                        <div class="auth-field" x-data="{ show: false }">
                            <label for="password" class="auth-label">New password</label>
                            <div class="auth-input-wrap">
                                <span class="auth-input-icon" aria-hidden="true">
                                    <i data-lucide="lock"></i>
                                </span>
                                <input id="password" :type="show ? 'text' : 'password'" name="password"
                                    class="auth-input auth-input--with-icon auth-input--with-action"
                                    placeholder="Create password" required autocomplete="new-password" />
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
                                <input id="password_confirmation" :type="show ? 'text' : 'password'" name="password_confirmation"
                                    class="auth-input auth-input--with-icon auth-input--with-action"
                                    placeholder="Repeat password" required autocomplete="new-password" />
                                <button type="button" @click="show = !show" class="auth-input-action"
                                    :aria-label="show ? 'Hide password confirmation' : 'Show password confirmation'">
                                    <span x-show="!show" aria-hidden="true"><i data-lucide="eye-off"></i></span>
                                    <span x-show="show" x-cloak aria-hidden="true"><i data-lucide="eye"></i></span>
                                </button>
                            </div>
                            <x-input-error :messages="$errors->get('password_confirmation')" class="auth-field__error" />
                        </div>
                    </div>

                    <button type="submit" class="auth-submit auth-submit--primary">Reset password</button>
                </form>
            </section>
        </div>
    </div>
</x-guest-layout>
