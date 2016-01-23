<?php

namespace GlobalBundle\Controller;

use Doctrine\DBAL\Types\IntegerType;
use GlobalBundle\Entity\About;
use GlobalBundle\Tests\Controller\AboutControllerTest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Tests\Extension\Core\Type\SubmitTypeTest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AboutController extends Controller
{
    public function aboutAction()
    {
        $repository = $this->getDoctrine()->getEntityManager();
        $find = $repository->getRepository('GlobalBundle:About');

        return $this->render('GlobalBundle:About:index.html.twig', array('about' => $find->findAll()));
    }

    public function addAction(){

        $e = new About();

        $e->setName('About');
        $e->setDescription('Well Done!, This is a tiny description.');
        $e->setActive(1);

        $repository = $this->getDoctrine()->getEntityManager();

        $repository->persist($e);
        $repository->flush();

        return new Response('Now you have a new about row.');
    }

    public function newAction(Request $request){

        $about = new About();

        $about->setName('New About');
        $about->setDescription('New Description');
        $about->setActive(1);

        $form = $this->createFormBuilder($about)
            ->add('Name', TextType::class)
            ->add('Description', TextType::class)
            ->add('Active', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Criar Registro'))
        ->getForm();

        return $this->render(':default:index.html.twig', array('form' => $form->createView()));
    }
}
