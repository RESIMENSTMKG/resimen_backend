<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Aktifkan uuid-ossp extension bila di postgres
        try {
            DB::statement('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');
        } catch (\Throwable $e) {
            // Ignore jika bukan superuser atau tidak didukung
        }

        // 1. Admins
        if (!Schema::hasTable('admins')) {
            Schema::create('admins', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('name', 100);
                $table->string('email', 150)->unique();
                $table->string('password_hash', 255);
                $table->string('role', 50)->default('editor');
                $table->timestampTz('created_at')->useCurrent();
            });
        }

        // 2. Members
        if (!Schema::hasTable('members')) {
            Schema::create('members', function (Blueprint $table) {
                $table->id();
                $table->string('name', 150);
                $table->string('role', 100);
                $table->string('title', 100)->nullable();
                $table->string('major', 100)->nullable();
                $table->text('photo_url')->nullable();
                $table->integer('order_index')->default(0);
                $table->timestampsTz();

                $table->index('order_index');
            });
        }

        // 3. Activities
        if (!Schema::hasTable('activities')) {
            Schema::create('activities', function (Blueprint $table) {
                $table->string('id', 100)->primary(); // Slug unik
                $table->string('title', 200);
                $table->string('category', 50);
                $table->date('event_date')->nullable();
                $table->string('location', 200)->nullable();
                $table->text('summary')->nullable();
                $table->text('description')->nullable();
                $table->string('template_type', 20)->default('grid');
                $table->text('cover_photo_url')->nullable();
                $table->jsonb('photos')->nullable();
                $table->timestampsTz();

                $table->index('category');
            });
        }

        // 4. One Gate Links
        if (!Schema::hasTable('one_gate_links')) {
            Schema::create('one_gate_links', function (Blueprint $table) {
                $table->id();
                $table->string('title', 200);
                $table->string('category', 50);
                $table->string('badge', 50)->nullable();
                $table->string('type', 50);
                $table->text('description')->nullable();
                $table->text('url');
                $table->integer('order_index')->default(0);
                $table->boolean('is_active')->default(true);
                $table->timestampTz('created_at')->useCurrent();

                $table->index('order_index');
            });
        }

        // 5. Committees
        if (!Schema::hasTable('committees')) {
            Schema::create('committees', function (Blueprint $table) {
                $table->id();
                $table->string('division', 100);
                $table->string('name', 150);
                $table->string('role', 100)->nullable();
                $table->string('major', 100)->nullable();
                $table->text('photo_url')->nullable();
                $table->timestampTz('created_at')->useCurrent();

                $table->index('division');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('committees');
        Schema::dropIfExists('one_gate_links');
        Schema::dropIfExists('activities');
        Schema::dropIfExists('members');
        Schema::dropIfExists('admins');
    }
};
