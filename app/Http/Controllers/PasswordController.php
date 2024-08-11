<?php

namespace App\Http\Controllers;

use App\Services\PasswordGenerator;
use Illuminate\Http\Request;

class PasswordController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function generate(Request $request)
    {
        $generator = new PasswordGenerator(
            $request->input('length', 8),
            $request->has('use_small'),
            $request->has('use_capital'),
            $request->has('use_numbers'),
            $request->has('use_symbols')
        );

        $password = $generator->generate();

        return back()->with('generated_password', $password);
    }
}
