<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnEmployyeShiftTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_shifts', function (Blueprint $table) {
            $table->string('color')->nullable();
            $table->string('initial')->nullable();
            $table->time('time_start')->nullable();
            $table->time('time_end')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee_shifts', function (Blueprint $table) {
            $table->dropColumn('icon')->nullable();
            $table->dropColumn('color')->nullable();
            $table->dropColumn('initial')->nullable();
            $table->dropColumn('time_start')->nullable();
            $table->dropColumn('time_end')->nullable();
            
        });
    }
}
