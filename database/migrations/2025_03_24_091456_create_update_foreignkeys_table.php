<?php

use App\Models\AppointStatus;
use App\Models\Department;
use App\Models\Station;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignIdFor(Department::class)->nullable();
            $table->foreignIdFor(Station::class)->nullable();
            $table->foreignIdFor(AppointStatus::class);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('update_foreignkeys');
    }
};
