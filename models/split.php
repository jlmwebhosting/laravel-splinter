<?php namespace Splinter;

class Split extends Base_Model {
	
	public static $table = 'splinter_splits';

	public function variations()
	{
		return $this->has_many('Splinter\\Variation');
	}

	public function goals()
	{
		return $this->has_many('Splinter\\Goal');
	}

	public function hits()
	{
		return $this->has_many('Splinter\\Hit');
	}

	public function validate()
	{
		if (empty($this->name))
		{
			return false;
		}

		return true;
	}
}
