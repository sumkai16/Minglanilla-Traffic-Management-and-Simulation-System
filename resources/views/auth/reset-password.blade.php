<<<<<<< HEAD
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
<<<<<<< HEAD
                <p class="description">Create a new password to regain access to your account.</p>
=======
                <p class="description color text-[#C2C2C2] text-xs">Create a new password to regain access to your
                    account.</p>
>>>>>>> 5279ad827b2b9563ccc4049f839b6abaf4fbee60
            </div>
        </div>

        <x-auth-session-status class="auth-session-status" :status="session('status')" />

        <form method="POST" action="{{ route('password.store') }}" class="login-form">
            @csrf
=======
<x-guest-layout>
    <form method="POST" action="{{ route('password.store') }}">
        @csrf
>>>>>>> f964e373c81bdcf9ae60400d4fb733d02b9f3304

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

<<<<<<< HEAD
            <!-- Email Address -->
            <div class="input-group">
                <i data-lucide="mail" class="input-icon"></i>
<<<<<<< HEAD
                <input id="email" type="email" name="email" placeholder="Email address" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" />
=======
                <input id="email" type="email" name="email" placeholder="Email address"
                    value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" />
>>>>>>> 5279ad827b2b9563ccc4049f839b6abaf4fbee60
            </div>
            <x-input-error :messages="$errors->get('email')" class="input-error" />

            <!-- Password -->
            <div class="input-group" x-data="{ show: false }">
                <i data-lucide="lock" class="input-icon"></i>
<<<<<<< HEAD
                <input id="password" :type="show ? 'text' : 'password'" name="password" placeholder="New password" required autocomplete="new-password" />
                <button type="button" @click="show = !show" class="view-icon" aria-label="Toggle password visibility" style="background:none;border:none;padding:0;display:flex;align-items:center;">
=======
                <input id="password" :type="show ? 'text' : 'password'" name="password" placeholder="New password"
                    required autocomplete="new-password" />
                <button type="button" @click="show = !show" class="view-icon" aria-label="Toggle password visibility"
                    style="background:none;border:none;padding:0;display:flex;align-items:center;">
>>>>>>> 5279ad827b2b9563ccc4049f839b6abaf4fbee60
                    <span x-show="!show"><i data-lucide="eye-off"></i></span>
                    <span x-show="show" x-cloak><i data-lucide="eye"></i></span>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="input-error" />

            <!-- Confirm Password -->
            <div class="input-group" x-data="{ show: false }">
                <i data-lucide="lock" class="input-icon"></i>
<<<<<<< HEAD
                <input id="password_confirmation" :type="show ? 'text' : 'password'" name="password_confirmation" placeholder="Confirm password" required autocomplete="new-password" />
                <button type="button" @click="show = !show" class="view-icon" aria-label="Toggle password visibility" style="background:none;border:none;padding:0;display:flex;align-items:center;">
=======
                <input id="password_confirmation" :type="show ? 'text' : 'password'" name="password_confirmation"
                    placeholder="Confirm password" required autocomplete="new-password" />
                <button type="button" @click="show = !show" class="view-icon" aria-label="Toggle password visibility"
                    style="background:none;border:none;padding:0;display:flex;align-items:center;">
>>>>>>> 5279ad827b2b9563ccc4049f839b6abaf4fbee60
                    <span x-show="!show"><i data-lucide="eye-off"></i></span>
                    <span x-show="show" x-cloak><i data-lucide="eye"></i></span>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="input-error" />
=======
        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
>>>>>>> f964e373c81bdcf9ae60400d4fb733d02b9f3304

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>
    </div>
<<<<<<< HEAD
<<<<<<< HEAD
</x-guest-layout>
=======
</x-guest-layout>
>>>>>>> 5279ad827b2b9563ccc4049f839b6abaf4fbee60
=======
</x-guest-layout>
>>>>>>> f964e373c81bdcf9ae60400d4fb733d02b9f3304
