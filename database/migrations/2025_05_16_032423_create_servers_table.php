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
        Schema::create('servers', function (Blueprint $table) {
            $table->id();
            $table->string('hostname');
            $table->string('type');
            $table->string('ip');
            $table->string('serial_number')->unique();
            $table->string('location');
            $table->string('unit_revision');
            $table->string('image_version');
            $table->string('site_version');
            $table->string('installed_probes');
            $table->string('owner_project');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servers');
    }
};
