<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PremiumController extends Controller
{
    public function subscribe() {
        $user = auth()->user();
        $sub = $user->subscription('default','price_1Szf9MK6HI9csIyLUxQ3Hh4D')->checkout([]);

    }
}
