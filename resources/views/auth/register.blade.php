@extends('layouts.backend-blank')

@section('content')

    <main 
        class="d-flex 
                flex-column 
                align-items-center 
                justify-content-center
                auth-box"
    >
        <form class="text-center" method="POST" action="{{ route('register') }}">
            @csrf

            <input type="hidden" name="device_name" value="{{ $deviceName }}">

            @include('auth.logo', ['class' => 'w-25'])

            <div class="card">
                <div class="card-body">

                    @include('auth.errors', ['errors' => $errors])

                    <div class="form-floating mb-3">
                        <input 
                            type="text" 
                            class="form-control" 
                            id="first-name" 
                            name="first_name"
                            value="{{ old('first_name') }}"
                            placeholder="Type your name..."
                            required
                            autofocus
                        >
                        <label for="first-name">{{ __('First name') }}</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input 
                            type="text" 
                            class="form-control" 
                            id="last-name" 
                            name="last_name"
                            value="{{ old('last_name') }}"
                            placeholder="Type your name..."
                            required
                            autofocus
                        >
                        <label for="last-name">{{ __('Last name') }}</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input 
                            type="email" 
                            class="form-control" 
                            id="email" 
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="Type email..."
                            required
                            autofocus
                        >
                        <label for="email">{{ __('Email address') }}</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input 
                            type="password" 
                            class="form-control" 
                            id="password"
                            name="password" 
                            placeholder="Type password..."
                            autocomplete="new-password"
                            required
                        >
                        <label for="password">{{ __('Password') }}</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input 
                            type="password" 
                            class="form-control" 
                            id="password_confirmation"
                            name="password_confirmation" 
                            placeholder="Retype password..."
                            autocomplete="new-password"
                            required
                        >
                        <label for="password_confirmation">
                            {{ __('Confirm Password') }}
                        </label>
                    </div>

                    <button class="w-100 btn btn-lg btn-primary" type="submit">
                        {{ __('Register') }}
                    </button>

                    <a href="{{ route('login') }}" class="btn btn-link text-secondary">
                        {{ __('Already registered?') }}
                    </a>
                </div>
            </div>
            
        </form>

        <p class="mt-5 mb-3 text-muted">©2021</p>
    </main>

@endsection