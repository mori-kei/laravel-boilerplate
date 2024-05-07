<x-layout>
    <x-slot name="title">User: (id:{{ $user->id }})</x-slot>
    <h2><a href="{{ route('admin.users.index') }}">Admin/Users</a> / {{ $user->name }}(id:{{ $user->id }})</h2>
    <x-mini-panel>
        <div class="mb-3">
            <dl>
                <dt>名前</dt>
                <dd>{{ $user->name }}</dd>
            </dl>
        </div>
        <div class="mb-3">
          <dl>
              <dt>権限</dt>
              <dd>@lang("model.enum.user_roles.{$user->role->value}")</dd>
          </dl>
      </div>
      <div class="mb-3">
        <dl>
            <dt>Email</dt>
            <dd>{{ $user->email }}</dd>
        </dl>
    </div>
</x-mini-panel>
</x-layout>
