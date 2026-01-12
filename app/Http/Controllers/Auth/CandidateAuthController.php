<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Candidate;
use Illuminate\Support\Facades\Hash;

class CandidateAuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.candidate-login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        $candidate = Candidate::where('email', $request->email)->first();

        if (!$candidate || !Hash::check($request->password, $candidate->password)) {
            return back()->with('error', 'Login gagal');
        }

        if ($candidate->is_finished) {
            return back()->with('error', 'Tes sudah selesai, login ditutup');
        }

        session(['candidate_id' => $candidate->id]);

        return redirect('/candidate/dashboard');
    }

    public function logout()
    {
        session()->forget('candidate_id');
        return redirect('/candidate/login');
    }
}
