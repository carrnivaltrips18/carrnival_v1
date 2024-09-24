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
        Schema::table('company_details', function (Blueprint $table) {
            $table->string('fav_icon')->default('https://carnivaltrips.com/favicon.ico'); // Favicon
            $table->string('phone')->default('+1234567890'); // Example phone number
            $table->text('address')->default('202 Dimand Plaza, Nager Bazar, Wst Bengal India'); // Company address
            $table->text('description')->default('Carnival Trips offers the best travel experiences, tours, and adventures across the globe.'); // Company description
            $table->string('facebook')->default('https://facebook.com/carnivaltrips'); // Facebook URL
            $table->string('twitter')->default('https://twitter.com/carnivaltrips'); // Twitter URL
            $table->string('linkedin')->default('https://linkedin.com/carnivaltrips'); // Twitter URL
            $table->string('instagram')->default('https://instagram.com/carnivaltrips'); // Instagram URL
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('company_details', function (Blueprint $table) {
            $table->dropColumn('fav_icon');
            $table->dropColumn('phone');
            $table->dropColumn('address');
            $table->dropColumn('description');
            $table->dropColumn('facebook');
            $table->dropColumn('twitter');
            $table->dropColumn('linkedin');
            $table->dropColumn('instagram');
        });
    }
};
