<x-guest-layout variant="login">
    <div class="login-container">
        <div class="lihok-outer">
            <div class="logo">
                <img src="{{ asset('images/logo-login.png') }}" alt="Logo" class="clogo" />
            </div>
            <div class="title">
                <p class="lihok">Lihok Padulong</p>
                <p class="mitcom" style="margin-top:.1px;">MITCOM MINGLANILLA</p>
            </div>
        </div>

        <div class="login-title">
            <div class="inner-login">
                <p class="login-des">Reset your Password</p>
                <p class="description">Create a new password to regain access to your account.</p>
            </div>
        </div>

        <x-auth-session-status class="auth-session-status" :status="session('status')" />

        <form method="POST" action="{{ route('password.store') }}" class="login-form">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <div class="input-group">
                <i data-lucide="mail" class="input-icon"></i>
                <input id="email" type="email" name="email" placeholder="Email address" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="input-error" />

            <!-- Password -->
            <div class="input-group" x-data="{ show: false }">
                <i data-lucide="lock" class="input-icon"></i>
                <input id="password" :type="show ? 'text' : 'password'" name="password" placeholder="New password" required autocomplete="new-password" />
                <button type="button" @click="show = !show" class="view-icon" aria-label="Toggle password visibility" style="background:none;border:none;padding:0;display:flex;align-items:center;">
                    <span x-show="!show"><i data-lucide="eye-off"></i></span>
                    <span x-show="show" x-cloak><i data-lucide="eye"></i></span>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="input-error" />

            <!-- Confirm Password -->
            <div class="input-group" x-data="{ show: false }">
                <i data-lucide="lock" class="input-icon"></i>
                <input id="password_confirmation" :type="show ? 'text' : 'password'" name="password_confirmation" placeholder="Confirm password" required autocomplete="new-password" />
                <button type="button" @click="show = !show" class="view-icon" aria-label="Toggle password visibility" style="background:none;border:none;padding:0;display:flex;align-items:center;">
                    <span x-show="!show"><i data-lucide="eye-off"></i></span>
                    <span x-show="show" x-cloak><i data-lucide="eye"></i></span>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="input-error" />

            <button type="submit" class="login-btn">Reset Password</button>
        </form>

        <div class="signup-footer">
            <a href="{{ route('login') }}" class="signup-link">Back to login</a>
        </div>
    </div>
</x-guest-layout>
