<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Customer extends Entity
{
    protected $_accessible = [
        "*" => true,
        "id" => false
    ];
}
