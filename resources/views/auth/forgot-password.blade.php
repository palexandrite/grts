@extends('layouts.backend-blank')

@section('content')

    <main 
        class="d-flex 
                flex-column 
                align-items-center 
                justify-content-center
                auth-box"
    >
        <form class="text-center" method="POST" action="{{ route('password.email') }}">
            @csrf

            @include('auth.logo', ['class' => 'w-25'])

            <div class="card">
                <div class="card-body">

                    <div class="text-muted mb-3">
                        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                    </div>

                    @include('auth.auth-session-status', ['status' => session('status')])

                    @include('auth.errors', ['errors' => $errors])

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

                    <button class="w-100 btn btn-lg btn-primary" type="submit">
                        {{ __('Email Password Reset Link') }}
                    </button>
                </div>
            </div>
            
        </form>

        <p class="mt-5 mb-3 text-muted">©2021</p>
    </main>

@endsection