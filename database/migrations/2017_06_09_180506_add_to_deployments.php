<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddToDeployments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('deployment_projects', function ($table) {
            $table->string('repository')->after('status');
        });

        Schema::table('deployment_stages', function ($table) {
            $table->string('branch')->after('status');
            $table->string('host')->after('branch');
            $table->string('host_user')->after('host');
            $table->string('host_become')->after('host_user');
            $table->string('deploy_path')->after('host_become');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('deployment_projects', function($table){
            $table->dropColumn('repository');
        });

        Schema::table('deployment_stages', function($table){
            $table->dropColumn('branch');
            $table->dropColumn('host');
            $table->dropColumn('host_user');
            $table->dropColumn('host_become');
            $table->dropColumn('deploy_path');
        });
    }
}
