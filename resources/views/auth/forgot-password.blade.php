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
<<<<<<< HEAD
  
            <div class="inner-login">
                <p class="login-des">Forgot your password?</p>
               
            </div>
            
=======

            <div class="inner-login">
                <p class="login-des">Forgot your password?</p>

            </div>

>>>>>>> 5279ad827b2b9563ccc4049f839b6abaf4fbee60
        </div>

        <x-auth-session-status class="auth-session-status" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}" class="login-form">
            @csrf

            <div class="input-group">
                <i data-lucide="mail" class="input-icon"></i>
<<<<<<< HEAD
                <input id="email" type="email" name="email" placeholder="Email address" value="{{ old('email') }}" required autofocus />
=======
                <input id="email" type="email" name="email" placeholder="Email address" value="{{ old('email') }}"
                    required autofocus />
>>>>>>> 5279ad827b2b9563ccc4049f839b6abaf4fbee60
            </div>
            <x-input-error :messages="$errors->get('email')" class="input-error" />

            <button type="submit" class="login-btn">Send Reset Link</button>
        </form>

        <div class="signup-footer">
            <a href="{{ route('login') }}" class="signup-link">Back to login</a>
        </div>
    </div>
<<<<<<< HEAD
</x-guest-layout>
=======
</x-guest-layout>
>>>>>>> 5279ad827b2b9563ccc4049f839b6abaf4fbee60
