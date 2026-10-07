<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Create audit_logs table
 *
 * Captures all system events for compliance and traceability.
 * Module-specific business events (lead created, contact updated) are
 * recorded here by the AuditLogger middleware and domain event listeners.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->string('event');
            $table->string('auditable_type')->nullable()->comment('Polymorphic: model class name');
            $table->unsignedBigInteger('auditable_id')->nullable()->comment('Polymorphic: model ID');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->string('url')->nullable();
            $table->string('method', 10)->nullable();
            $table->jsonb('old_values')->nullable()->comment('State before change');
            $table->jsonb('new_values')->nullable()->comment('State after change');
            $table->jsonb('metadata')->nullable()->comment('Extra context');
            $table->timestamp('created_at')->useCurrent();

            $table->index(['auditable_type', 'auditable_id'], 'audit_auditable_index');
            $table->index('user_id');
            $table->index('event');
            $table->index('created_at');
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
