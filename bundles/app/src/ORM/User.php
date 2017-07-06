<?php

namespace Project\App\ORM;

use Project\App\ORM\Model\Entity;

use PHPixie\AuthLogin\Repository\User as LoginUser;

class User extends Entity implements LoginUser
{

    public function passwordHash()
    {
        return $this->getField('password');
    }
}