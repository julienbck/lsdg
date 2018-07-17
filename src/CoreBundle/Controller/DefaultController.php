<?php

namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Core/Core/index.html.twig');
    }
    public function menuAction()
    {
      $repository = $this->getDoctrine()
      ->getManager()
      ->getRepository('FrontBundle:Category');

      if($this->getUser() != null){
      $currentUsername = $this->getUser()->getUsername();
      $listCategories = $repository->findAll();
      return $this->render('@Core/menugeneral.html.twig', ['listCategories' => $listCategories, 'currentUsername' => $currentUsername]);
    } else {



      $listCategories = $repository->findAll();
      return $this->render('@Core/menugeneral.html.twig', ['listCategories' => $listCategories]
    );}
    }
}
