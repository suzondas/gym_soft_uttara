<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class Discount_IdTable extends Table{
	
	public function initialize(array $config)
	{
		$this->addBehavior("Timestamp");
		// $this->displayField("duration");
		// $this->belongsTo("Membership");
		$this->hasMany("Membership");
	}
}