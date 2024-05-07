<div class="mb-3">
    <label class="form-label" for="userName">名前</label>
    <input type="text" name="name" value="{{ old('name', $user->name) }}" id="userName"
        class="form-control @error('name') is-invalid @enderror">
    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="mb-3">
    <label class="form-label" for="userEmail">メールアドレス</label>
    <input type="text" name="email" value="{{ old('email', $user->email) }}" id="userEmail"
        class="form-control @error('email') is-invalid @enderror">
    @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

@if (Auth::user() != $user)
    <div class="mb-3">
        <label class="form-label" for="userRole">権限</label>
        <select name="role" value="{{ old('role', $user->role) }}" id="userRole"
            class="form-control @error('role') is-invalid @enderror">
            @foreach (App\Models\UserRole::values() as $role)
                <option value="{{ $role }}" @selected(intval(old('role', $user->role?->value)) === $role)>@lang("model.enum.user_roles.{$role}")</option>
            @endforeach
        </select>
        @error('role')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
@endif
