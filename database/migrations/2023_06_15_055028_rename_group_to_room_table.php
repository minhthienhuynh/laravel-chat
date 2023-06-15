<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Dropping indexes
        Schema::table('group_user', function (Blueprint $table) {
            $table->dropForeign(['group_id']);
            $table->dropForeign(['user_id']);
            $table->dropPrimary(['group_id', 'user_id']);
        });

        Schema::table('messages', function (Blueprint $table) {
            $table->dropForeign(['group_id']);
        });

        Schema::table('groups', function (Blueprint $table) {
            $table->dropPrimary(['id']);
        });

        // Renaming tables
        Schema::rename('groups', 'rooms');
        Schema::rename('group_user', 'room_user');

        // Renaming columns & creating indexes
        Schema::table('rooms', function (Blueprint $table) {
            $table->primary(['id']);
        });

        Schema::table('messages', function (Blueprint $table) {
            $table->renameColumn('group_id', 'room_id');
            $table->foreign('room_id')->references('id')->on('rooms');
        });

        Schema::table('room_user', function (Blueprint $table) {
            $table->renameColumn('group_id', 'room_id');
            $table->foreign('room_id')->references('id')->on('rooms');
            $table->foreign('user_id')->references('id')->on('users');
            $table->primary(['room_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Dropping indexes
        Schema::table('room_user', function (Blueprint $table) {
            $table->dropForeign(['room_id']);
            $table->dropForeign(['user_id']);
            $table->dropPrimary(['room_id', 'user_id']);
        });

        Schema::table('messages', function (Blueprint $table) {
            $table->dropForeign(['room_id']);
        });

        Schema::table('rooms', function (Blueprint $table) {
            $table->dropPrimary(['id']);
        });

        // Renaming tables
        Schema::rename('rooms', 'groups');
        Schema::rename('room_user', 'group_user');

        // Renaming columns & creating indexes
        Schema::table('groups', function (Blueprint $table) {
            $table->primary(['id']);
        });

        Schema::table('messages', function (Blueprint $table) {
            $table->renameColumn('room_id', 'group_id');
            $table->foreign('group_id')->references('id')->on('groups');
        });

        Schema::table('group_user', function (Blueprint $table) {
            $table->renameColumn('room_id', 'group_id');
            $table->foreign('group_id')->references('id')->on('groups');
            $table->foreign('user_id')->references('id')->on('users');
            $table->primary(['group_id', 'user_id']);
        });
    }
};
