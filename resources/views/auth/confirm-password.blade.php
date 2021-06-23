@extends('layouts.backend-blank')

@section('content')

    <main 
        class="d-flex 
                flex-column 
                align-items-center 
                justify-content-center
                auth-box"
    >
        <form class="text-center" method="POST" action="{{ route('password.confirm') }}">
            @csrf

            @include('auth.logo', ['class' => 'w-25'])

            <div class="card">
                <div class="card-body">

                    <div class="text-secondary mb-3">
                        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
                    </div>

                    @include('auth.errors', ['errors' => $errors])

                    <div class="form-floating mb-3">
                        <input 
                            type="password" 
                            class="form-control" 
                            id="password" 
                            name="password"
                            placeholder="Type password..."
                            autocomplete="current-password"
                            required
                        >
                        <label for="password">{{ __('Password') }}</label>
                    </div>

                    <button class="w-100 btn btn-lg btn-primary" type="submit">
                        {{ __('Confirm') }}
                    </button>
                </div>
            </div>
            
        </form>

        <p class="mt-5 mb-3 text-muted">©2021</p>
    </main>

@endsection