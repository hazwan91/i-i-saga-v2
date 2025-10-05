<?php

use App\Models\District;
use App\Models\Saga;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('saga_districts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Saga::class);
            $table->foreignIdFor(District::class);
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saga_districts');
    }
};
