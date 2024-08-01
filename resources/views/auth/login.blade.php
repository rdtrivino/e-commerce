@extends('layouts.login')

@section('content')
    <div class="container custom-login-container">
        <div class="d-flex justify-content-start mt-4">
            <a class="btn btn-secondary" href="{{ url('/') }}" style="position: absolute; top: 20px; left: 20px;">
                <i class="bi bi-arrow-left-circle"></i> {{ __('Volver') }}
            </a>
        </div>

        <div class="row justify-content-center mt-5">
            <div class="col-md-5">
                <div class="card shadow-lg border-0 rounded-lg custom-card-width">
                    <div class="card-header bg-primary text-white text-center">
                        <h4>{{ __('INICIAR SESIÓN') }}</h4>
                    </div>

                    <div class="card-body p-3">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-group mb-3">
                                <label for="email" class="form-label">{{ __('Email') }}</label>
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="password" class="form-label">{{ __('Contraseña') }}</label>
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password" required
                                    autocomplete="current-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    {{ __('Recordar') }}
                                </label>
                            </div>

                            <div class="d-flex justify-content-center mb-3">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Iniciar') }}
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="card-footer text-center py-3">
                        <small class="text-muted">
                            {{ date('d M Y') }}
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
