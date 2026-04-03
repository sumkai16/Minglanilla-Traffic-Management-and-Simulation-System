<x-guest-layout variant="login" title="Confirm Password">
    <div class="auth-layout">
        <div class="auth-shell">
            <section class="auth-card">
                @include('auth.partials.card-brand')

                <div class="auth-card__header">
                    <span class="auth-pill auth-pill--soft">Security checkpoint</span>
                    <h1 class="auth-title">Confirm your password</h1>
                    <p class="auth-copy">This action requires an extra confirmation step before you can continue inside the portal.</p>
                </div>

                @include('auth.partials.error-summary')

                <form method="POST" action="{{ route('password.confirm') }}" class="auth-form">
                    @csrf

                    <div class="auth-field" x-data="{ show: false }">
                        <label for="password" class="auth-label">Current password</label>
                        <div class="auth-input-wrap">
                            <span class="auth-input-icon" aria-hidden="true">
                                <i data-lucide="lock"></i>
                            </span>
                            <input id="password" :type="show ? 'text' : 'password'" name="password"
                                class="auth-input auth-input--with-icon auth-input--with-action"
                                placeholder="Enter your current password" required autocomplete="current-password" />
                            <button type="button" @click="show = !show" class="auth-input-action"
                                :aria-label="show ? 'Hide password' : 'Show password'">
                                <span x-show="!show" aria-hidden="true"><i data-lucide="eye-off"></i></span>
                                <span x-show="show" x-cloak aria-hidden="true"><i data-lucide="eye"></i></span>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="auth-field__error" />
                    </div>

                    <button type="submit" class="auth-submit auth-submit--primary">Confirm and continue</button>
                </form>
            </section>
        </div>
    </div>
</x-guest-layout>
