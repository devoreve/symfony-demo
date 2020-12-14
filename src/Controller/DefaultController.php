<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use PDO;

class DefaultController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('homepage.html.twig');
        // return new Response('<h1>Hello world</h1>');
    }
    
    public function test(): Response
    {
        $adminEmail = $this->getParameter('app.admin_email');
        var_dump($adminEmail);
        
        $db = new PDO(
            'mysql:host=home.3wa.io:3307;dbname=live-38_blog;charset=UTF8', 
            'cedricleclinche', 
            'M2MyNzJkNGZiODk4OTIzMGFkMmFmYmE43Wa!', [
                // On active les erreurs lors des requêtes
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                // On récupère les résultats dans un tableau associatif uniquement
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]
        );
        
        $query = $db->prepare('SELECT * FROM posts');
        $query->execute();
        $posts = $query->fetchAll();
        // dd($posts);
        
        // Passer des informations du contrôleur vers twig
        $days = [
            'Lundi',
            'Mardi',
            'Mercredi',
            'Jeudi',
            'Vendredi',
            'Samedi',
            'Dimanche'
        ];
        
        $user = [
            'firstname' => 'John',
            'lastname' => 'Doe',
            'birthdate' => '1980-05-03',
            'friends' => [
                [
                    'firstname' => 'Jane',
                    'lastname' => 'Doe',
                    'birthdate' => '1985-12-25',
                ],
                [
                    'firstname' => 'Jay',
                    'lastname' => 'Doe',
                    'birthdate' => '2000-01-26',
                ],
            ]
        ];
        
        // Affichage du template
        // 1er paramètre : nom du template
        // 2ème paramètre : un tableau contenant les variables à passer à la vue
        // La clé correspond au nom de la variable
        // La valeur correspond au contenu
        return $this->render('test.html.twig', [
            'days' => $days,            // Création d'une variable days dans la vue
            'toto' => 'Hello world',    // Création d'une variable toto dans la vue
            'user' => $user,
        ]);
        // return new Response('<h1>Ceci est un test</h1>');
    }
}