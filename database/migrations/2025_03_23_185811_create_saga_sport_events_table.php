<?php

use App\Models\SagaSport;
use App\Models\SportEvent;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('saga_sport_events', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(SagaSport::class);
            $table->foreignIdFor(SportEvent::class);
            $table->tinyInteger('total_district_must_join')->default(0);
            $table->boolean('qualification_round')->default(true);
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
        Schema::dropIfExists('saga_sport_events');
    }
};
