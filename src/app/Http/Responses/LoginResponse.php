<?php

namespace App\Http\Response;

use Lalavel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $user = $request->user();

        if (!$user->is_profile_completed){
            return redirect()->route('profile.edit');
        }
        return redirect('/');
    }
}