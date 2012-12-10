<?php

use Splinter\Splinter;
use Splinter\Split;
use Splinter\Hit;

class Splinter_Splits_Controller extends Controller {

	public $restful = true;

	public function get_home()
	{
		return View::make('splinter::contentHome');
	}

	/**
	 * splitsList partial
	 */
	public function get_index()
	{
		$splits = Split::all();

		return View::make('splinter::splitsList')->with('splits', $splits);
	}

	public function get_new()
	{
		$split = new Split;
		$dialog = View::make('splinter::splitDialog')
			->with('split', $split)
			->with('formAction', 'splinter/splits/split');

		return $dialog;
	}

	/**
	 * contentPane partial
	 */
	public function get_split($splitID)
	{
		if ( ! $split = Split::find($splitID))
		{
			return Response::error(400);
		}

		$impressions = Hit::where_split_id($split->id)->count();
		//$sessions = Hit::where_split_id($split->id)->group_by('client_id')->count();
		$sessions = Splinter::DB()->query('SELECT COUNT(*) AS count, client_id FROM splinter_hits GROUP BY client_id');

		return View::make('splinter::splitContent')
			->with('split', $split)
			->with('impressions', $impressions)
			->with('sessions', count($sessions))
			->with('conversions', 0);
	}

	public function post_split($splitID=null)
	{
		if ($splitID)
		{
			if ( ! $split = Split::find($splitID))
			{
				return Response::error(404);
			}
		}
		else
		{
			$creating = true;
			$split = new Split;
		}

		$split->fill(Input::all());

		if ( ! $split->validate())
		{
			return Response::error(400, 'Validation failed');
		}

		try
		{
			$split->save();
		}
		catch (Exception $e)
		{
			die($e->getMessage());
			return Response::error(500);
		}

		echo json_encode(array(
			'reloadPartial' => @$creating ? '#splitsList' : '#splitsList, #contentPane',
			'split' => $split->to_array(),
		));
	}

	public function delete_split($splitID=null)
	{
		if ( ! $split = Split::find($splitID))
		{
			return Response::error(400);
		}

		try
		{
			$split->delete();
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

	public function get_form($splitID)
	{
		if ( ! $split = Split::find($splitID))
		{
			return Response::error(400);
		}

		$dialog = View::make('splinter::splitDialog')
			->with('split', $split)
			->with('formAction', 'splinter/splits/'.$split->id);

		return $dialog;
	}

}
