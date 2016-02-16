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

        return $this->render('GlobalBundle:About:index.html.twig', array('about' => $find->findBy(['active' => 1])));
    }

    public function boxAction()
    {
        $repository = $this->getDoctrine()->getEntityManager();
        $find = $repository->getRepository('GlobalBundle:About');

        return $this->render('@Global/About/box.html.twig', array('about' => $find->findBy(['active' => 1])));
    }

    public function findAboutByActiveAction($active)
    {
        $repository = $this->getDoctrine()->getEntityManager();
        $find = $repository->getRepository('GlobalBundle:About');

        switch ($active) {
            case 'Active':
                $filter = $find->findBy(['active' => 1]);
                break;
            case 'Inactive':
                $filter = $find->findBy(['active' => 0]);
                break;
            default:
                $filter = $find->findAll();
                break;
        }

        return $this->render('GlobalBundle:About:index.html.twig', array('about' => $filter));
    }

    public function EditAction(Request $request)
    {
        $repository = $this->getDoctrine()->getEntityManager();
        $about = $repository->getReference('GlobalBundle:About', $request->request->get('id'));

        $about->setName($request->request->get('name'));
        $about->setDescription($request->request->get('description'));
        $about->setActive($request->request->get('active'));

        $repository->flush();

        if(!$request->request->get('active')){
            return $this->redirectToRoute('global_ActiveAbout', array('active' => 'Inactive'));
        }

        return $this->redirectToRoute('global_index');
    }

    public function addAction(Request $request)
    {
        $about = new About();

        $about->setName($request->request->get('name'));
        $about->setDescription($request->request->get('description'));
        $about->setActive(1);

        $repository = $this->getDoctrine()->getEntityManager();
        $repository->persist($about);
        $repository->flush();

        return $this->redirectToRoute('global_index');
    }

    public function deleteAction($id)
    {
        $repository = $this->getDoctrine()->getEntityManager();
        $about = $repository->getReference('GlobalBundle:About', $id);
        $about->setactive(0);
        $repository->flush();

        return $this->redirectToRoute('global_index');
    }

    public function newAction(Request $request)
    {

        $about = new About();
        $about->setActive(1);

        $form = $this->createFormBuilder($about)
            ->add('name', 'text')
            ->add('description', 'text')
            ->add('save', 'submit', array('label' => 'Create Task'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $repository = $this->getDoctrine()->getEntityManager();
            $repository->persist($about);
            $repository->flush();

            return $this->redirectToRoute('global_index');
        }

        return $this->render('GlobalBundle:About:form.html.twig', array('form' => $form->createView()));
    }

}
