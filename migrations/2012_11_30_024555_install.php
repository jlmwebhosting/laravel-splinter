<?php

// We need the splinter database definition for this
require path('bundle').DS.'splinter'.DS.'config'.DS.'database.php';

class Splinter_Install {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('splinter_splits', function($table)
		{
			$table->connection = SPLINTER_DB;
			$table->create();

			$table->increments('id');
			$table->timestamps();
			$table->string('name');
		});

		Schema::table('splinter_variations', function($table)
		{
			$table->connection = SPLINTER_DB;
			$table->create();

			$table->increments('id');
			$table->timestamps();
			$table->integer('split_id')->references('id')->on('splinter_splits');
			$table->string('name');
		});

		Schema::table('splinter_clients', function($table)
		{
			$table->connection = SPLINTER_DB;
			$table->create();

			$table->increments('id');
			$table->timestamps();
			$table->string('ip_address');
			$table->string('user_agent');
			$table->integer('split_id')->references('id')->on('splinter_splits');
			$table->integer('variation_id')->references('id')->on('splinter_variations');
		});

		Schema::table('splinter_goals', function($table)
		{
			$table->connection = SPLINTER_DB;
			$table->create();

			$table->increments('id');
			$table->timestamps();
			$table->integer('split_id')->references('id')->on('splinter_splits');
			$table->string('name');
			$table->string('slug');
		});

		Schema::table('splinter_hits', function($table)
		{
			$table->connection = SPLINTER_DB;
			$table->create();

			$table->increments('id');
			$table->timestamps();
			$table->integer('split_id')->references('id')->on('splinter_splits');
			$table->integer('variation_id')->references('id')->on('splinter_variations');
			$table->integer('client_id')->references('id')->on('splinter_clients');
		});

		Schema::table('splinter_conversions', function($table)
		{
			$table->connection = SPLINTER_DB;
			$table->create();

			$table->increments('id');
			$table->timestamps();
			$table->string('client_id')->references('id')->on('splinter_clients')->nullable();
			$table->integer('goal_id')->references('id')->on('splinter_goals');
			$table->integer('split_id')->references('id')->on('splinter_splits');
			$table->integer('variation_id')->references('id')->on('splinter_variations');
		});

		Schema::table('splinter_errors', function($table)
		{
			$table->connection = SPLINTER_DB;
			$table->create();

			$table->increments('id');
			$table->timestamps();
			$table->string('message');
			$table->integer('split_id')->references('id')->on('splinter_splits')->nullable();
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('splinter_splits', SPLINTER_DB);
		Schema::drop('splinter_variations', SPLINTER_DB);
		Schema::drop('splinter_clients', SPLINTER_DB);
		Schema::drop('splinter_goals', SPLINTER_DB);
		Schema::drop('splinter_hits', SPLINTER_DB);
		Schema::drop('splinter_conversions', SPLINTER_DB);
		Schema::drop('splinter_errors', SPLINTER_DB);
	}
}
