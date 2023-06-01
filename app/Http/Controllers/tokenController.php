<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TokenController extends Controller
{
    public function getCsrfToken(Request $request)
    {
        return response()->json([
            'csrf_token' => $request->session()->token(),
        ]);
    }
}