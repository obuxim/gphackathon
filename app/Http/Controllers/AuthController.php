<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller {
    public function register(Request $request)
    {
        $request->merge([
            'api_token' => Str::random(32),
            'password' => Hash::make($request->password)
        ]);
        return CrudController::store($request, "App\\Models\\Customer", null);
    }
    public function login(Request $request){
        $customer = Customer::where('email', $request->email)->first();
        if(Hash::check($request->password, $customer->password)){
            return $customer->api_token;
        }else{
            return response("No user found!", 401);
        }
    }
}
