<?php

namespace App\Http\Controllers\media;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ADController extends Controller
{
    public function index(){

        return view('media.create_ad');
    }
}
