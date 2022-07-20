<?php


namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class AdminArticleController extends AbstractController
{

    /**
     * @Route("/admin/article/{id}", name="admin_article")
     */
    public function showArticle(ArticleRepository $articleRepository, $id)
    {

        $article = $articleRepository->find($id);

        return $this->render('admin/show_article.html.twig', [
            'article' => $article
        ]);

    }

    /**
     * @Route("/admin/articles", name="admin_articles")
     */
    public function listArticles(ArticleRepository $articleRepository)
    {
        $articles = $articleRepository->findAll();

        return $this->render('admin/list_articles.html.twig', [
            'articles' => $articles
        ]);
    }



    /**
     * @Route("/admin/insert-article", name="admin_insert_article")
     */
    public function insertArticle(EntityManagerInterface $entityManager, Request $request, SluggerInterface $slugger)
    {
        // je créé une instance de la classe d'entité Article
        // dans le but de créer un article en BDD
        $article = new Article();
        $article->setPublishedAt(new \DateTime('NOW'));

        // j'ai utilisé en ligne de commandes "php bin/console make:form"
        // pour que Symfony me créé une classe qui contiendra "le plan", "le patron"
        // du formulaire pour créer les articles. C'est la classe ArticleType
        // j'utilise la méthode $this->createForm pour créer un formulaire
        // en utilisant le plan du formulaire (ArticleType) et une instance d'Article
        $form = $this->createForm(ArticleType::class, $article);

        // On "donne" à la variable qui contient le formulaire
        // une instance de la classe  Request
        // pour que le formulaire puisse récupérer toutes les données
        // des inputs et faire les setters sur $article automatiquement
        $form->handleRequest($request);

        // si le formulaire a été posté et que les données sont valides (valeurs
        // des inputs correspondent à ce qui est attendu en bdd pour la table article)
        if ($form->isSubmitted() && $form->isValid()) {

            // je récupère l'image dans le formulaire (l'image est en mapped false donc c'est à moi
            // de gérer l'upload
            $image = $form->get('image')->getData();

            // je récupère le nom du fichier original
            $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);

            // j'utilise une instance de la classe Slugger et sa méthode slug pour
            // supprimer les caractères spéciaux, espaces etc du nom du fichier
            $safeFilename = $slugger->slug($originalFilename);
            // je rajoute au nom de l'image, un identifiant unique (au cas ou
            // l'image soit uploadée plusieurs fois)
            $newFilename = $safeFilename.'-'.uniqid().'.'.$image->guessExtension();

            // je déplace l'image dans le dossier public et je la renomme avec le nouveau nom créé
            $image->move(
                $this->getParameter('images_directory'),
                $newFilename
            );

            $article->setImage($newFilename);

            // alors on enregistre l'article en BDD
            $entityManager->persist($article);
            $entityManager->flush();

            $this->addFlash('success', 'Article enregistré !');
        }

        // j'affiche mon twig, en lui passant une variable
        // form, qui contient la vue du formulaire, c'est à dire,
        // le résultat de la méthode createView de la variable $form
        return $this->render("admin/insert_article.html.twig", [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/articles/delete/{id}", name="admin_delete_article")
     */
    public function deleteArticle($id, ArticleRepository $articleRepository, EntityManagerInterface $entityManager)
    {
        $article = $articleRepository->find($id);

        if (!is_null($article)) {
            $entityManager->remove($article);
            $entityManager->flush();

            $this->addFlash('success', 'Vous avez bien supprimé l\'article !');
        } else {
            $this->addFlash('error', 'Article introuvable ! ');
        }

        return $this->redirectToRoute('admin_articles');
    }


    /**
     * @Route("/admin/articles/update/{id}", name="admin_update_article")
     */
    public function updateArticle($id, ArticleRepository $articleRepository, EntityManagerInterface $entityManager, Request $request, SluggerInterface $slugger)
    {
        $article = $articleRepository->find($id);

        // j'ai utilisé en ligne de commandes "php bin/console make:form"
        // pour que Symfony me créé une classe qui contiendra "le plan", "le patron"
        // du formulaire pour créer les articles. C'est la classe ArticleType
        // j'utilise la méthode $this->createForm pour créer un formulaire
        // en utilisant le plan du formulaire (ArticleType) et une instance d'Article
        $form = $this->createForm(ArticleType::class, $article);

        // On "donne" à la variable qui contient le formulaire
        // une instance de la classe  Request
        // pour que le formulaire puisse récupérer toutes les données
        // des inputs et faire les setters sur $article automatiquement
        $form->handleRequest($request);

        // si le formulaire a été posté et que les données sont valides (valeurs
        // des inputs correspondent à ce qui est attendu en bdd pour la table article)
        if ($form->isSubmitted() && $form->isValid()) {

            // je récupère l'image dans le formulaire (l'image est en mapped false donc c'est à moi
            // de gérer l'upload
            $image = $form->get('image')->getData();

            // je récupère le nom du fichier original
            $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);

            // j'utilise une instance de la classe Slugger et sa méthode slug pour
            // supprimer les caractères spéciaux, espaces etc du nom du fichier
            $safeFilename = $slugger->slug($originalFilename);
            // je rajoute au nom de l'image, un identifiant unique (au cas ou
            // l'image soit uploadée plusieurs fois)
            $newFilename = $safeFilename.'-'.uniqid().'.'.$image->guessExtension();

            // je déplace l'image dans le dossier public et je la renomme avec le nouveau nom créé
            $image->move(
                $this->getParameter('images_directory'),
                $newFilename
            );

            // alors on enregistre l'article en BDD
            $entityManager->persist($article);
            $entityManager->flush();

            $this->addFlash('success', 'Article enregistré !');
        }

        // j'affiche mon twig, en lui passant une variable
        // form, qui contient la vue du formulaire, c'est à dire,
        // le résultat de la méthode createView de la variable $form
        return $this->render("admin/update_article.html.twig", [
            'form' => $form->createView(),
            'article' => $article
        ]);
    }

    /**
     * @Route("/admin/articles/search", name="admin_search_articles")
     */
    public function searchArticles(Request $request, ArticleRepository $articleRepository)
    {
        // je récupère les valeurs du formulaire dans ma route
        $search = $request->query->get('search');

        // je vais créer une méthode dans l'ArticleRepository
        // qui trouve un article en fonction d'un mot dans son titre ou son contenu
        $articles = $articleRepository->searchByWord($search);

        // je renvoie un fichier twig en lui passant les articles trouvé
        // et je les affiche

        return $this->render('admin/search_articles.html.twig', [
           'articles' => $articles
        ]);
    }


}
