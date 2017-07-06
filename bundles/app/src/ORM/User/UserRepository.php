<?php

namespace Project\App\ORM\User;

use Project\App\ORM\Model\Repository;

use PHPixie\AuthLogin\Repository as LoginUserRepository;

class UserRepository extends Repository implements LoginUserRepository
{

    public function getById($id)
    {
        return $this->query()
            ->in($id)
            ->findOne();
    }

    public function getByLogin($login)
    {
        return $this->query()
            ->where('email', $login)
            ->findOne();
    }
}