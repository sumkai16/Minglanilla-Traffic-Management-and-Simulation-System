<x-guest-layout variant="login">
    <div class="register-container">
        <div class="lihok-outer">
            <div class="logo">
                <img src="{{ asset('images/logo-login.png') }}" alt="Logo" class="clogo" />
            </div>
            <div class="title">
                <p class="lihok">Lihok Padulong</p>
                <p class="mitcom">MITCOM MINGLANILLA</p>
            </div>
        </div>

        <div class="register-title">
            <div class="inner-register">
                <p class="register-des">Create your Account</p>
            </div>
            <div class="inner-welcome">
                <p class="register-welcome-des">Welcome! Please fill in your details to register:</p>
            </div>
        </div>

        @if ($errors->any())
            <div class="register-error-box">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="register-form">
            @csrf

            <div class="input-group name-row">
                <input
                    type="text"
                    name="first_name"
                    placeholder="First Name"
                    id="first_name"
                    value="{{ old('first_name') }}"
                    required
                    autofocus
                    autocomplete="given-name"
                />
                <input
                    type="text"
                    name="last_name"
                    placeholder="Last Name"
                    id="last_name"
                    value="{{ old('last_name') }}"
                    required
                    autocomplete="family-name"
                />
            </div>

            <div class="input-group">
                <i data-lucide="mail" class="input-icon"></i>
                <input
                    type="email"
                    name="email"
                    placeholder="Email address"
                    id="email"
                    value="{{ old('email') }}"
                    required
                    autocomplete="username"
                />
            </div>

            <div class="input-group" x-data="{ show: false }">
                <i data-lucide="lock" class="input-icon"></i>
                <input
                    type="password"
                    name="password"
                    placeholder="Password"
                    id="password"
                    required
                    autocomplete="new-password"
                    :type="show ? 'text' : 'password'"
                />
                <button type="button" @click="show = !show" class="view-icon" aria-label="Toggle password">
                    <span x-show="!show"><i data-lucide="eye-off"></i></span>
                    <span x-show="show" x-cloak><i data-lucide="eye"></i></span>
                </button>
            </div>

            <div class="input-group" x-data="{ show: false }">
                <i data-lucide="lock" class="input-icon"></i>
                <input
                    type="password"
                    name="password_confirmation"
                    placeholder="Confirm Password"
                    id="password_confirmation"
                    required
                    autocomplete="new-password"
                    :type="show ? 'text' : 'password'"
                />
                <button type="button" @click="show = !show" class="view-icon" aria-label="Toggle password">
                    <span x-show="!show"><i data-lucide="eye-off"></i></span>
                    <span x-show="show" x-cloak><i data-lucide="eye"></i></span>
                </button>
            </div>

            <button type="submit" class="register-btn">Register</button>
        </form>

        <div class="signup-footer">
            <p class="signup-text">Already have an account?</p>
            <a href="{{ route('login') }}" class="signup-link">Log in here</a>
        </div>
    </div>
</x-guest-layout>
