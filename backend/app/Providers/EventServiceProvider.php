<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

/**
 * EventServiceProvider
 *
 * Maps domain events to their listeners.
 * Listeners are registered as domain modules are implemented.
 */
class EventServiceProvider extends ServiceProvider
{
    /**
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        // Auth events
        // \App\Modules\Auth\Events\UserLoggedIn::class      => [\App\Modules\Audit\Listeners\LogAuthEvent::class],
        // \App\Modules\Auth\Events\UserLoggedOut::class     => [\App\Modules\Audit\Listeners\LogAuthEvent::class],

        // Lead events
        // \App\Modules\Leads\Events\LeadCreated::class      => [\App\Modules\Notifications\Listeners\NotifyLeadCreated::class],
        // \App\Modules\Leads\Events\LeadConverted::class    => [\App\Modules\Activities\Listeners\LogLeadConversion::class],
    ];

    public function boot(): void
    {
        parent::boot();
    }

    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
