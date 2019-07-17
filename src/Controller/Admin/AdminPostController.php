<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use App\Form\PostType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/admin/posts")
 */
class AdminPostController extends AbstractController
{
    /**
     * @Route("/", name="admin")
     */
    public function index()
    {
        $posts = $this->getDoctrine()
                      ->getRepository(Post::class)
                      ->findAll();

        return $this->render('admin/posts/index.html.twig', [
            'posts' => $posts
        ]);
    }

    /**
     * @Route("/new", name="admin_post_new")
     */
    public function new(Request $request)
    {
        $form = $this->createForm(PostType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();

            $post->setCreatedAt(new \DateTime("now", new \DateTimeZone("America/Sao_Paulo")));
            $post->setUpdatedAt(new \DateTime("now", new \DateTimeZone("America/Sao_Paulo")));


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($post);
            $entityManager->flush();

            $this->addFlash('success', 'Post salvo com sucesso');
            return  $this->redirect('/admin/posts');
        }


        return $this->render('admin/posts/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/update/{id}", name="admin_post_update")
     * @param Request $request
     * @param Post $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function update(Request $request, Post $id) {

        $form = $this->createForm(PostType::class, $id);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();

            $post->setUpdatedAt(new \DateTime("now", new \DateTimeZone("America/Sao_Paulo")));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->merge($post);
            $entityManager->flush();

            $this->addFlash('success', 'Post atualizado com sucesso');
            return  $this->redirect('/admin/posts');
        }

        return $this->render('admin/posts/update.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/delete/{id}", name="admin_post_delete")
     */
    public function delete(Post $post) {

//        if(!$post){
//            $this->addFlash('warning', 'Post não encontrado !!');
//            return  $this->redirect('/admin/posts');
//        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($post);
        $entityManager->flush();

        $this->addFlash('success', 'Post removido com sucesso');
        return  $this->redirect('/admin/posts');
    }

}
