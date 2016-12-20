<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTaskPriority extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tasks', function ($table) {
            $table->integer('priority')->after('state_id');
        });
        Schema::table('task_states', function ($table) {
            $table->integer('priority')->after('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tasks', function($table){
            $table->dropColumn('priority');
        });
        Schema::table('task_states', function($table){
            $table->dropColumn('priority');
        });
    }
}
