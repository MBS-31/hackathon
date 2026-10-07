<?php

use App\Abstracts\BaseModel;
use App\Abstracts\BaseRepository;
use App\Abstracts\BaseRequest;
use App\Abstracts\BaseResource;

/**
 * Unit Tests — Abstract Base Classes
 *
 * Verifies the abstracts exist and are structured correctly.
 */
describe('Architecture Abstracts', function () {

    it('BaseModel abstract class exists', function () {
        expect(class_exists(BaseModel::class))->toBeTrue();
    });

    it('BaseRepository abstract class exists', function () {
        expect(class_exists(BaseRepository::class))->toBeTrue();
    });

    it('BaseRequest abstract class exists', function () {
        expect(class_exists(BaseRequest::class))->toBeTrue();
    });

    it('BaseResource abstract class exists', function () {
        expect(class_exists(BaseResource::class))->toBeTrue();
    });

});

describe('Module Controller Stubs', function () {

    $modules = [
        'Auth'          => \App\Modules\Auth\Controllers\AuthController::class,
        'Users'         => \App\Modules\Users\Controllers\UserController::class,
        'Roles'         => \App\Modules\Roles\Controllers\RoleController::class,
        'Permissions'   => \App\Modules\Permissions\Controllers\PermissionController::class,
        'Leads'         => \App\Modules\Leads\Controllers\LeadController::class,
        'Contacts'      => \App\Modules\Contacts\Controllers\ContactController::class,
        'Accounts'      => \App\Modules\Accounts\Controllers\AccountController::class,
        'Opportunities' => \App\Modules\Opportunities\Controllers\OpportunityController::class,
        'Tasks'         => \App\Modules\Tasks\Controllers\TaskController::class,
        'Activities'    => \App\Modules\Activities\Controllers\ActivityController::class,
        'Communications'=> \App\Modules\Communications\Controllers\CommunicationController::class,
        'Documents'     => \App\Modules\Documents\Controllers\DocumentController::class,
        'Notifications' => \App\Modules\Notifications\Controllers\NotificationController::class,
        'Audit'         => \App\Modules\Audit\Controllers\AuditController::class,
    ];

    foreach ($modules as $name => $class) {
        it("$name controller class exists", function () use ($class) {
            expect(class_exists($class))->toBeTrue();
        });
    }
});
