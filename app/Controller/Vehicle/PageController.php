<?php

namespace App\Controller\Vehicle;

use Symfony\Component\HttpFoundation\Response;

class PageController
{
    public function index(): Response
    {
        ob_start();
        include __DIR__ . '/../../views/index.php';
        return new Response(ob_get_clean());
    }
}
