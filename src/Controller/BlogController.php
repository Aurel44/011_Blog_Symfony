<?php

namespace App\Controller;
use App\Entity\Article;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index()
   {
       $repo = $this->getDoctrine()->getRepository(Article::class);
       $articles = $repo->findAll();
 
       return $this->render('blog/index.html.twig', [
                   'articles' => $articles
       ]);
   }

    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render(
            'blog/home.html.twig',
            [
                'title' => 'Bienvenue sur mon blog symfony',
                'age' => 16
            ]
        );
    }
    /**
    * @Route("/blog/{id}", name="blog_show")
    */
   public function show()
   {
       return $this->render('blog/show.html.twig');
   }
   

}
