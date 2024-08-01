@extends('layouts.admin')

@section('content')
    <div class="d-flex flex-column align-items-center min-vh-100"
        style="background: linear-gradient(to bottom, #f8f9fa, #e0e0e0);">
        <div class="w-100 d-flex justify-content-start mb-3" style="position: absolute; top: 20px; left: 20px;">
            <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Volver a Usuarios
            </a>
        </div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header text-center">
                            <h1>Mostrar Usuario</h1>
                        </div>
                        <div class="card-body">
                            <div class="text-center mb-3">
                                @if ($user->avatar)
                                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}"
                                        class="img-fluid rounded-circle" style="width: 150px; height: 150px;">
                                @else
                                    <img src="{{ asset('storage/avatars/default-avatar.png') }}" alt="Default Avatar"
                                        class="img-fluid rounded-circle" style="width: 150px; height: 150px;">
                                @endif
                            </div>
                            <div class="mb-3">
                                <strong>Nombre:</strong>
                                <p class="mb-0">{{ $user->name }}</p>
                            </div>
                            <div class="mb-3">
                                <strong>Email:</strong>
                                <p class="mb-0">{{ $user->email }}</p>
                            </div>
                            <div class="mb-3">
                                <strong>Roles:</strong>
                                <p class="mb-0">{{ implode(', ', $user->roles->pluck('name')->toArray()) }}</p>
                            </div>
                            <div class="text-center">
                                <a href="{{ route('users.edit', $user) }}" class="btn btn-warning">Editar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
