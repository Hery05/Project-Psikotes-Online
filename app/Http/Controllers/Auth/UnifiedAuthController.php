<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Hrd;
use App\Models\Candidate;

class UnifiedAuthController extends Controller
{
    /**
     * Tampilkan halaman login (HRD & Kandidat)
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Proses login HRD / Kandidat
     */
    public function login(Request $request)
    {
        // validasi dasar
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        $email    = $request->email;
        $password = $request->password;

        // =====================
        // LOGIN HRD
        // =====================
        $hrd = Hrd::where('email', $email)->first();

        if ($hrd && Hash::check($password, $hrd->password)) {
            session()->flush(); // bersihkan session lama
            session(['hrd_id' => $hrd->id]);

            return redirect('/hrd/dashboard');
        }

        // =====================
        // LOGIN KANDIDAT
        // =====================
        $candidate = Candidate::where('email', $email)->first();

        if ($candidate && Hash::check($password, $candidate->password)) {

            // kandidat hanya boleh login jika belum selesai
            if ($candidate->is_finished) {
                return back()->with('error', 'Tes sudah selesai. Login ditolak.');
            }

            session()->flush();
            session(['candidate_id' => $candidate->id]);

            return redirect('/candidate/dashboard');
        }

        return back()->with('error', 'Email atau password salah');
    }

    /**
     * Logout (HRD & Kandidat)
     */
    public function logout()
    {
        session()->flush();
        return redirect('/login');
    }
}
