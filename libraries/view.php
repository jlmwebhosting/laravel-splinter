<?php namespace Splinter;

use \Cookie;

class View extends \View {
	
	/**
	 * Create a new view instance.
	 *
	 * @param  string  $view
	 * @param  array   $data
	 * @return void
	 */
	public function __construct($view, $data = array())
	{
		// Check for split
		if ( ! $split = Split::where_name($view)->first())
		{
			return parent::__construct($view, $data);
		}

		// Check for a cookie session
		if (($client = Splinter::getClient()) 
			&& ($hit = $client->hits()->where_split_id($split->id)->first()))
		{
			$variation = $hit->variation;
		}

		// Decide which one to use
		if (empty($variation))
		{
			// @todo: support non-uniform weighting
			$variations = $split->variations;
			$variation = $variations[rand(0,count($variations)-1)];
		}

		// @todo: Stuff would break if a split had no variations

		// Record client info
		if (empty($client))
		{
			$client = new Client(array(
				'ip_address' => $_SERVER['REMOTE_ADDR'],
				'user_agent' => $_SERVER['HTTP_USER_AGENT'],
				'split_id' => $split->id,
				'variation_id' => $variation->id,
			));

			try
			{
				$client->save();
			}
			catch (Exception $e)
			{
				Splinter::logError(array(
					'message' => $e->getMessage(),
					'split_id' => $split->id,
				));
			}
		}

		// Save the hit
		$hit = new Hit(array(
			'split_id' => $split->id,
			'variation_id' => $variation->id,
			'client_id' => $client->id,
		));

		try
		{
			$hit->save();
		}
		catch (Exception $e)
		{
			Splinter::logError(array(
				'message' => $e->getMessage(),
				'split_id' => $split->id,
			));
		}

		// Store it as a cookie
		Cookie::forever('splinter_client', $client->id);

		parent::__construct($variation->name, $data);
	}
}
