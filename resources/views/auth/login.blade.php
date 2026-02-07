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
                <p class="login-des">Log in to your Account</p>
            </div>
            <!-- <div class="inner-welcome-back">
                <p class="login-welcome-des">Welcome back! Select a method to log in:</p>
            </div> -->
        </div>

        <x-auth-session-status class="auth-session-status" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="login-form">
            @csrf

            <div class="input-group">
                <i data-lucide="mail" class="input-icon"></i>
                <input id="email" type="email" name="email" placeholder="Email address" value="{{ old('email') }}" required autofocus autocomplete="username" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="input-error" />

            <div class="input-group" x-data="{ show: false }">
                <i data-lucide="lock" class="input-icon"></i>
                <input id="password" :type="show ? 'text' : 'password'" name="password" placeholder="Password" required autocomplete="current-password" />
                <button type="button" @click="show = !show" class="view-icon" aria-label="Toggle password visibility" style="background:none;border:none;padding:0;display:flex;align-items:center;">
                    <span x-show="!show"><i data-lucide="eye-off"></i></span>
                    <span x-show="show" x-cloak><i data-lucide="eye"></i></span>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="input-error" />

            <div class="remember-forgot">
                <label class="inner-remember" for="remember_me">
                    <input id="remember_me" type="checkbox" name="remember"  />
                    <span style="margin-left:4px; color: rgb(48, 48, 48);">Remember me</span>
                </label>
                @if (Route::has('password.request'))
                    <div class="inner-forgot">
                        <a class="forgot-link" href="{{ route('password.request') }}">Forgot Password</a>
                    </div>
                @endif
            </div>

            <button type="submit" class="login-btn">Log In</button>
        </form>

        <div class="signup-footer">
            <p class="signup-text">Don't have an account?</p>
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="signup-link">Sign up here</a>
            @endif
        </div>
    </div>
</x-guest-layout>
