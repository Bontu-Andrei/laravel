<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'password' => 'required'
        ]);

        if ($request->input('name') !== config('admin.name') ||
            $request->input('password') !== config('admin.password')) {
            return redirect()->back()
                ->withInput()
                ->withErrors([
                    'login' => ['These credentials don\'t match our records.']
                ]);
        }

        session()->put('admin', 1);

        return redirect()->route('products');
    }

    public function destroy()
    {
        session()->forget('admin');

        return redirect()->route('index');
    }
}
