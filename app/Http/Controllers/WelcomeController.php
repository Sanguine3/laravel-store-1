<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class WelcomeController extends Controller
{
    public function index(): \Inertia\Response
    {
        return Inertia::render('Welcome');
    }
} 