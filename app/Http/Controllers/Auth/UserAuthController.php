<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * PHP Version 7.3.26
 * 
 * @category Controller
 * @package  App\Http\Controllers\Auth
 * @author   Eulogio Ramos <esramosc@gmail.com>
 * @license  proprietary software
 * @link     localhost
 */
class UserAuthController extends Controller
{
    /**
     * Login function
     * 
     * @param LoginRequest $request The request with credentials
     * 
     * @return response The response with error message or access info
     */
    public function login(LoginRequest $request)
    {
        $credentials = request(['email', 'password']);
        if (!auth()->attempt($credentials)) {
            return response(
                [
                    'error' => 'Invalid Credentials. Please try again'
                ],
                500
            );
        }
        $user = $request->user();
        
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        $token->save();

        return response()->json(
            [
                'access_token' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse(
                    $token->expires_at
                )->toDateTimeString()
            ]
        );
    }

    /**
     * Logout User Session
     * 
     * @param $request The request
     * 
     * @return json
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json('Successfully logged out');
    }
}
