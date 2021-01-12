<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;

Class StaffMembersTable extends Table{
	
	public function initialize(array $config)
	{
		$this->addBehavior('Timestamp');
		$this->BelongsTo("GymRoles",["foreignKey"=>"role"]);
		$this->BelongsTo("GymMember");
		$this->BelongsTo("Specialization",["propertyName"=>"specialization"]);
	}

    public function buildRules(RulesChecker $rules)
    {
//		$rules->add($rules->isUnique(['email'],'Email-id already in use.'));
        $rules->add($rules->isUnique(['username'],'Username already in use.')); /*  MOVED TO LOGIN TABLE - REMOVE */
        return $rules;
    }
}