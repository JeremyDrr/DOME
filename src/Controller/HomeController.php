<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Repository\AdRepository;
use App\Repository\UserRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(AdRepository $adRepository, UserRepository $userRepository, Request $request): Response
    {

        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            /*
            $message = (new TemplatedEmail())
                ->from($form->get("email")->getData())
                ->to('contact@uniswap.ro')
                ->subject($form->get('topic')->getData())
                ->htmlTemplate('emails/contact.html.twig')
                ->context([
                        'email' => $form->get('email')->getData(),
                        'topic' => $form->get('topic')->getData(),
                        'content' => $form->get('content')->getData(),
                    ]
                )
            ;

            $mailer->send($message);*/

            $this->redirectToRoute('homepage');
        }

        return $this->render('index.html.twig', [
            'ads' => $adRepository->findRecent(3),
            'users' => $userRepository->findRandom(19),
            'form' => $form->createView()
        ]);
    }
}
