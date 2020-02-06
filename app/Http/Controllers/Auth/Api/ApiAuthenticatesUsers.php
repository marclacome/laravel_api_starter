<?php

namespace App\Http\Controllers\Auth\Api;

use App\User;
use Cookie;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

trait ApiAuthenticatesUsers
{
    use AuthenticatesUsers {
        AuthenticatesUsers::sendLoginResponse as APISendLoginResponse;
        AuthenticatesUsers::logout as APIlogout;
    }
    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return  \Illuminate\Http\Response
     */

    protected function sendLoginResponse(Request $request)
    {
        $user = User::where("email", $request->email)->first();
        $token = $user->createToken('api_token');
        $token->token->save();
        return response()->json(['logged_on' => 'OK'])->cookie('_token', $token->accessToken);
    }

    /**
     * logout
     *
     * @param  \Illuminate\Http\Request  $request
     * @return  \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $user = $request->user();
        $user->token()->revoke();
        $user->token()->delete();

        return response()->json([
            'logged_out' => 'OK',
        ])->cookie(Cookie::forget('_token'));
    }
}
