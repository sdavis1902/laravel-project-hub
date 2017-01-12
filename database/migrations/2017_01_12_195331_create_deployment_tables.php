<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeploymentTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deployment_groups', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name');
			$table->enum('status', ['Active','Inactive'])->default('Active');
			$table->integer('project_id')->unsigned();
			$table->foreign('project_id')->references('id')->on('projects');
            $table->timestamps();
            $table->softDeletes();

            $table->engine = 'InnoDB';
        });

        Schema::create('deployments', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->string('command');
			$table->enum('status', ['Active','Inactive'])->default('Active');
			$table->integer('group_id')->unsigned();
			$table->foreign('group_id')->references('id')->on('deployment_groups');
            $table->timestamps();
            $table->softDeletes();

            $table->engine = 'InnoDB';
        });

        Schema::create('deployment_runs', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('log', 2048);
			$table->enum('status', ['Success','Fail','Pending'])->default('Pending');
			$table->integer('deployment_id')->unsigned();
			$table->foreign('deployment_id')->references('id')->on('deployments');
            $table->timestamps();
            $table->softDeletes();

            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('deployment_groups');
        Schema::drop('deployments');
        Schema::drop('deployment_runs');
    }
}
