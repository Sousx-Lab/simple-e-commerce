<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private UserPasswordEncoderInterface $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder) {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {
        $user = (new User())
        ->setEmail('admin@email.com')
        ->setRoles(['ROLE_ADMIN'])
        ->setFirstName('John')
        ->setLastName('Doe');
        $user->setPassword($this->encoder->encodePassword($user, 'admin'));
        
        $manager->persist($user);
        $manager->flush();
    }
}
