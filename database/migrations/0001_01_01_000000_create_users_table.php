<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use MongoDB\Laravel\Schema\Blueprint;

return new class extends Migration
{
    protected $connection = 'mongodb';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $collection) {
            $collection->string('username')->unique();
            $collection->string('fullname');
            $collection->string('password');
            $collection->string('email')->unique();
            $collection->string('profileImage')->nullable();
            $collection->string('coverImage')->nullable();
            $collection->string('bio')->nullable();
            $collection->string('link')->nullable();
            $collection->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $collection) {
            $collection->string('email')->primary();
            $collection->string('token');
            $collection->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $collection) {
            $collection->string('id')->primary();
            $collection->foreignId('user_id')->nullable()->index();
            $collection->string('ip_address', 45)->nullable();
            $collection->text('user_agent')->nullable();
            $collection->longText('payload');
            $collection->integer('last_activity')->index();
        });

        Schema::create('user_follower', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('follower_id');
            $table->timestamps();

            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('follower_id')->references('id')->on('users')->onDelete('cascade');

            
            $table->unique(['user_id', 'follower_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
