<?php

use App\Models\Student;
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
        Schema::table('achievements', function (Blueprint $table) {
            try {
                $table->dropForeign(['student_nis']);
            } catch (\Throwable $th) {
                echo $th . "\n";
            }
        });
        Schema::table('portfolios', function (Blueprint $table) {
            try {
                $table->dropForeign(['student_nis']);
            } catch (\Throwable $th) {
                echo $th . "\n";
            }
        });
        Schema::table('students', function (Blueprint $table) {
            $table->string('nis', 8)->change();
        });
        Schema::table('achievements', function (Blueprint $table) {
            $table->foreign('student_nis')->references('nis')->on('students')->nullOnDelete();
        });
        Schema::table('portfolios', function (Blueprint $table) {
            $table->foreign('student_nis')->references('nis')->on('students')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
