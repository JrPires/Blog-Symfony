<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use App\Form\PostType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function new()
    {
        $form = $this->createForm(PostType::class);

        return $this->render('admin/posts/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
