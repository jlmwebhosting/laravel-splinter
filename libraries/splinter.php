<?php namespace Splinter;

abstract class Splinter {
	
	public static function convert($slug)
	{
		$goal = Goal::where_name($slug)->first();

		if ( ! $goal)
		{
			static::logError('Invalid goal name: '.$slug);
			return false;
		}

		// Create the conversion
		$conversion = new Conversion;
		$conversion->goal_id = $goal->id;

		// Check for cookie
		if ($client = static::getClient())
		{
			$conversion->client_id = $client->id;
		}

		try
		{
			$conversion->save();
		}
		catch (\Exception $e)
		{
			static::logError('Problem saving conversion for goal: '.$goal->name);
			return false;
		}
	}

	public static function logError($data)
	{
		if ( ! is_array($data))
		{
			$data = array('message' => $data);
		}

		$data['created_at'] = new \DateTime();

		static::DB()->table('splinter_errors')->insert($data);
	}

	public static function DB()
	{
		return \DB::connection('splinter_sqlite');
	}

	public static function getClient()
	{
		$client_id = \Cookie::get('splinter_client');
		return Client::find($client_id);
	}
}
