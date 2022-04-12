<?php

namespace App\Controller;

use Exception;
use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{ 
    /**
    * @Route("/liste-des-catégories", name="category_list")
    */   
    public function list(CategoryRepository $repo): Response
    {
        $categories = $repo->findAll();
        return $this->render('category/list.html.twig', [
            'categories' => $categories
        ]);
    }

    /**
    * @Route("/catégorie/{slug}}", name="category_show")
    */     
    public function show(CategoryRepository $repo, string $slug): Response
    {
        $category = $repo->findOneBy(['slug'=> $slug]);
        return $this->render('category/show.html.twig', [
            'category' => $category
        ]);
    }
     
    /**
    * @Route("/supprimer-catégorie/{slug}}", name="category_delete")
    */     
    public function delete(EntityManagerInterface $em, Category $cat): Response
    {
        $em->remove($cat);
        $em->flush();
        return $this->redirectToRoute("category_list");
    }
     
    /**
    * @Route("/nouvelle-catégorie", name="category_new")
    */      
    public function new(EntityManagerInterface $em, Request $request, SluggerInterface $slugger): Response
    {
        
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $slug = $slugger->slug($category->getName(). '-'.rand(100, 500));
            $category->setSlug($slug);

            $em->persist($category);

            try{
                $em->flush();
            }catch(Exception $e){

                return $this->redirectToRoute('category_new');
            }
            
            return $this->redirectToRoute('category_show', ['slug' => $slug]);

        }

        return $this->render("category/new.html.twig", [
        'form' => $form->createView()
    ]);
    }
}
