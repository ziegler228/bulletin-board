<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\JsonResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param  string $token
     * @return JsonResponse
     */
    public function __invoke(string $token)
    {
        $user = User::where('verify_token', $token)->firstOrFail();

        try {
            $user->verify();

            return response()->json(['success' => true]);

        } catch (\DomainException $e) {
            return response()->json(['success' => false]);
        }
    }
}
