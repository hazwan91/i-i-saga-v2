<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('saga_registration_contingent_longlists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('saga_registration_sport_id')->constrained();
            $table->foreignId('race_id')->constrained();
            $table->foreignId('current_district_id')->constrained('district');
            $table->foreignId('place_of_birth_id')->constrained('district');
            $table->string('ic', 20)->nullable()->unique();
            $table->string('passport', 50)->nullable()->unique();
            $table->string('name')->unique();
            $table->string('acreditation_name');
            $table->date('dob');
            $table->tinyInteger('age');
            $table->decimal('height', 3, 2);
            $table->decimal('weight', 3, 2);
            $table->boolean('is_malaysia')->default(false);
            $table->text('address');
            $table->string('house_tel_no', 30);
            $table->string('hp_no', 30);
            $table->enum('sex', ["LELAKI", "WANITA"]);
            $table->enum('t_shirt_size', ["2XS", "XS", "S", "M", "L", "XL", "2XL", "3XL", "4XL", "5XL", "6XL"]);
            $table->enum('tracksuit_size', ["2XS", "XS", "S", "M", "L", "XL", "2XL", "3XL", "4XL", "5XL", "6XL"]);
            $table->enum('shoe_size', ["3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15"]);
            $table->text('saga_involvement');
            $table->text('sukma_involvement');
            $table->text('highest_involvement_in_sport');
            $table->string('ic_image');
            $table->string('passport_image');
            $table->json('vaccination_image')->nullable();
            $table->boolean('queried')->default(false);
            $table->boolean('verified')->default(false);
            $table->boolean('reject')->default(false);
            $table->text('reject_remark')->nullable();
            $table->boolean('shortlist')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saga_registration_contingent_longlists');
    }
};
