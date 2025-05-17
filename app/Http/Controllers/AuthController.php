<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\Server;


class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
            'role' => 'required|in:IT Support,Admin GA'
        ]);

        $credentials = $request->only(['username', 'password']);
        $user = User::where('username', $request->username)
            ->where('role', $request->role)
            ->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            return redirect()->route('dashboard');
        }

        return redirect()->back()->withErrors(['loginError' => 'Akun tidak sesuai']);
    }

    public function dashboard()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $serverCounts = Server::select('owner_project')
            ->selectRaw('count(*) as total')
            ->groupBy('owner_project')
            ->get();

        return view('dashboard', compact('serverCounts'));
    }


    public function logout()
    {
        Auth::logout();
        Session::flush();  // Menghapus semua session
        return redirect()->route('login')->with('status', 'Anda telah logout.');
    }

    public function dataServer()
    {
        return view('server_inventory');
    }
}
