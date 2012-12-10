<?php

use Splinter\Splinter;
use Splinter\Split;
use Splinter\Variation;
use Splinter\Goal;
use Splinter\Client;

class Splinter_Goals_Controller extends Controller {

	public $restful = true;

	/**
	 * goalsList partial
	 */
	public function get_index()
	{
		$goals = Goal::all();

		return View::make('splinter::goalsList')->with('goals', $goals);
	}

	public function get_goal($goalID)
	{
		if ( ! $goal = Goal::find($goalID))
		{
			return Response::error(404, 'Goal not found');
		}

		$contributors = array();

		$conversions = $goal->conversions;

		$client_ids = Splinter::DB()
			->table('splinter_conversions')
			->where_goal_id($goal->id)
			->group_by('client_id')
			->lists('client_id');

		$clients = Client::where_in('id', $client_ids)->get();

		$splits = Split::with(array(
			'hits' => function($query) use ($client_ids)
			{
				$query->where_in('client_id', $client_ids);
			},
		))->get();

		foreach ($splits as $split)
		{
			if ( ! $split->numHits = count($split->hits)) continue;

			$contrib = array(
				'split' => $split,
				'variations' => array(),
			);

			foreach ($split->hits as $hit)
			{
				if (empty($contrib['variations'][$hit->variation_id]))
				{
					$variation = $contrib['variations'][$hit->variation_id] = $hit->variation;
					$variation->count = 0;
				}
				else
				{
					$variation = $contrib['variations'][$hit->variation_id];
				}

				$variation->count++;
			}

			foreach ($contrib['variations'] as $variation)
			{
				$variation->percentage = $variation->count / $split->numHits * 100;
			}

			$contributors[] = $contrib;
		}

		return View::make('splinter::goalContent')
			->with('goal', $goal)
			->with('conversions', $conversions)
			->with('clients', $clients)
			->with('contributors', $contributors);
	}

	public function post_goal($goalID=null)
	{
		if ($goalID)
		{
			if ( ! $goal = Goal::find($goalID))
			{
				return Response::error(404, 'Invalid Goal ID');
			}
		}
		else
		{
			$creating = true;
			$goal = new Goal;
		}

		$goal->fill(Input::all());

		if ( ! $goal->validate())
		{
			return Response::error(400, 'Goal failed');
		}

		try
		{
			$goal->save();
		}
		catch (Exception $e)
		{
			die($e->getMessage());
			return Response::error(500);
		}

		echo json_encode(array(
			'reloadPartial' => @$creating ? '#goalsList' : '#goalsList, #contentPane',
			'goal' => $goal->to_array(),
		));
	}

	public function delete_goal($goalID=null)
	{
		if ( ! $goal = Goal::find($goalID))
		{
			return Response::error(400);
		}

		try
		{
			$goal->delete();
		}
		catch (Exception $e)
		{
			die($e->getMessage());
			return Response::error(500);
		}

		die(json_encode(array(
			'success' => true,
		)));
	}

	/**
	 * Form dialog
	 */
	public function get_form($goalID=null)
	{
		if ($goalID)
		{
			if ( ! $goal = Goal::find($goalID))
			{
				return Response::error(400);
			}
		}
		else
		{
			$goal = new Goal;
		}

		return View::make('splinter::goalDialog')
			->with('goal', $goal)
			->with('formAction', $goal->id ? 'splinter/goals/'.$goal->id : 'splinter/goals/goal');
	}
}
