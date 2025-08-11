<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate();

        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'role'     => ['required', Rule::in(['admin','dinas', 'pengelola'])],
        ]);

        $user = new User();
        $user->name              = $validated['name'];
        $user->email             = $validated['email'];
        $user->phone             = $validated['phone'];
        $user->email_verified_at = today();
        $user->password          = Hash::make($validated['password']);
        $user->role              = $validated['role'];          // pastikan kolom `role` ada di tabel users
        // $user->email_verified_at = now(); // kalau ingin auto-verified, buka baris ini
        $user->save();

        return redirect()
            ->route('admin.users.index')
            ->with([
                'message'    => 'User berhasil dibuat.',
                'alert-type' => 'success',
            ]);
    }

     /** Form edit */
     public function edit(Request $request, $id)
     {
        $user = User::findOrFail($id);
         return view('users.edit', compact('user'));
     }
 
     /** Update user */
     public function update(Request $request, User $user)
     {
         $validated = $request->validate([
             'name'  => ['required', 'string', 'max:255'],
             'email' => ['required', 'email', 'max:255', Rule::unique('users','email')->ignore($user->id)],
             'role'  => ['required', Rule::in(['admin','dinas', 'pengelola'])],
             // password opsional saat edit
             'password' => ['nullable', 'string', 'min:6'],
         ]);
 
         $user->name  = $validated['name'];
         $user->email = $validated['email'];
         $user->phone = $validated['phone'];
         $user->role  = $validated['role'];
         if (!empty($validated['password'])) {
             $user->password = Hash::make($validated['password']);
         }
         $user->save();
 
         return redirect()
             ->route('admin.users.index')
             ->with([
                 'message'    => 'User berhasil diperbarui.',
                 'alert-type' => 'success',
             ]);
     }
 
     /** Hapus user */
     public function destroy(User $user)
     {
         $user->delete();
 
         return back()->with([
             'message'    => 'User berhasil dihapus.',
             'alert-type' => 'success',
         ]);
     }
}
