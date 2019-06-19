<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index(ArticleRepository $repo)
    {
        $articles = $repo->findAll('Titre de l\'article');

        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'articles' => $articles
        ]);
    } 

    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('blog/home.html.twig', [
            'title' => 'Salut c\'est Sarah'
        ]);
    } 

    /**
     * @Route("/blog/add", name="blog_add")
     */
    public function add(Request $request, ObjectManager $manager)
    {
            $article = new Article();
            $form = $this->createFormBuilder($article)
                        ->add('title', TextType::class,[
                            'attr' => 
                            ['placeholder' =>"Titre de l'article"]
                        ])

                        ->add('content', TextareaType::class,[
                            'attr' => 
                            ['placeholder' => "Contenu de l'article"]
                        ])
                        ->add('image', TextType::class,[
                            'attr' => 
                            ['placeholder' => "image de l'article"]
                        ])
                        ->getForm();
        
        return $this->render('blog/add.html.twig',[
            'formArticle' => $form->createView()
        ]);
    }

    /**
     * @Route("/blog/{id}", name="blog_show")
     */
    public function show(Article $article)
    {
        return $this->render('blog/show.html.twig',[ 
            'article'=> $article
        ]);
    } 


}