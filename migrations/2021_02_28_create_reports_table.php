<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;

return [
    'up' => function (Builder $schema) {
        $schema->create('clarkwinkelmann_reports', function (Blueprint $table) {
            $table->increments('id');
            $table->string('subject_type')->index();
            $table->string('subject_id')->index();
            $table->unsignedInteger('user_id')->nullable();
            $table->string('reason')->nullable()->index();
            $table->text('comment')->nullable();
            $table->text('moderator_notes')->nullable();
            $table->timestamps();
            $table->unsignedInteger('resolved_user_id')->nullable();
            $table->timestamp('resolved_at')->nullable()->index();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('resolved_user_id')->references('id')->on('users')->onDelete('set null');
        });
    },
    'down' => function (Builder $schema) {
        $schema->dropIfExists('clarkwinkelmann_reports');
    },
];
