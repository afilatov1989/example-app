<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;

class MainController extends Controller
{

    /**
     * handles the main layout of AngularJS application
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function spa(User $user = null)
    {

        return view('spa');
    }
}
