<?php

use Splinter\Split;
use Splinter\Variation;

class Splinter_Variations_Controller extends Controller {

	public $restful = true;

	public function get_new($splitID=null)
	{
		if ( ! $split = Split::find($splitID))
		{
			return Response::error(400, 'Split ID required');
		}

		$variation = new Variation;
		$variation->split_id = $split->id;

		$dialog = View::make('splinter::variationDialog')
			->with('split', $split)
			->with('variation', $variation)
			->with('formAction', 'splinter/splits/'.$split->id.'/variation');

		return $dialog;
	}

	public function post_variation($variationID=null, $splitID=null)
	{
		if (is_numeric($variationID))
		{
			if ( ! $variation = Variation::find($variationID))
			{
				return Response::error(404, 'Invalid Variation ID');
			}
			$split = $variation->split;
		}
		else
		{
			if ( ! $split = Split::find($splitID))
			{
				return Response::error(400, 'Split ID required');
			}
			$variation = new Variation;
			$variation->split_id = $split->id;
		}

		$variation->fill(Input::all());

		if ( ! $variation->validate())
		{
			return Response::error(400, 'Validation failed');
		}

		try
		{
			$variation->save();
		}
		catch (Exception $e)
		{
			die($e->getMessage());
			return Response::error(500);
		}

		echo json_encode(array(
			'reloadPartial' => '#contentPane',
			'variation' => $variation->to_array(),
		));
	}

	/**
	 * Edit dialog
	 */
	public function get_form($variationID)
	{
		if ( ! $variation = Variation::find($variationID))
		{
			return Response::error(400);
		}

		return View::make('splinter::variationDialog')
			->with('variation', $variation)
			->with('formAction', 'splinter/variations/'.$variation->id);
	}
}
