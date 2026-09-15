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
        Schema::table('destinations', function (Blueprint $table) {
            $table->string('location')->nullable()->after('duration');
            $table->decimal('rating', 3, 1)->nullable()->after('price_child');
            $table->json('quick_facts')->nullable()->after('includes');
            $table->json('highlights')->nullable()->after('quick_facts');
            $table->json('itinerary')->nullable()->after('highlights');
            $table->json('excluded')->nullable()->after('includes');
            $table->json('faqs')->nullable()->after('excluded');
            $table->json('gallery')->nullable()->after('faqs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('destinations', function (Blueprint $table) {
            $table->dropColumn(['location', 'rating', 'quick_facts', 'highlights', 'itinerary', 'excluded', 'faqs', 'gallery']);
        });
    }
};