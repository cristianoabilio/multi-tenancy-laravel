<?php

namespace App\Listeners;

use App\Enums\RoleEnum;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SetCompanyIdInSession
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        switch ($event->user->role_id) {
            case RoleEnum::MANAGER:
            case RoleEnum::SELLER:
                session()->put('company_id', $event->user->seller->company_id);
                break;
            case RoleEnum::CLIENT:
                session()->put('company_id', $event->user->client->company_id);
                break;
        }
    }
}
