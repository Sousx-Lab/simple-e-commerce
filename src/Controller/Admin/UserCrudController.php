<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CountryField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserCrudController extends AbstractCrudController
{
    private UserPasswordEncoderInterface $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('User')
            ->setEntityLabelInPlural('User')
            ->setSearchFields(['id', 'firstName', 'lastName', 'email', 'roles', 'uuid'])
            ->setPaginatorPageSize(30);
    }

    public function configureFields(string $pageName): iterable
    {
        $firstName = TextField::new('firstName', 'First Name');
        $lastName =TextField::new('lastName', 'Last Name');
        $email = EmailField::new('email', 'Email');
        $address = TextField::new('address', 'Address');
        $zipCode = TextField::new('zipCode', 'Zip Code');
        $city = TextField::new('city', 'City');
        $country = CountryField::new('country', 'Country');
        $phoneNumber = TelephoneField::new('phoneNumber', 'Phone Number');
        $password = TextField::new('password', 'Password')->setFormType(PasswordType::class);
        $confirmPassword = TextField::new('confirmPassword', 'Confirme Password')->setFormType(PasswordType::class);
        $plainPassword = TextField::new('plainPassword', 'New Password')->setFormType(PasswordType::class);
        $id = IntegerField::new('id', 'ID');
        $roles = ChoiceField::new('roles')->allowMultipleChoices(true)->setChoices(['Admin' => 'ROLE_ADMIN'])
            ->setRequired(false)->setHelp('If the user is not an Admin, leave the value blank');

        $uuid = TextField::new('uuid');
        $isEnabled = BooleanField::new('isEnabled');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$isEnabled, $firstName, $lastName, $email, $roles, $uuid];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$isEnabled, $firstName, $lastName, $email, $address, $zipCode, $city, $country, $roles, $uuid];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$isEnabled, $firstName, $lastName, $email, $address, $zipCode, $city, $country, $roles, $password, $confirmPassword];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            $password->setFormTypeOption('disabled', 'disabled');
            $confirmPassword->setFormTypeOption('disabled', 'disabled');
            return [$isEnabled, $firstName, $lastName, $email, $phoneNumber, $address, $zipCode, $city, $country, $roles, $plainPassword, $password, $confirmPassword];
        }
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof User) {
            $user = $entityInstance;
            $encodedPassword = $this->encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($encodedPassword);

            $entityManager->persist($user);
            $entityManager->flush();
        }
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof User) {
            $user = $entityInstance;
            if (null !== $user->getPlainPassword()) {
                $encodedPassword = $this->encoder->encodePassword($user, $user->getPlainPassword());
                $user->setPassword($encodedPassword);
            }
            $entityManager->persist($user);
            $entityManager->flush();
        }
    }
}
