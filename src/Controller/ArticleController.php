<?php


namespace App\Controller;


use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{

    /**
     * @Route("/articles", name="list_articles")
     */
    private function listArticles()
    {
        $articles = [
            1 => [
                'title' => 'Non, là c\'est sale',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam amet assumenda deserunt eius eveniet molestias necessitatibus non, quos sed sequi! Animi aspernatur assumenda earum laudantium odio quasi quibusdam quisquam veniam.',
                'publishedAt' => new \DateTime('NOW'),
                'isPublished' => true,
                'author' => 'Eric',
                'image' => 'https://media.gqmagazine.fr/photos/5b991bbe21de720011925e1b/master/w_780,h_511,c_limit/la_tour_montparnasse_infernale_1893.jpeg',
                'id' => 1
            ],
            2 => [
                'title' => 'Il faut trouver tous les gens qui étaient de dos hier',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam amet assumenda deserunt eius eveniet molestias necessitatibus non, quos sed sequi! Animi aspernatur assumenda earum laudantium odio quasi quibusdam quisquam veniam.',
                'publishedAt' => new \DateTime('NOW'),
                'isPublished' => true,
                'author' => 'Maurice',
                'image' => 'https://fr.web.img6.acsta.net/r_1280_720/medias/nmedia/18/35/18/13/18369680.jpg',
                'id' => 2
            ],
            3 => [
                'title' => 'Pluuutôôôôt Braaaaaach, Vasarelyyyyyy',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam amet assumenda deserunt eius eveniet molestias necessitatibus non, quos sed sequi! Animi aspernatur assumenda earum laudantium odio quasi quibusdam quisquam veniam.',
                'publishedAt' => new \DateTime('NOW'),
                'isPublished' => true,
                'author' => 'Didier',
                'image' => 'https://media.gqmagazine.fr/photos/5eb02109566df9b15ae026f3/master/pass/n-3freres.jpg',
                'id' => 3
            ],
            4 => [
                'title' => 'Quand on attaque l\'empire, l\'empire contre attaque',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam amet assumenda deserunt eius eveniet molestias necessitatibus non, quos sed sequi! Animi aspernatur assumenda earum laudantium odio quasi quibusdam quisquam veniam.',
                'publishedAt' => new \DateTime('NOW'),
                'isPublished' => true,
                'author' => 'Mbala',
                'image' => 'https://fr.web.img2.acsta.net/newsv7/21/01/20/15/49/5077377.jpg',
                'id' => 4
            ],
        ];

        return $this->render('list_articles.html.twig', [
            'articles' => $articles
        ]);

    }

    /**
     * @Route("/articles/{id}", name="show_article")
     */
    public function showArticle($id)
    {
        $articles = [
            1 => [
                'title' => 'Non, là c\'est sale',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam amet assumenda deserunt eius eveniet molestias necessitatibus non, quos sed sequi! Animi aspernatur assumenda earum laudantium odio quasi quibusdam quisquam veniam.',
                'publishedAt' => new \DateTime('NOW'),
                'isPublished' => true,
                'author' => 'Eric',
                'image' => 'https://media.gqmagazine.fr/photos/5b991bbe21de720011925e1b/master/w_780,h_511,c_limit/la_tour_montparnasse_infernale_1893.jpeg',
                'id' => 1
            ],
            2 => [
                'title' => 'Il faut trouver tous les gens qui étaient de dos hier',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam amet assumenda deserunt eius eveniet molestias necessitatibus non, quos sed sequi! Animi aspernatur assumenda earum laudantium odio quasi quibusdam quisquam veniam.',
                'publishedAt' => new \DateTime('NOW'),
                'isPublished' => true,
                'author' => 'Maurice',
                'image' => 'https://fr.web.img6.acsta.net/r_1280_720/medias/nmedia/18/35/18/13/18369680.jpg',
                'id' => 2
            ],
            3 => [
                'title' => 'Pluuutôôôôt Braaaaaach, Vasarelyyyyyy',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam amet assumenda deserunt eius eveniet molestias necessitatibus non, quos sed sequi! Animi aspernatur assumenda earum laudantium odio quasi quibusdam quisquam veniam.',
                'publishedAt' => new \DateTime('NOW'),
                'isPublished' => true,
                'author' => 'Didier',
                'image' => 'https://media.gqmagazine.fr/photos/5eb02109566df9b15ae026f3/master/pass/n-3freres.jpg',
                'id' => 3
            ],
            4 => [
                'title' => 'Quand on attaque l\'empire, l\'empire contre attaque',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam amet assumenda deserunt eius eveniet molestias necessitatibus non, quos sed sequi! Animi aspernatur assumenda earum laudantium odio quasi quibusdam quisquam veniam.',
                'publishedAt' => new \DateTime('NOW'),
                'isPublished' => true,
                'author' => 'Mbala',
                'image' => 'https://fr.web.img2.acsta.net/newsv7/21/01/20/15/49/5077377.jpg',
                'id' => 4
            ],
        ];

        $article = $articles[$id];

        return $this->render('show_article.html.twig', [
            'article' => $article
        ]);
    }

    /**
     * @Route("insert-article", name="insert_article")
     */
    public function insertArticle(EntityManagerInterface $entityManager)
    {
        // je créé une instance de la classe Article (classe d'entité)
        // dans le but de créer un nouvel article dans ma bdd (table article)

        $article = new Article();

        // j'utilise les setters du titre, du contenu etc
        // pour mettre les données voulues pour le titre, le contenu etc
        $article->setTitle("Chat mignon");
        $article->setContent("ouuuh qu'il est troumignoninou ce petit chat. Et si je lui roulais dessus avec mon SUV");
        $article->setPublishedAt(new \DateTime('NOW'));
        $article->setIsPublished(true);

        // j'utilise la classe EntityManagerInterface de Doctrine pour
        // enregistrer mon entité dans la bdd dans la table article (en
        // deux étapes avec le persist puis le flush)
        $entityManager->persist($article);
        $entityManager->flush();

        dump($article); die;
    }

}
