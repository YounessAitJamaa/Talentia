<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PremiumController extends Controller
{
    public function subscribe() {
        $user = Auth::user;
    }
}
