<?php

namespace App\Http\Controllers;


class PremiumController extends Controller
{
    public function subscribe(){
        $user = auth()->user();
        return $user->newSubscription('default','price_1Szf9MK6HI9csIyLUxQ3Hh4D')
            ->checkout(['success_url'=>route('sucess'),'cancel_url'=>route('cancel')]);
    }
}
