<?php namespace Splinter;

class Goal extends Base_Model {

	public static $table = 'splinter_goals';

	public function conversions()
	{
		return $this->has_many('Splinter\\Conversion');
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
