@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-start mb-4">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary" title="Volver al Dashboard">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
        <h1 class="text-center mb-4">Usuarios</h1>
        <div class="d-flex justify-content-center mb-4">
            <a href="{{ route('users.create') }}" class="btn btn-primary">Crear Usuario</a>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Avatar</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>
                                @if ($user->avatar)
                                    <img src="{{ asset('storage/' . str_replace('storage/', '', $user->avatar)) }}"
                                        alt="User Avatar" class="img-fluid rounded-circle"
                                        style="width: 50px; height: 50px;">
                                @else
                                    <img src="{{ asset('storage/avatars/default-avatar.png') }}" alt="Default Avatar"
                                        class="img-fluid rounded-circle" style="width: 50px; height: 50px;">
                                @endif
                            </td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td class="text-center">
                                <a href="{{ route('users.show', $user) }}" class="btn btn-info btn-sm">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('users.edit', $user) }}" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('users.destroy', $user) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
