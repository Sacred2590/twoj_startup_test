<?php

namespace App\Listeners;

use App\Events\UserCreatedEvent;
use App\Notifications\WelcomeMail;

class SendUserCreatedNotification
{
   
    /**
     * Handle the event.
     * In case, when there will be NO email address, the notification will be skipped. 
     * Because of routeNotificationForMail method in User model.
     * @param UserCreatedEvent $event
     * @return void
     */
    public function handle(UserCreatedEvent $event): void
    {
        $event->user->notifyNow((new WelcomeMail())->delay(now()->addSeconds(5)));
    }
}

