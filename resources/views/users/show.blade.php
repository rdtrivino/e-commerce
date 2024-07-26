@extends('layouts.app')

@section('content')
    <h1>Show User</h1>
    <p>Name: {{ $user->name }}</p>
    <p>Email: {{ $user->email }}</p>
    <p>Roles: {{ implode(', ', $user->roles->pluck('name')->toArray()) }}</p>
    <a href="{{ route('users.edit', $user) }}" class="btn btn-warning">Edit</a>
@endsection
