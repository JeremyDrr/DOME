<?php

namespace App\Controller;

use App\Entity\PasswordUpdate;
use App\Entity\User;
use App\Form\AccountType;
use App\Form\PasswordUpdateType;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AccountController extends AbstractController
{
    #[Route('/login', name: 'account_login')]
    public function index(AuthenticationUtils $utils): Response
    {
        $error = $utils->getLastAuthenticationError();
        $username = $utils->getLastUsername();

        if($this->getUser() != null)
            return $this->redirectToRoute('homepage');

        return $this->render('account/login.html.twig', [
            'hasError' => $error !== null,
            'username' => $username
        ]);
    }

    #[Route('/logout', name: 'account_logout')]
    public function logout(){
    }

    #[Route('/register', name: 'account_register')]
    public function register(Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $encoder/*, MailerInterface $mailer*/){

        if($this->getUser() != null)
            return $this->redirectToRoute('homepage');

        $user = new User();

        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $hash = $encoder->hashPassword($user, $user->getHash());
            $user->setHash($hash);

            $user->setActivationToken(md5(uniqid()));

            $manager->persist($user);
            $manager->flush();

            //Création de l'email
            /*$email = (new TemplatedEmail())
                ->from('no-reply@uniswap.ro')
                ->to($user->getEmail())
                ->subject("UniSwap Account Confirmation")
                ->htmlTemplate("emails/activation.html.twig")
                ->context([
                    'firstName' => $user->getFirstName(),
                    'token' => $user->getActivationToken()
                ])
            ;

            $mailer->send($email);
*/
            //TODO: Add flash

            return $this->redirectToRoute('account_login');
        }
        return $this->render('account/register.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/account/edit-profile', name: 'account_edit')]
    #[IsGranted("ROLE_USER")]
    public function edit(Request $request, EntityManagerInterface $manager){
        $user = $this->getUser();

        $form = $this->createForm(AccountType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('account_index');
            //TODO: Add flash
        }

        return $this->render('account/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/account/password-update', name: 'account_password')]
    #[IsGranted("ROLE_USER")]
    public function updatePassword(Request $request, UserPasswordHasherInterface $encoder, EntityManagerInterface $manager){

        $user = $this->getUser();

        $passwordUpdate = new PasswordUpdate();

        $form = $this->createForm(PasswordUpdateType::class, $passwordUpdate);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            if(!password_verify($passwordUpdate->getOldPassword(), $user->getHash() )){
                $form->get('oldPassword')->addError(new FormError("The specified password does not match your current password"));
            }else{
                $newPassword = $passwordUpdate->getNewPassword();
                $hash = $encoder->hashPassword($user, $newPassword);
                $user->setHash($hash);

                $manager->persist($user);
                $manager->flush();

                //TODO: Add flash

                return $this->redirectToRoute('homepage');
            }

        }

        return $this->render('account/password.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/account', name: 'account_index')]
    #[IsGranted("ROLE_USER")]
    public function myAccount(){

        return $this->render('account/index.html.twig', [
            'user' => $this->getUser()
        ]);
    }
}
