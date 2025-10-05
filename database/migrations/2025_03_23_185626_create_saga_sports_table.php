<?php

use App\Models\Saga;
use App\Models\Sport;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('saga_sports', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Saga::class);
            $table->foreignIdFor(Sport::class);
            $table->boolean('lelaki')->default(true);
            $table->boolean('wanita')->default(true);
            $table->tinyInteger('total_district_must_join')->default(10);
            $table->tinyInteger('total_sport_event_can_be_played_by_participant')->default(1);
            $table->boolean('qualification_round')->default(false);
            $table->json('image')->nullable();
            $table->json('quota')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saga_sports');
    }
};
