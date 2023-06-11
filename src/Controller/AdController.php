<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\Article;
use App\Form\AdType;
use App\Form\ArticleType;
use App\Repository\AdRepository;
use App\Service\PaginationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class AdController extends AbstractController
{
    #[Route('/ads/{page<\d+>?1}', name: 'ads_index')]
    public function index(AdRepository $adRepository, $page, PaginationService $pagination): Response
    {

        $pagination->setEntityClass(Ad::class)
            ->setPage($page)
            ->setLimit(9);

        return $this->render('ads/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    #[Route('/create-ad', name: 'ads_create')]
    #[IsGranted("ROLE_USER", message: "You must be a connected user to create an advertisement")]
    public function create(Request $request, EntityManagerInterface $manager){
        $ad = new Ad();

        $form = $this->createForm(AdType::class, $ad);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            foreach($ad->getCategories() as $category) {
                $category->addAd($ad);
                $manager->persist($category);
            }

            $ad->setAuthor($this->getUser());


            $manager->persist($ad);
            $manager->flush();

            //TODO: Add flash

            return $this->redirectToRoute('ads_show', [
                'slug' => $ad->getSlug()
            ]);
        }

        return $this->render('ads/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/ads/{slug}/delete', name: 'ads_delete')]
    public function delete(Ad $article, EntityManagerInterface $manager){
        $manager->remove($article);
        $manager->flush();

        //TODO: Add flash
        return $this->redirectToRoute('ads_index');
    }

    #[Route('/ads/{slug}', name: 'ads_show')]
    public function show(Ad $ad, EntityManagerInterface $manager, Request $request){

        return $this->render('ads/show.html.twig', [
            'ad' => $ad,
        ]);
    }

}
