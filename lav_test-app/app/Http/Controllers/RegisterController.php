<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function show() {
        return view('register');
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
        'name' => 'required|string',
        'username' => 'required|unique:users',
        'phone' => 'required',
        'whatsapp' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|string|min:6',
        'address' => 'nullable|string',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048'
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    // Call the API
    $response = Http::withHeaders([
        'Content-Type' => 'application/json',
        'X-RapidAPI-Key' => config('services.whatsapp.key'),
        'X-RapidAPI-Host' => config('services.whatsapp.host')
    ])->post(config('services.whatsapp.url'), [
        'phone_numbers' => [$request->whatsapp]
    ]);

    $apiData = $response->json();

    $valid = false;
    foreach ($apiData as $item) {
        if ($item['phone_number'] == $request->whatsapp && $item['status'] == 'valid') {
            $valid = true;
            break;
        }
    }

    if (!$valid) {
        return response()->json(['error' => 'Invalid WhatsApp number'], 422);
    }

    // Image upload
    $filename = null;
    if ($request->hasFile('image')) {
        $filename = $request->file('image')->store('uploads', 'public');
    }

    $user = User::create([
        'name' => $request->name,
        'username' => $request->username,
        'phone' => $request->phone,
        'whatsapp' => $request->whatsapp,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'image' => $filename,
        'address' => $request->address
    ]);

    return response()->json(['success' => true, 'user' => $user]);
}

}