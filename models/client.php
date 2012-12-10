<?php namespace Splinter;

class Client extends Base_Model {

	public static $table = 'splinter_clients';
	
	public function hits()
	{
		return $this->has_many('Splinter\\Hit');
	}
}
