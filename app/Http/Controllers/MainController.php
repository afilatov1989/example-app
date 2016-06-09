<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class MainController extends Controller
{

    /**
     * handles the main layout of AngularJS application
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function spa()
    {

        return view('spa');
    }
}
