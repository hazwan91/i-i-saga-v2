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
        Schema::create('sagas', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name')->unique();
            $table->string('year', 10)->unique();
            $table->date('date_start_rs')->nullable();
            $table->date('date_end_rs')->nullable();
            $table->date('date_start_rse')->nullable();
            $table->date('date_end_rse')->nullable();
            $table->date('date_start_rtech_qualification')->nullable();
            $table->date('date_end_rtech_qualification')->nullable();
            $table->date('date_start_rtech_saga')->nullable();
            $table->date('date_end_rtech_saga')->nullable();
            $table->date('date_start_rcom_qualification')->nullable();
            $table->date('date_end_rcom_qualification')->nullable();
            $table->date('date_start_rcom_saga')->nullable();
            $table->date('date_end_rcom_saga')->nullable();
            $table->date('date_start_rcl')->nullable();
            $table->date('date_end_rcl')->nullable();
            $table->date('date_start_rsl')->nullable();
            $table->date('date_end_rsl')->nullable();
            $table->date('date_start_qr')->nullable();
            $table->date('date_end_qr')->nullable();
            $table->date('date_start_qrr')->nullable();
            $table->date('date_end_qrr')->nullable();
            $table->date('date_start_sr')->nullable();
            $table->date('date_end_sr')->nullable();
            $table->date('date_start_srr')->nullable();
            $table->date('date_end_srr')->nullable();
            $table->string('registration_sport')->nullable();
            $table->json('rs_district_involves')->nullable();
            $table->date('date_start_rs_period')->nullable();
            $table->date('date_end_rs_period')->nullable();
            $table->string('registration_sport_event')->nullable();
            $table->json('rse_district_involves')->nullable();
            $table->date('date_start_rse_period')->nullable();
            $table->date('date_end_rse_period')->nullable();
            $table->string('registration_technical_qualification')->nullable();
            $table->json('rtech_qualification_district_involves')->nullable();
            $table->date('date_start_rtech_qualification_period')->nullable();
            $table->date('date_end_rtech_qualification_period')->nullable();
            $table->string('registration_technical_saga')->nullable();
            $table->json('rtech_saga_district_involves')->nullable();
            $table->date('date_start_rtech_saga_period')->nullable();
            $table->date('date_end_rtech_saga_period')->nullable();
            $table->string('registration_commitee_qualification')->nullable();
            $table->json('rcom_qualification_district_involves')->nullable();
            $table->date('date_start_rcom_qualification_period')->nullable();
            $table->date('date_end_rcom_qualification_period')->nullable();
            $table->string('registration_commitee_saga')->nullable();
            $table->json('rcom_saga_district_involves')->nullable();
            $table->date('date_start_rcom_saga_period')->nullable();
            $table->date('date_end_rcom_saga_period')->nullable();
            $table->string('registration_contingent_longlist')->nullable();
            $table->json('rcl_district_involves')->nullable();
            $table->date('date_start_rcl_period')->nullable();
            $table->date('date_end_rcl_period')->nullable();
            $table->string('registration_contingent_shortlist')->nullable();
            $table->json('rcs_district_involves')->nullable();
            $table->date('date_start_rsl_period')->nullable();
            $table->date('date_end_rsl_period')->nullable();
            $table->string('registration_qualification_round')->nullable();
            $table->json('rqr_district_involves')->nullable();
            $table->date('date_start_qr_period')->nullable();
            $table->date('date_end_qr_period')->nullable();
            $table->string('registration_qualification_round_result')->nullable();
            $table->json('rqrr_district_involves')->nullable();
            $table->date('date_start_qrr_period')->nullable();
            $table->date('date_end_qrr_period')->nullable();
            $table->string('registration_saga_round')->nullable();
            $table->json('rsr_district_involves')->nullable();
            $table->date('date_start_sr_period')->nullable();
            $table->date('date_end_sr_period')->nullable();
            $table->string('registration_saga_round_result')->nullable();
            $table->json('rsrr_district_involves')->nullable();
            $table->date('date_start_srr_period')->nullable();
            $table->date('date_end_srr_period')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sagas');
    }
};
