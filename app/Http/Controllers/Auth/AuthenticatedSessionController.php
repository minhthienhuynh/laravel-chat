<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): JsonResponse
    {
        $request->authenticate();

        $token = $request->user()->createToken($request->email);

        return response()->json([
            'access_token' => $token->plainTextToken,
            'expires_in' => config('sanctum.expiration'),
            'user' => $request->user(),
        ]);
    }

    /**
     * Destroy an authenticated token.
     */
    public function destroy(Request $request): JsonResponse
    {
        // Revoke the token that was used to authenticate the current request...
        $request->user()->currentAccessToken()->delete();

        return response()->json([], JsonResponse::HTTP_NO_CONTENT);
    }
}
