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
            $table->boolean('is_assigned')->nullable();
            //failed at
            $table->date("breached_at")->nullable();
            $table->date("passed_at")->nullable();
            $table->foreignId("order_id")->nullable()->references("id")->on("orders")->onDelete("cascade");
            // tie to user
            $table->foreignId("user_id")->nullable()->constrained("users");
            $table->string("status")->default("inactive"); // active, inactive, breached, passed
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
