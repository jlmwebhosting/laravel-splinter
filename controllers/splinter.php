<?php

class Splinter_Splinter_Controller extends Controller {

	public $layout = 'splinter::template',
		$restful = true;

	public function get_index()
	{
		$splits = Split::all();
		var_dump($splits);
		$this->layout->leftPane = View::make('splinter::leftPane')
			->with('splits', $splits);
		$this->layout->contentPane = View::make('splinter::contentHome');
	}

	public function get_split($split_id)
	{
		if ( ! $split = Split::find($split_id))
		{
			 return Response::error();
		}

		$content = View::make('splinter::contentPane')
			->with('split', $split)
			->with('impressions', 0)
			->with('sessions', 0)
			->with('conversions', 0);

		$this->layout->title = $split->name;
		$this->layout->contentPane = $content;
	}
}
