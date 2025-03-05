<?php

declare(strict_types=1);

// src/Controller/HelloWorldController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloWorldController
{
    // Route that accepts a 'name' parameter

    #[Route("/welcome/{name}")]

    public function welcome($name): Response
    {
        // Create an HTML response with a personalized welcome message
        return new Response('<html><body>Hello ' . htmlspecialchars($name) . ', welcome to Symfony!</body></html>');
    }
}

