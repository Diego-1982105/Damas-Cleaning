<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::query()
            ->orderBy('name')
            ->paginate(25);

        return view('admin.users.index', [
            'users' => $users,
            'roleLabels' => User::roleLabels(),
        ]);
    }

    public function create(): View
    {
        return view('admin.users.create', [
            'roleLabels'       => User::roleLabels(),
            'permissionLabels' => User::permissionLabels(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'email'       => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password'    => ['required', 'string', 'min:8', 'confirmed'],
            'role'        => ['required', 'string', Rule::in(array_keys(User::roleLabels()))],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['string', Rule::in(array_keys(User::permissionLabels()))],
        ]);

        User::create([
            'name'        => $validated['name'],
            'email'       => $validated['email'],
            'password'    => Hash::make($validated['password']),
            'role'        => $validated['role'],
            'permissions' => $validated['role'] === 'staff' ? ($validated['permissions'] ?? []) : null,
        ]);

        return redirect()
            ->route('admin.usuarios.index')
            ->with('status', 'User created successfully.');
    }

    public function edit(User $user): View
    {
        return view('admin.users.edit', [
            'user'             => $user,
            'roleLabels'       => User::roleLabels(),
            'permissionLabels' => User::permissionLabels(),
        ]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password'      => ['nullable', 'string', 'min:8', 'confirmed'],
            'role'          => ['required', 'string', Rule::in(array_keys(User::roleLabels()))],
            'permissions'   => ['nullable', 'array'],
            'permissions.*' => ['string', Rule::in(array_keys(User::permissionLabels()))],
        ]);

        if ($this->isLastOwner($user) && $validated['role'] === 'staff') {
            return redirect()
                ->route('admin.usuarios.edit', $user)
                ->with('error', 'At least one owner is required. Create another owner or assign the role before changing this user to staff.');
        }

        $user->name  = $validated['name'];
        $user->email = $validated['email'];
        $user->role  = $validated['role'];
        // Owners get null (all access); staff get the checked permissions.
        $user->permissions = $validated['role'] === 'staff' ? ($validated['permissions'] ?? []) : null;

        if (! empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()
            ->route('admin.usuarios.index')
            ->with('status', 'User updated successfully.');
    }

    public function toggleActive(Request $request, User $user): RedirectResponse
    {
        if ($user->is($request->user())) {
            return redirect()
                ->route('admin.usuarios.index')
                ->with('error', 'You cannot disable your own account.');
        }

        if ($user->active && $this->isLastActiveOwner($user)) {
            return redirect()
                ->route('admin.usuarios.index')
                ->with('error', 'At least one active owner is required. Enable another owner first.');
        }

        $user->update(['active' => ! $user->active]);

        $label = $user->active ? 'enabled' : 'disabled';

        return redirect()
            ->route('admin.usuarios.index')
            ->with('status', "User \"{$user->name}\" {$label}.");
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        if ($this->isLastOwner($user)) {
            return redirect()
                ->route('admin.usuarios.index')
                ->with('error', 'You cannot delete the only owner in the system.');
        }

        if ($user->is($request->user())) {
            return redirect()
                ->route('admin.usuarios.index')
                ->with('error', 'You cannot delete your own account here.');
        }

        $user->delete();

        return redirect()
            ->route('admin.usuarios.index')
            ->with('status', 'User deleted.');
    }

    private function isLastOwner(User $user): bool
    {
        return $user->role === 'owner'
            && User::query()->where('role', 'owner')->count() === 1;
    }

    private function isLastActiveOwner(User $user): bool
    {
        return $user->role === 'owner'
            && User::query()->where('role', 'owner')->where('active', true)->count() === 1;
    }
}
