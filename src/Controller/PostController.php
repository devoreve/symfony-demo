<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Entity\Post;
use PDO;

class PostController extends AbstractController
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
        
        // $query = $db->prepare('SELECT * FROM posts ORDER BY created_at DESC');
        // $query->execute();
        // $posts = $query->fetchAll();
        
        // Récupérer le repository de Post
        $repository = $this->getDoctrine()->getRepository(Post::class);
        $posts = $repository->findAll();
        
        return $this->render('posts/index.html.twig', [
            'posts' => $posts    
        ]);
    }
    
    public function show(int $id): Response
    {
        // $id correspond au numéro dans l'url
        
        // dd = var_dump + exit
        // dd($id);
        
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
        
        // $query = $db->prepare('SELECT * FROM posts WHERE id = ?');
        // $query->execute([
        //     $id
        // ]);
        
        // $post = $query->fetch();
        
        $repository = $this->getDoctrine()->getRepository(Post::class);
        $post = $repository->find($id);
        
        // Si l'article n'a pas été trouvé dans la bdd pour l'id spécifié
        if ($post === null) {
            throw new NotFoundHttpException("Cet article n'existe pas");
        }
        
        // $query = $db->prepare('SELECT * FROM comments WHERE post_id = ?');
        // $query->execute([
        //     $id 
        // ]);
        
        // $comments = $query->fetchAll();
        
        return $this->render('posts/show.html.twig', [
            'post' => $post,
            // 'comments' => $comments
        ]);
    }
    
    public function create(): Response
    {
        return $this->render('posts/create.html.twig');
    }
    
    public function store(): RedirectResponse
    {
        $request = Request::createFromGlobals();
        $formData = $request->request->all();       // Equivalent $_POST
        
        // Doctrine de faire le lien entre mon objet et la base de données
        $entityManager = $this->getDoctrine()->getManager();
        
        $post = new Post();
        $post->setTitle($request->request->get('title'));
        $post->setContent($request->request->get('content'));
        $post->setCreatedAt(new \Datetime());
        
        // Envoi dans la base de données
        $entityManager->persist($post);
        $entityManager->flush();
        
        return $this->redirectToRoute('posts.index');
    }
}