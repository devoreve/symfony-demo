<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use PDO;
use App\Service\Db\Connection;
use App\Entity\Category;

class CategoryController extends AbstractController
{
    public function index(): Response
    {
        // $db = new PDO(
        //     'mysql:host=home.3wa.io:3307;dbname=live-38_blog;charset=UTF8', 
        //     'cedricleclinche', 
        //     'M2MyNzJkNGZiODk4OTIzMGFkMmFmYmE43Wa!', [
        //         // On active les erreurs lors des requêtes
        //         PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        //         // On récupère les résultats dans un tableau associatif uniquement
        //         PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        //     ]
        // );
        
        // $db = getConnection();
        
        // $query = $db->prepare('SELECT * FROM categories');
        // $query->execute();
        // $categories = $query->fetchAll();
        
        $repository = $this->getDoctrine()->getRepository(Category::class);
        $categories = $repository->findAll();
        
        return $this->render('categories/index.html.twig', [
            'categories' => $categories
        ]);
    }
    
    public function posts(int $id, Connection $connection): Response
    {
        // $db = new PDO(
        //     'mysql:host=home.3wa.io:3307;dbname=live-38_blog;charset=UTF8', 
        //     'cedricleclinche', 
        //     'M2MyNzJkNGZiODk4OTIzMGFkMmFmYmE43Wa!', [
        //         // On active les erreurs lors des requêtes
        //         PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        //         // On récupère les résultats dans un tableau associatif uniquement
        //         PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        //     ]
        // );
        
        // $db = $connection->getPdo();
        
        // $query = $db->prepare('
        //     SELECT * FROM posts 
        //     WHERE category_id = ? 
        //     ORDER BY created_at DESC
        // ');
        
        // $query->execute([
        //     $id 
        // ]);
        
        // $posts = $query->fetchAll();
        
        $repository = $this->getDoctrine()->getRepository(Category::class);
        $category = $repository->find($id);
        
        $posts = $category->getPosts();
        
        if (empty($posts)) {
            throw new NotFoundHttpException("Aucun post pour cette catégorie");
        }
        
        return $this->render('posts/index.html.twig', [
            'posts' => $posts 
        ]);
    }
}
