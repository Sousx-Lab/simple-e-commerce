<?php
namespace App\Security;

use App\Entity\User;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;


class UserChecker implements UserCheckerInterface {

    public function checkPreAuth(UserInterface $user)
    {
        if (!$user instanceof User) {
            return;
        }

        /*if ($user->isDeleted()) {
            throw new AccountDeletedException('test');
        }*/
        
    }
    
    public function checkPostAuth(UserInterface $user)
    {
        if (!$user instanceof User) {
            return;
        }
        
        if(!$user->getIsConfirmed()){
            throw new CustomUserMessageAuthenticationException('Veuillez valider votre compte');
        }
        
    }
}