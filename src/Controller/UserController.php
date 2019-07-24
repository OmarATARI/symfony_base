<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/users", name="users")
     * @param Request $request
     * @param UserRepository $userRepository
     * @param EntityManager $em
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function index(Request $request, UserRepository $userRepository, EntityManagerInterface $em)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($user);
            $em->flush();
        }

        return $this->render('user/index.html.twig', array(
            'users' => $userRepository->findAll(),
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/user/{id}", name="user")
     * @param UserRepository $userRepository
     * @param Int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function user_show(UserRepository $userRepository, Int $id) : Response
    {
        return $this->render('user/user_show.html.twig', array(
            'user' => $userRepository->find($id),
        ));
    }
}
