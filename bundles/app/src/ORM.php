<?php

namespace Project\App;

/**
 * Here you can define wrappers for the ORM to use.
 */
class ORM extends \PHPixie\DefaultBundle\ORM
{
    protected $entityMap = array(
        'user' => 'Project\App\ORM\User'
    );

    protected $repositoryMap = array(
        'user' => 'Project\App\ORM\User\UserRepository'
    );
}