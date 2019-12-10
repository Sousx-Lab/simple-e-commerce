<?php
namespace App\Services\Notification;

use Twig\Environment;
use App\Entity\User;

class SignUpConfirmation {

    /**
     * @var Swift_Mailer
     */
    private $mailer;

    /**
     * @var Environement
     */
    private $renderer;

    public function __construct(\Swift_Mailer $mailer, Environment $renderer)
    {
        $this->mailer = $mailer;
        $this->renderer = $renderer;
    }

    public function sendConfirmation(User $user)
    {
        $message = (new \Swift_Message('Confirmation de votre inscription'))
        ->setFrom('noreply@guitarshop.fr')
        ->setTo($user->getEmail())
        ->setBody($this->renderer->render('emails/signup.confirm.template.html.twig',[
            'user' => $user
        ]),'text/html');
            
        $this->mailer->send($message);
    }
}