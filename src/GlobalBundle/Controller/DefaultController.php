<?php

namespace GlobalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('GlobalBundle:Default:index.html.twig', array('name' => $name));
    }
}
