<?php

namespace App\Listeners;

use App\Events\UserDeletedEvent;

class RemoveUserArtifactsListener
{
  
    /**
     * @param UserDeletedEvent $event
     * @return void
     * Handle the event.
     */
    public function handle(UserDeletedEvent $event): void
    {
        $event->user->artifacts()->delete();
    }
}
