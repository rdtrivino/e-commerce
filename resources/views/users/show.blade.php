@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">
                        <h1>Show User</h1>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <strong>Name:</strong>
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
                            <a href="{{ route('users.edit', $user) }}" class="btn btn-warning">Edit</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
