<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Exception;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);
        return view('master.user.index', compact('users'));
    }

    public function create()
    {
        return view('master.user.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ]);

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $user->assignRole('pengunjung');

            return redirect()->route('users.index')->with('success', 'Pengguna berhasil ditambahkan.');
        } catch (Exception $e) {
            Log::error('Error saat menambahkan pengguna: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    public function edit(User $user)
    {
        return view('master.user.form', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        try {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            return redirect()->route('users.index')->with('success', 'Pengguna berhasil diperbarui.');
        } catch (Exception $e) {
            Log::error('Error saat memperbarui pengguna: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Terjadi kesalahan saat memperbarui data.');
        }
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:admin,pengunjung',
        ]);

        try {
            $user->syncRoles([$request->role]);

            return redirect()->route('users.index')->with('success', 'Role pengguna berhasil diperbarui.');
        } catch (Exception $e) {
            Log::error('Error saat memperbarui role: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memperbarui role.');
        }
    }


    public function destroy(User $user)
    {
        if (auth()->user()->id === $user->id) {
            return redirect()->route('users.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        try {
            $user->delete();
            return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus.');
        } catch (Exception $e) {
            Log::error('Error saat menghapus pengguna: ' . $e->getMessage());
            return redirect()->route('users.index')->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }
}
