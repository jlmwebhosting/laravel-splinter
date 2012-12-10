<?php

include 'config'.DS.'database.php';

Autoloader::namespaces(array(
	'Splinter' => __DIR__.DS.'models',
));

Autoloader::map(array(
	'Splinter\\Base_Model' => __DIR__.DS.'models'.DS.'base_model.php',
	'Splinter\\View' => __DIR__.DS.'libraries'.DS.'view.php',
	'Splinter\\Splinter' => __DIR__.DS.'libraries'.DS.'splinter.php',
));


// Splits
Route::any('splinter/splits/(:num)', function($splitID)
{
	return Route::forward(Request::method(), 'splinter/splits/split/'.$splitID);
});
Route::get('splinter/splits/(:num)/edit', function($splitID)
{
	return Route::forward('GET', 'splinter/splits/form/'.$splitID);
});
Route::post('splinter/splits/(:num)/variation', function($splitID)
{
	return Route::forward(Request::method(), 'splinter/variations/variation/for_split/'.$splitID);
});
Route::controller('splinter::splits');


// Variations
Route::any('splinter/variations/(:num)', function($variationID)
{
	return Route::forward(Request::method(), 'splinter/variations/variation/'.$variationID);
});
Route::any('splinter/variations/(:num)/edit', function($variationID)
{
	return Route::forward(Request::method(), 'splinter/variations/form/'.$variationID);
});
Route::controller('splinter::variations');


// Goals
Route::get('splinter/goals/new', function()
{
	return Route::forward(Request::method(), 'splinter/goals/form');
});
Route::any('splinter/goals/(:num)', function($goalID)
{
	return Route::forward(Request::method(), 'splinter/goals/goal/'.$goalID);
});
Route::get('splinter/goals/(:num)/edit', function($goalID)
{
	return Route::forward('GET', 'splinter/goals/form/'.$goalID);
});
Route::controller('splinter::goals');


Route::get('splinter', function()
{
	$layout = View::make('splinter::template');

	$splits = Splinter\Split::all();
	$goals = Splinter\Goal::all();

	$layout->splitsList = View::make('splinter::splitsList')->with('splits', $splits);
	$layout->goalsList = View::make('splinter::goalsList')->with('goals', $goals);
	$layout->contentPane = View::make('splinter::contentHome');
	
	return $layout;
});


