<?php

namespace App\Http\Controllers\Auth;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    public function edit(Request $request)
    {
        return view('profile.change-password', [
            'user' => $request->user(),
        ]);
    }


    public function update(ChangePasswordRequest $request)
    {
        try {

            $request->user()->update([
                'password' => Hash::make($request->password),
            ]);

            return back()->with('status', 'password-updated');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
