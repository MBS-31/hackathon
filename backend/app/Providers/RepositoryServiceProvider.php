<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * RepositoryServiceProvider
 *
 * Binds repository interfaces to their concrete implementations.
 * New domain repository bindings are added here as modules are built.
 *
 * Pattern: Interface → EloquentRepository (can swap to any storage)
 */
class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * All interface → implementation bindings.
     *
     * @var array<class-string, class-string>
     */
    protected array $bindings = [
        // Auth / Users
        // \App\Modules\Users\Repositories\Contracts\UserRepositoryInterface::class
        //     => \App\Modules\Users\Repositories\EloquentUserRepository::class,

        // Roles
        // \App\Modules\Roles\Repositories\Contracts\RoleRepositoryInterface::class
        //     => \App\Modules\Roles\Repositories\EloquentRoleRepository::class,

        // Leads
        // \App\Modules\Leads\Repositories\Contracts\LeadRepositoryInterface::class
        //     => \App\Modules\Leads\Repositories\EloquentLeadRepository::class,

        // Contacts
        // \App\Modules\Contacts\Repositories\Contracts\ContactRepositoryInterface::class
        //     => \App\Modules\Contacts\Repositories\EloquentContactRepository::class,

        // Accounts
        // \App\Modules\Accounts\Repositories\Contracts\AccountRepositoryInterface::class
        //     => \App\Modules\Accounts\Repositories\EloquentAccountRepository::class,

        // Opportunities
        // \App\Modules\Opportunities\Repositories\Contracts\OpportunityRepositoryInterface::class
        //     => \App\Modules\Opportunities\Repositories\EloquentOpportunityRepository::class,

        // Tasks
        // \App\Modules\Tasks\Repositories\Contracts\TaskRepositoryInterface::class
        //     => \App\Modules\Tasks\Repositories\EloquentTaskRepository::class,

        // Activities
        // \App\Modules\Activities\Repositories\Contracts\ActivityRepositoryInterface::class
        //     => \App\Modules\Activities\Repositories\EloquentActivityRepository::class,

        // Communications
        // \App\Modules\Communications\Repositories\Contracts\CommunicationRepositoryInterface::class
        //     => \App\Modules\Communications\Repositories\EloquentCommunicationRepository::class,

        // Documents
        // \App\Modules\Documents\Repositories\Contracts\DocumentRepositoryInterface::class
        //     => \App\Modules\Documents\Repositories\EloquentDocumentRepository::class,

        // Notifications
        // \App\Modules\Notifications\Repositories\Contracts\NotificationRepositoryInterface::class
        //     => \App\Modules\Notifications\Repositories\EloquentNotificationRepository::class,

        // Audit
        // \App\Modules\Audit\Repositories\Contracts\AuditRepositoryInterface::class
        //     => \App\Modules\Audit\Repositories\EloquentAuditRepository::class,
    ];

    public function register(): void
    {
        foreach ($this->bindings as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }
    }

    public function boot(): void
    {
        //
    }
}
