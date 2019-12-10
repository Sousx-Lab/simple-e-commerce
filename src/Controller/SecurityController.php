<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Services\Notification\SignUpConfirmation;
use App\Security\UserUidChecker;
use Symfony\Component\HttpFoundation\Response;

class SecurityController extends AbstractController
{
    /**
     * @var ObjectManager
     */
    private $em;

    /**
     * @var SignUpConfirmation
     */
    private $email;

    public function __construct(EntityManagerInterface $em, SignUpConfirmation $email)
    {
        $this->em = $em;
        $this->email = $email;
    }
    /**
     * @Route("/inscription", name="security.signup")
     */
    public function signUp(Request $request, UserPasswordEncoderInterface $PasswordEncoder)
    {   
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
           $password = $PasswordEncoder->encodePassword($user, $user->getPassword());
           $user->setPassword($password);
           $user->setUid();
           $user->setIsConfirmed(false);
           $user->setIsEnabled(true);

           $this->em->persist($user);
           $this->em->flush();

           $this->email->sendConfirmation($user);
           $this->addFlash('success', 'Votre compte à bien été créer');
        }
        return $this->render('security/signup.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Request $id|null
     * @param Request $uid
     * @Route("/inscription/confirm/{uid}/{id}", name="signup.confirm")
     */
    public function signUpConfirmation(int $id, string $uid, UserUidChecker $check): Response
    {
        $status = $check->checkUidUser($id, $uid);
        if($status === null){
          $this->addFlash('warning', 'Bonjour, Le compte que vous essayer de confirmé n\'existe pas');
        }else{
         $this->addFlash('notice', $status);
        }
        return $this->render('security/signup.confirmation.html.twig', [
        ]);
    }

    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('security/login.html.twig',[
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    /*public function accountInfo()
    {
    // allow any authenticated user - we don't care if they just
    // logged in, or are logged in via a remember me cookie
    $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');

    // ...
    }

    public function resetPassword()
    {
    // require the user to log in during *this* session
    // if they were only logged in via a remember me cookie, they
    // will be redirected to the login page
    $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

    // ...
    }*/
}
