<?php namespace Splinter;

class Variation extends Base_Model {
	
	public static $table = 'splinter_variations';

	public function split()
	{
		return $this->belongs_to('Splinter\\Split');
	}

	public function validate()
	{
		if (empty($this->name) || ! $this->split)
		{
			return false;
		}

		return true;
	}
}
