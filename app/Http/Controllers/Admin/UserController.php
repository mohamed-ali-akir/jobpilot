<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Role;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.users.index', ['users' => User::orderBy('name')->get(), 'roles' => Role::cases()]);
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate(['role' => ['required', Rule::enum(Role::class)]]);

        if ($user->is($request->user())) {
            return back()->with('error', 'Vous ne pouvez pas modifier votre propre rôle.');
        }

        $user->role = $request->enum('role', Role::class); // affectation explicite (pas fillable)
        $user->save();

        return back()->with('success', "Rôle de {$user->name} mis à jour.");
    }
}
