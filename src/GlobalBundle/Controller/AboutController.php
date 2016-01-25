<?php

namespace GlobalBundle\Controller;

use Doctrine\DBAL\Types\IntegerType;
use GlobalBundle\Entity\About;
use Symfony\Component\Form\Forms;
use GlobalBundle\Tests\Controller\AboutControllerTest;
use Symfony\Component\Form\Tests\Extension\Core\Type\SubmitTypeTest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


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

        $about->setActive(1);

        $form = $this->createFormBuilder($about)
            ->add('name', 'text')
            ->add('description', 'text')
            ->add('save', 'submit', array('label' => 'Create Task'))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $repository = $this->getDoctrine()->getEntityManager();
            $repository->persist($about);
            $repository->flush();

            return $this->redirectToRoute('global_index');
        }

        return $this->render('GlobalBundle:About:form.html.twig', array('form' => $form->createView()));
    }
}
