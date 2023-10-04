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
        Schema::create('product_threes', function (Blueprint $table) {
            $table->id();
            $table->string("account_number")->nullable();
            $table->string("traders_password")->nullable();
            $table->string('server');
            $table->string('leverage');
            $table->string("mode");
            $table->date("purchased_at")->nullable();
            $table->date("failed_at")->nullable();


            // tie to user
            $table->foreignId("user_id")->nullable()->constrained("users");
            $table->string("status")->default("inactive"); // active, inactive, failed, failed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_threes');
    }
};
