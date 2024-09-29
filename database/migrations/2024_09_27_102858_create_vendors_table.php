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
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->enum('vendor_type', ['individual', 'national']);
            $table->enum('company_type', ['BUMN', 'CV', 'PT']);
            $table->string('identity_number')->nullable();
            $table->string('npwp');
            $table->boolean('approved')->default(false);
            $table->unsignedBigInteger('user_id')->nullable(); // Foreign key referencing the users table
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Foreign key constraint
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vendors', function (Blueprint $table) {
            $table->dropForeign(['user_id']); // Drop foreign key constraint first
        });
        Schema::dropIfExists('vendors');
    }
};
