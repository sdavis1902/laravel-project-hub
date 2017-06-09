<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeploymentsBase extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deployment_projects', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name');
			$table->enum('status', ['Active','Inactive'])->default('Active');
            $table->text('description');
            $table->timestamps();
            $table->softDeletes();

            $table->engine = 'InnoDB';
        });

        Schema::create('deployment_stages', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name');
			$table->enum('status', ['Active','Inactive'])->default('Active');
            $table->text('description');
			$table->integer('deployment_project_id')->unsigned();
			$table->foreign('deployment_project_id')->references('id')->on('deployment_projects');
            $table->timestamps();
            $table->softDeletes();

            $table->engine = 'InnoDB';
        });

        Schema::create('deployments', function (Blueprint $table) {
            $table->increments('id')->unsigned();
			$table->enum('status', ['Queued','Active','Complete', 'Failed'])->default('Queued');
            $table->text('logs');
			$table->integer('deployment_stage_id')->unsigned();
			$table->foreign('deployment_stage_id')->references('id')->on('deployment_stages');
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
        Schema::drop('deployments');
        Schema::drop('deployment_stages');
        Schema::drop('deployment_projects');
    }
}
