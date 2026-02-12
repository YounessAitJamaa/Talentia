<?php

namespace App\Http\Controllers;


class PremiumController extends Controller
{
    public function subscribe(){
        $user = auth()->user();
    return $subscription = $user->newSubscription('monthly','price_1Szf9MK6HI9csIyLUxQ3Hh4D')
            ->checkout(['success_url'=>route('sucess'),'cancel_url'=>route('cancel')]);
    }
    public function sucess() {
        $user = auth()->user();
        $user->hasPremium = true;
        $user->save();
        return view('sucess_payement');
    }
}
