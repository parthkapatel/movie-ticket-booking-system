<?php

namespace App\Http\Controllers;

use App\Models\City;
use http\Env\Url;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware("isAdmin");
    }

    public function index(){
        return view("index");
    }


}
