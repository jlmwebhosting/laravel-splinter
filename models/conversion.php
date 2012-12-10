<?php namespace Splinter;

class Conversion extends Base_Model {

	public static $table = 'splinter_conversions';
	
	public function goal()
	{
		return $this->belongs_to('Splinter\\Goal');
	}

	public function client()
	{
		return $this->belongs_to('Splinter\\Client');
	}

	public function split()
	{
		return $this->belongs_to('Splinter\\Split');
	}

	public function variation()
	{
		return $this->belongs_to('Splinter\\Variation');
	}
}
