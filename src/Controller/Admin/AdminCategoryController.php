<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/admin/categories")
 */
class AdminCategoryController extends AbstractController
{
    /**
     * @Route("/", name="admin_category")
     */
    public function index()
    {
        $categories = $this->getDoctrine()
                      ->getRepository(Category::class)
                      ->findAll();

        return $this->render('admin/categories/index.html.twig', [
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/new", name="admin_category_new")
     */
    public function new(Request $request)
    {
        $form = $this->createForm(CategoryType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $category = $form->getData();

            $category->setCreatedAt(new \DateTime("now", new \DateTimeZone("America/Sao_Paulo")));
            $category->setUpdatedAt(new \DateTime("now", new \DateTimeZone("America/Sao_Paulo")));


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($category);
            $entityManager->flush();

            $this->addFlash('success', 'Categoria salva com sucesso');
            return  $this->redirect('/admin/categories');
        }


        return $this->render('admin/categories/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/update/{id}", name="admin_category_update")
     * @param Request $request
     * @param Category $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function update(Request $request, Category $id) {

        $form = $this->createForm(CategoryType::class, $id);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $category = $form->getData();

            $category->setUpdatedAt(new \DateTime("now", new \DateTimeZone("America/Sao_Paulo")));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->merge($category);
            $entityManager->flush();

            $this->addFlash('success', 'Categoria atualizada com sucesso');
            return  $this->redirect('/admin/categories');
        }

        return $this->render('admin/categories/update.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/delete/{id}", name="admin_category_delete")
     */
    public function delete(Category $category) {

//        if(!$post){
//            $this->addFlash('warning', 'Post não encontrado !!');
//            return  $this->redirect('/admin/posts');
//        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($category);
        $entityManager->flush();

        $this->addFlash('success', 'Category removido com sucesso');
        return  $this->redirect('/admin/categories');
    }

}
