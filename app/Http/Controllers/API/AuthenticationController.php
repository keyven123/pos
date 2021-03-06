<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AuthenticationController extends Controller
{
    public function authenticate(Request $request)
    {
        if ($request->id) {

        } else {
            return User::with(['roles.permissions'])->findOrFail(auth()->user()->id);
        }
    }
}
