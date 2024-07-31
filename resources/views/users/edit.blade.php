@extends('layouts.admin')

@section('content')
    <div class="d-flex flex-column align-items-center min-vh-100"
        style="background: linear-gradient(to bottom, #f8f9fa, #e0e0e0);">
        <div class="w-100 d-flex justify-content-start mb-3" style="position: absolute; top: 20px; left: 20px;">
            <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Volver a usuarios
            </a>
        </div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header text-center">
                            <h1>Editar Usuario</h1>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('users.update', $user) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <!-- Nombre -->
                                <div class="form-group">
                                    <label for="name">Nombre</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        value="{{ $user->name }}" required>
                                </div>

                                <!-- Email -->
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" id="email" class="form-control"
                                        value="{{ $user->email }}" required>
                                </div>

                                <!-- Contraseña -->
                                <div class="form-group">
                                    <label for="password">Contraseña (deja en blanco para mantener la actual)</label>
                                    <input type="password" name="password" id="password" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="password_confirmation">Confirmar Contraseña</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        class="form-control">
                                </div>

                                <!-- Rol -->
                                <div class="form-group">
                                    <label for="role">Rol</label>
                                    <select name="role" id="role" class="form-control" required>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->name }}"
                                                {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Avatar -->
                                <div class="form-group">
                                    <label for="avatar">Selecciona un Avatar</label>
                                    <select name="avatar" id="avatar" class="form-control">
                                        <option value="">-- Selecciona un avatar --</option>
                                        @foreach ($avatars as $avatar)
                                            <option value="{{ $avatar->getUrl() }}"
                                                {{ $user->hasMedia('avatars') && $user->getFirstMediaUrl('avatars') === $avatar->getUrl() ? 'selected' : '' }}
                                                data-image="{{ $avatar->getUrl() }}">
                                                <img src="{{ $avatar->getUrl() }}" alt="{{ $avatar->name }}"
                                                    width="50" style="margin-right: 10px;">
                                                {{ $avatar->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <img id="selected-avatar" src="{{ $user->getFirstMediaUrl('avatars') }}"
                                        alt="User Avatar" class="img-thumbnail mt-2" width="100"
                                        style="display: {{ $user->hasMedia('avatars') ? 'block' : 'none' }};">
                                    <input type="file" name="custom_avatar" id="custom_avatar"
                                        class="form-control-file mt-2">
                                </div>

                                <div class="form-group text-center">
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.getElementById('avatar').addEventListener('change', function() {
                const selectedAvatar = this.options[this.selectedIndex];
                const imageUrl = selectedAvatar.getAttribute('data-image');
                const imgElement = document.getElementById('selected-avatar');

                if (imageUrl) {
                    imgElement.src = imageUrl;
                    imgElement.style.display = 'block';
                } else {
                    imgElement.style.display = 'none';
                }
            });
        </script>
    @endpush
@endsection
