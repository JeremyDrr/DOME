<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user/{slug}', name: 'user_show')]
    public function index(User $user)
    {

        return $this->render('account/index.html.twig', [
            'user' => $user,
        ]);
    }
}
