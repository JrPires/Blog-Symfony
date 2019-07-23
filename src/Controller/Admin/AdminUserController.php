<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/admin/users")
 */
class AdminUserController extends AbstractController
{
    /**
     * @Route("/", name="admin_user")
     */
    public function index()
    {
        $users = $this->getDoctrine()
                      ->getRepository(User::class)
                      ->findAll();

        return $this->render('admin/users/index.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * @Route("/new", name="admin_user_new")
     */
    public function new(Request $request)
    {
        $form = $this->createForm(UserType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $user->setCreatedAt(new \DateTime("now", new \DateTimeZone("America/Sao_Paulo")));
            $user->setUpdatedAt(new \DateTime("now", new \DateTimeZone("America/Sao_Paulo")));


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Usuário salvo com sucesso');
            return  $this->redirect('/admin/users');
        }


        return $this->render('admin/users/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/update/{id}", name="admin_user_update")
     * @param Request $request
     * @param User $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function update(Request $request, User $id) {

        $form = $this->createForm(UserType::class, $id);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $user->setUpdatedAt(new \DateTime("now", new \DateTimeZone("America/Sao_Paulo")));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->merge($user);
            $entityManager->flush();

            $this->addFlash('success', 'Usuário atualizado com sucesso');
            return  $this->redirect('/admin/users');
        }

        return $this->render('admin/users/update.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/delete/{id}", name="admin_user_delete")
     */
    public function delete(User $user) {

//        if(!$user){
//            $this->addFlash('warning', 'User não encontrado !!');
//            return  $this->redirect('/admin/users');
//        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($user);
        $entityManager->flush();

        $this->addFlash('success', 'Usuário removido com sucesso');
        return  $this->redirect('/admin/users');
    }

}
