<?php

namespace App\Http\Controllers\Web;

use Inertia\Inertia;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{

    /**
     * Method used to display the home page.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        return Inertia::render('Home/Index');
    }
}
