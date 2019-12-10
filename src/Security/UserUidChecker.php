<?php
namespace App\Security;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class UserUidChecker {

    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function checkUidUser(int $id, string $uid)
    {
       $respository = $this->em->getRepository(User::class);
       $user = $respository->find($id);
       if(!empty($user)){
           if($user->getIsConfirmed()){
           return 'Bonjour ' . ucfirst($user->getUsername()) . ', Vous avez déja confirmé votre inscription';
          }
          if($user->getUid() === $uid){
            $user->setIsConfirmed(true);
            $this->em->persist($user);
            $this->em->flush($user);
            return 'Bonjour ' . ucfirst($user->getUsername()) . ', Votre compte à bien été confirmé';
          }
       } 
       return null;
    }
}