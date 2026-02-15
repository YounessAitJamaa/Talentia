<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\PremiumExpiringSoonNotification;
use Illuminate\Console\Command;
use Carbon\Carbon;


class SendPremiumExpiryReminders extends Command
{
    protected $signature = 'premium:send-expiry-reminders';
    protected $description = 'Send an email 7 days before premium expiry';

    public function handle(): int
    {
        $start = Carbon::now()->addDays(7)->startOfDay();
        $end   = Carbon::now()->addDays(7)->endOfDay();

        User::query()
            ->whereNotNull('premium_ends_at')
            ->whereBetween('premium_ends_at', [$start, $end])
            ->whereNull('premium_reminder_sent_at')
            ->chunkById(200, function ($users) {
                foreach ($users as $user) {
                    
                    $user->notify(new PremiumExpiringSoonNotification($user->premium_ends_at));



                    // marquer comme envoyé (évite spam)
                    $user->forceFill([
                        'premium_reminder_sent_at' => now(),
                    ])->save();
                }
            });

        $this->info('Reminders processed.');
        return self::SUCCESS;
    }
}
