@extends('layouts.backend-blank')

@section('content')

    <main 
        class="d-flex 
                flex-column 
                align-items-center 
                justify-content-center
                auth-box"
    >
        <div class="card">
            <div class="card-body">
                <div class="mb-3 fs-6 text-secondary">
                    {{ __('Thank you for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                </div>

                @if (session('status') == 'verification-link-sent')
                    <div class="mb-4 fs-6 text-success">
                        {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                    </div>
                @endif
                
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf

                    <div>
                        <button class="w-100 btn btn-lg btn-primary" type="submit">
                            {{ __('Resend Verification Email') }}
                        </button>
                    </div>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit" class="btn btn-link">
                        {{ __('Log out') }}
                    </button>
                </form>
            </div>
        </div>

        <p class="mt-5 mb-3 text-muted">©2021</p>
    </main>

@endsection