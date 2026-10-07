<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

/**
 * AuthServiceProvider
 *
 * Registers model policies for CRM domain entities.
 * Policies are added as domain modules are implemented.
 */
class AuthServiceProvider extends ServiceProvider
{
    /**
     * Map models to their policy classes.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // \App\Modules\Users\Models\User::class              => \App\Modules\Users\Policies\UserPolicy::class,
        // \App\Modules\Leads\Models\Lead::class              => \App\Modules\Leads\Policies\LeadPolicy::class,
        // \App\Modules\Contacts\Models\Contact::class        => \App\Modules\Contacts\Policies\ContactPolicy::class,
        // \App\Modules\Accounts\Models\Account::class        => \App\Modules\Accounts\Policies\AccountPolicy::class,
        // \App\Modules\Opportunities\Models\Opportunity::class => \App\Modules\Opportunities\Policies\OpportunityPolicy::class,
        // \App\Modules\Tasks\Models\Task::class              => \App\Modules\Tasks\Policies\TaskPolicy::class,
        // \App\Modules\Documents\Models\Document::class      => \App\Modules\Documents\Policies\DocumentPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
