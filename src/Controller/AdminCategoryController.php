<?php


namespace App\Controller;


use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminCategoryController extends AbstractController
{

    /**
     * @Route("admin/insert-category", name="admin_insert_category")
     */
    public function insertCategory(EntityManagerInterface $entityManager)
    {

        $category = new Category();

        $category->setTitle("Ecologie");
        $category->setColor("green");

        $entityManager->persist($category);
        $entityManager->flush();

        $this->addFlash('success', 'Vous avez bien ajouté la categorie !');

        return new Response('OK');
    }

    /**
     * @Route("admin/categories", name="admin_list_categories")
     */
    public function listCategories(CategoryRepository $categoryRepository)
    {
       $categories = $categoryRepository->findAll();

       return $this->render('admin/list_categories.html.twig', [
          'categories' => $categories
       ]);
    }

    /**
     * @Route("admin/categories/{id}", name="admin_show_category")
     */
    public function showCategory($id, CategoryRepository $categoryRepository)
    {
        $category = $categoryRepository->find($id);

        return $this->render('admin/show_category.html.twig', [
            'category' => $category
        ]);
    }

    /**
     * @Route("/admin/categories/delete/{id}", name="admin_delete_category")
     */
    public function deleteCategory($id, CategoryRepository $categoryRepository, EntityManagerInterface $entityManager)
    {
        $category = $categoryRepository->find($id);

        $entityManager->remove($category);
        $entityManager->flush();

        $this->addFlash('success', 'Vous avez bien supprimé la categorie !');

        return $this->redirectToRoute('admin_list_categories');
    }





}
