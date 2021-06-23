@extends('layouts.backend-blank')

@section('content')

    <main 
        class="d-flex 
                flex-column 
                align-items-center 
                justify-content-center
                auth-box"
    >
        <form class="text-center" method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            @include('auth.logo', ['class' => 'w-25'])

            <div class="card">
                <div class="card-body">

                    @include('auth.errors', ['errors' => $errors])

                    <div class="form-floating mb-3">
                        <input 
                            type="email" 
                            class="form-control" 
                            id="email" 
                            name="email"
                            value="{{ old('email', $request->email) }}"
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
                        {{ __('Reset Password') }}
                    </button>
                </div>
            </div>
            
        </form>

        <p class="mt-5 mb-3 text-muted">©2021</p>
    </main>

@endsection