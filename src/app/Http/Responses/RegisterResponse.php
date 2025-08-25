<?php

namespace App\Http\Response;

use Lalavel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;

class RegisterResponse implements RegisterResponseContract
{
    public function toResponse($request)
    {
        if (is_null($request->user()->profile_completed_at)){
            return redirect()->route('profile.edit');
        }
        return redirect()->intended(config('fortify.home'));
    }
}