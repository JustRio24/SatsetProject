<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class SuperAdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_direksi' => User::where('role', 'direksi')->count(),
            'total_gm' => User::where('role', 'gm')->count(),
            'total_manager' => User::where('role', 'manager_area')->count(),
            'total_korlap' => User::where('role', 'korlap')->count(),
            'total_worker' => User::where('role', 'worker')->count(),
        ];

        return view('superadmin.dashboard', compact('stats'));
    }

    public function users(Request $request)
    {
        $query = User::query();

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('area', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->paginate(15);
        
        $roles = [
            'superadmin' => 'Super Admin',
            'direksi' => 'Direksi',
            'gm' => 'General Manager',
            'finance' => 'Finance Admin',
            'manager_area' => 'Manager Area',
            'korlap' => 'Korlap',
            'worker' => 'Pekerja Lapangan'
        ];

        return view('superadmin.users.index', compact('users', 'roles'));
    }

    public function createUser()
    {
        $roles = [
            'superadmin' => 'Super Admin',
            'direksi' => 'Direksi',
            'gm' => 'General Manager',
            'finance' => 'Finance Admin',
            'manager_area' => 'Manager Area',
            'korlap' => 'Korlap',
            'worker' => 'Pekerja Lapangan'
        ];
        return view('superadmin.users.create', compact('roles'));
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'area' => $request->area,
            'business_line' => $request->business_line,
            'position' => $request->position,
            'phone' => $request->phone,
        ]);

        return redirect()->route('superadmin.users')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function editUser(User $user)
    {
        $roles = [
            'superadmin' => 'Super Admin',
            'direksi' => 'Direksi',
            'gm' => 'General Manager',
            'finance' => 'Finance Admin',
            'manager_area' => 'Manager Area',
            'korlap' => 'Korlap',
            'worker' => 'Pekerja Lapangan'
        ];
        return view('superadmin.users.edit', compact('user', 'roles'));
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'role' => ['required', 'string'],
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'area' => $request->area,
            'business_line' => $request->business_line,
            'position' => $request->position,
            'phone' => $request->phone,
        ];

        if ($request->filled('password')) {
            $request->validate([
                'password' => ['confirmed', Rules\Password::defaults()],
            ]);
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('superadmin.users')->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function deleteUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();
        return back()->with('success', 'Pengguna berhasil dihapus.');
    }
}
