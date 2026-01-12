<?php

namespace App\Http\Controllers\Auth;

use App\Models\hrd;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class HrdAuthController extends Controller
{
    public function ShowLogin() {
        return view('auth.hrd-login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        $hrd = Hrd::where('email', $request->email)->first();

        if (!$hrd || !Hash::check($request->password, $hrd->password)) {
            return back()->with('error', 'Email atau password salah');
        }

        session(['hrd_id' => $hrd->id]);

        return redirect('/hrd/dashboard');
    }

     public function logout()
    {
        session()->forget('hrd_id');
        return redirect('/hrd/login');
    }
}
