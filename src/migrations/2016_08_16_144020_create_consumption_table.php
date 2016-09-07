<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsumptionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('power_consumption', function(Blueprint $table) {
		   $table->increments('id');
		   $table->dateTime('recorded_at');
		   $table->float('consumption');
		   $table->float('solar');
		   $table->float('always_on');
		   $table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('power_consumption');
	}

}
