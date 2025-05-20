<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;


class UserController extends Controller
{

    public function checkUsername(Request $request) {
    $username = $request->input('username');

    $exists = \App\Models\User::where('username', $username)->exists();

    if ($exists) {
        return response('taken', 200);
    } else {
        return response('available', 200);
    }
}
}
