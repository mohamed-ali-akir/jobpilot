@extends('layouts.app')
@section('title', 'Gestion des utilisateurs')
@section('content')
    <flux:heading size="xl" level="1" class="mb-6">Gestion des utilisateurs</flux:heading>
    <flux:table>
        <flux:table.columns>
            <flux:table.column>Nom</flux:table.column>
            <flux:table.column>E-mail</flux:table.column>
            <flux:table.column>Rôle</flux:table.column>
        </flux:table.columns>
        <flux:table.rows>
            @foreach ($users as $user)
                <flux:table.row>
                    <flux:table.cell>{{ $user->name }}</flux:table.cell>
                    <flux:table.cell>{{ $user->email }}</flux:table.cell>
                    <flux:table.cell>
                        <form method="POST" action="{{ route('admin.users.role', $user) }}">
                            @csrf
                            @method('PATCH')
                            <select name="role" onchange="this.form.submit()" class="rounded border px-2 py-1 dark:bg-zinc-800"
                                    @disabled($user->is(auth()->user()))>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->value }}" @selected($user->role === $role)>{{ $role->label() }}</option>
                                @endforeach
                            </select>
                        </form>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>
@endsection