<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{

    /**
     * @Route("/article/remove/{id}", name="article_remove")
     * @param Article $article
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function remove(Article $article, EntityManagerInterface $em)
    {
        $em->remove($article);
        $em->flush();
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/articles", name="articles")
     * @param Request $request
     * @param ArticleRepository $articleRepository
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request, ArticleRepository $articleRepository, EntityManagerInterface $em)
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($article);
            $em->flush();
        }

        //$userRepository = $this->getDoctrine()->getManager()->getRepository(User::class);

        return $this->render('article/index.html.twig', array(
            'articles' => $articleRepository->findAll(),
            'form' => $form->createView(),
        ));
    }
}
