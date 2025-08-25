<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    protected function index(Request $request){
        return view('index');
    }
    
}
