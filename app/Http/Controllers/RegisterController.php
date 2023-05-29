<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Auth\AuthRequest;
use Exception;

class RegisterController extends Controller
{
    public function __invoke(AuthRequest $request)
    {  
        $data = $request->validated();
        $result = $this->create($data);
         
        return $result;
    }

    public function create(array $data)
    {
        if (!User::where('email', $data['email'])->first()) {
          $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
          ]);

          $token = auth()->attempt(['email' => $data['email'], 'password' => $data['password']]);

          return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => $user
          ]);
        } else {
          return response()->json(['message' => 'User with this email is already exist'], 409);
        }
    }    
}
