<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->unsignedBigInteger('destination_id')->nullable()->after('id');
        });

        DB::table('bookings')
            ->whereNull('destination_id')
            ->update(['destination_id' => DB::raw('(SELECT d.id FROM destinations d WHERE d.name = bookings.tour_name LIMIT 1)')]);

        Schema::table('bookings', function (Blueprint $table) {
            $table->foreign('destination_id')->references('id')->on('destinations')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['destination_id']);
            $table->dropColumn('destination_id');
        });
    }
};
