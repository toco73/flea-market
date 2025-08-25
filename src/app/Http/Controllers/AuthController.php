<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function index(){
        $user = Auth::user();
        return view('/mypage',compact('user'));
    }
}
