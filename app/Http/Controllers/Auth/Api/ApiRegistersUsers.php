<?php

namespace App\Http\Controllers\Auth\Api;

use App\Http\Requests\RegisterRequest;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

trait ApiRegistersUsers
{
    use RegistersUsers {
        RegistersUsers::registered as myRegistered;
        RegistersUsers::register as myRegister;
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\User $user
     * @return  \Illuminate\Http\Response
     */
    protected function registered(Request $request, $user)
    {
        return response()->json(['registered' => 'OK']);
    }

    /**
     * register
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function register(RegisterRequest $request)
    {
        event(new Registered($user = $this->create($request->all())));
        return $this->registered($request, $user);
    }

}
