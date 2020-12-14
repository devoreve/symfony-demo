<?php

function getConnection(): PDO
{
    return new PDO(
        'mysql:host=home.3wa.io:3307;dbname=live-38_blog;charset=UTF8', 
        'cedricleclinche', 
        'M2MyNzJkNGZiODk4OTIzMGFkMmFmYmE43Wa!', [
            // On active les erreurs lors des requêtes
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            // On récupère les résultats dans un tableau associatif uniquement
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
}