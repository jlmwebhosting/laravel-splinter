<?php namespace Splinter;

class Hit extends Base_Model {
	
	public static $table = 'splinter_hits';

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
