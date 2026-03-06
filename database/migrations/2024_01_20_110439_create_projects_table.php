<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('projects', static function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('organization_id');
            $table->unsignedBigInteger('client_id')->nullable();
            $table->string('name', 255);
            $table->string('color', 16);
            $table->integer('billable_rate')->unsigned()->nullable();
            $table->boolean('is_public')->default(false);
            $table->boolean('is_billable')->nullable();
            $table->dateTime('archived_at')->nullable();
            $table->integer('estimated_time')->unsigned()->nullable();
            $table->unsignedBigInteger('spent_time')->default(0);
            $table->foreign('organization_id')
                ->references('id')
                ->on('organizations')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->foreign('client_id')
                ->references('id')
                ->on('clients')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
