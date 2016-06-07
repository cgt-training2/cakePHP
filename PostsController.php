<?php
// src/Controller/PostsController.php

namespace App\Controller;

class PostsController extends AppController
{
    public function index()
    {
        $posts = $this->Posts->find('all');
        $this->set(compact('testCake'));
    }
}