<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{
    public function user(Request $request)
    {
        return $request->user();
    }

    public function example(Request $request)
    {
        return response()->json(['message' => 'This is an example API endpoint.']);
    }
}
