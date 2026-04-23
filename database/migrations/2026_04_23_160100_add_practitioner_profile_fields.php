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
        Schema::table('users', function (Blueprint $table) {
            $table->string('practitioner_type')->default('doctor')->after('email');
            $table->string('phone')->nullable()->after('practitioner_type');
            $table->string('qualification')->nullable()->after('phone');
            $table->string('specialization')->nullable()->after('qualification');
            $table->string('registration_no')->nullable()->after('specialization');
            $table->string('chamber_address')->nullable()->after('registration_no');
            $table->text('bio')->nullable()->after('chamber_address');
        });

        Schema::table('histories', function (Blueprint $table) {
            $table->foreignId('practitioner_user_id')->nullable()->after('appointment_id')->constrained('users')->nullOnDelete();
            $table->string('practitioner_type')->default('doctor')->after('practitioner_user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('histories', function (Blueprint $table) {
            $table->dropForeign(['practitioner_user_id']);
            $table->dropColumn(['practitioner_user_id', 'practitioner_type']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'practitioner_type',
                'phone',
                'qualification',
                'specialization',
                'registration_no',
                'chamber_address',
                'bio',
            ]);
        });
    }
};
