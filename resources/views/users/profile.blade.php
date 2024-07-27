<form action="{{ route('user.update.avatar') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <input type="file" name="avatar" accept="image/*">
    <button type="submit">Upload Avatar</button>
</form>

@if (Auth::user()->getAvatarUrl())
    <img src="{{ Auth::user()->getAvatarUrl() }}" alt="User Avatar"
        style="width: 100px; height: 100px; border-radius: 50%;">
@endif
