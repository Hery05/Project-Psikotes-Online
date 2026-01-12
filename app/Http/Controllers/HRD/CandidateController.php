<?php

namespace App\Http\Controllers\HRD;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CandidateController extends Controller
{
    public function index()
    {
        $candidates = Candidate::latest()->get();

        return view('hrd.candidates.index', compact('candidates'));
    }

    public function create()
    {
        return view('hrd.candidates.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:candidates,email',
            'password' => 'required|min:6',
        ]);

        Candidate::create([
            'name'        => $request->name,
            'email'       => $request->email,
            'password'    => Hash::make($request->password),
            'is_finished' => 0,
        ]);

        return redirect()
            ->route('hrd.candidates.index')
            ->with('success', 'Kandidat berhasil ditambahkan');
    }
}
