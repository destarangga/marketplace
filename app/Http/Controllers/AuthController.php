<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function index(){
        return view('auth.login');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'alamat' => 'nullable|string|max:255',
            'no_telepon' => 'nullable|string|max:15',
            'deskripsi' => 'nullable|string',
            'role' => 'required|string|in:customer,merchant', 
        ]);

        User::create([
            'company_name' => $request->company_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'alamat' => $request->alamat,
            'no_telepon' => $request->no_telepon,
            'deskripsi' => $request->deskripsi,
            'role' => $request->role, 
        ]);

        return redirect()->route('login')->with('success', 'Registration successful, please login.');
    }

    // Login pengguna
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            $user = auth()->user();

            // Redirect ke halaman dashboard setelah login
            return redirect()->route('dashboard')->with('message', 'Login successful');
        }

        return redirect()->back()->with('error', 'Email atau Password salah');
    }

    // Logout pengguna
    public function logout()
    {
        auth()->logout();

        // Redirect ke halaman tertentu setelah logout
        return redirect()->route('login')->with('message', 'User logged out successfully');
    }

    public function pengguna(){
        $user = User::all();
        return view('customer', compact('customer'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('pengguna')->with('success', 'Pengguna berhasil dihapus.');
    }

    public function show()
    {
        return view('profile.show', [
            'user' => Auth::user(),
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'nullable|string|min:6|confirmed',
            'alamat' => 'nullable|string|max:255',
            'no_telepon' => 'nullable|string|max:15',
            'deskripsi' => 'nullable|string',
        ]);

        $user = Auth::user();
        $user->company_name = $request->input('company_name');
        $user->email = $request->input('email');
        $user->alamat = $request->input('alamat');
        $user->no_telepon = $request->input('no_telepon');
        $user->deskripsi = $request->input('deskripsi');

        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        $user->save();

        return redirect()->route('profile.show')->with('success', 'Profil berhasil diperbarui.');
    }


}
