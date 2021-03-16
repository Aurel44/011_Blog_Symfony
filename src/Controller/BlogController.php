<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Form\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;


$request = Request::createFromGlobals();


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
     * @Route("/blog/new", name="blog_create")
     * @Route("/blog/{id}/edit", name="blog_edit")
     */
    public function create(Article $article = null, Request $request)
    {
        if (!$article) {
            $article = new Article;
        }
        // $form = $this->createFormBuilder($article)
        //     ->add('title', TextType::class, [
        //         'attr' => [
        //             'placeholder' => "Titre de l'article"
        //         ]
        //     ])
        //     ->add('content', TextareaType::class)
        //     ->add('image')
        //     ->getForm();

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if (!$article->getId()) {
                $article->setCreateAt(new \DateTime());
            }
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($article);
            $manager->flush();
            return $this->redirectToRoute('blog_show', ['id' => $article->getId()]);
        }
        return $this->render('blog/create.html.twig', [
            'formArticle' => $form->createView(),
            'editMode' => $article->getId() !== null
        ]);
    }





    /**
     * @Route("/blog/{id}", name="blog_show")
     */
    public function show($id)
    {
        $repo = $this->getDoctrine()->getRepository(Article::class);
        $article = $repo->find($id);
        
        $repo1 = $this->getDoctrine()->getRepository(Category::class);
        $category = $repo1->find($id);

        return $this->render('blog/show.html.twig', [
            'article' => $article,
            'category' => $category
        ]);
    }
}
