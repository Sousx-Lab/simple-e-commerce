<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminController extends EasyAdminController
{

    private UserPasswordEncoderInterface $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder) {
        $this->encoder = $encoder;
    }

    protected function persistUserEntity(User $user)
    {
        $encodedPassword = $this->encoder->encodePassword($user, $user->getPassword());
        $user->setPassword($encodedPassword);
        parent::persistEntity($user);
    }

    protected function updateUserEntity(User $user)
    {
        if (!$user->getPassword()) {
            return;
        }
        $encodedPassword = $this->encoder->encodePassword($user, $user->getPassword());
        $user->setPassword($encodedPassword);
        parent::updateEntity($user);
    }
}
