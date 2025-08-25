<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);

        Fortify::registerView(function(){
            return view('auth.register');
        });

        Fortify::loginView(function(){
            return view('auth.login');
        });

        
        Fortify::verifyEmailView(function(){
            return view('auth.verify');
        });

        Fortify::authenticateUsing(function(Request $request){
            app(LoginRequest::class)->validateResolved();
            $credentials = $request->only('email','password');
            if(Auth::attempt($credentials,$request->boolean('remember'))){
                return Auth::user();
            }
        });
        
        RateLimiter::for('login',function(Request $request){
            $email = (string) $request->email;
            return Limit::perMinute(10)->by($email . $request->ip());
        });
    }
}
