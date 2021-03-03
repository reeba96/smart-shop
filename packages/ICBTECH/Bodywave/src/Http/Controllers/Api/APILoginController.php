<?php

namespace ICBTECH\Bodywave\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Carbon\Carbon;

class APILoginController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
  
    public function login() {
        $credentials = request(['email', 'password']);
        if (!$token = auth()->guard('admin-api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return response()->json([
            'token' => $token,
            'expires_at' => Carbon::now()->addSeconds(auth()->guard('admin-api')->factory()->getTTL() * 60)->toDateTimeString(),
        ]);
    }
    
}
