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
     * @Route("/articles", name="articles")
     * @param Request $request
     * @param ArticleRepository $articleRepository
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request, ArticleRepository $articleRepository, EntityManagerInterface $em)
    {
/*        $articleRepository = $this->getDoctrine()->getManager()->getRepository(Article::class);

        $articleRepository->findBy(['published' => true]);

        return $this->render('article/index.html.twig', [
            'articlesPublished' => $articleRepository->findBy(['published' => true]),
            'articlesNotPublished' => $articleRepository->findBy(['published' => false]),
            'articlesPublishedAndNotExpired' => $articleRepository->findByArticlePublishedAndNotExpired(),
        ]);*/
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
