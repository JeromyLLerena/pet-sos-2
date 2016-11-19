<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPostsTableAddPet extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('posts', function(Blueprint $table){
			$table->integer('pet_id')->unsigned();

			$table->foreign('pet_id')
			      ->references('id')
			      ->on('pets')
			      ->onDelete('cascade')
			      ->onUpdate('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('posts', function(Blueprint $table){
			$table->dropForeign(['pet_id']);
			$table->dropColumn('pet_id');
		});
	}
}
