<?php

namespace AdminBundle\Controller;

use FrontBundle\Entity\Article;
use AdminBundle\Form\ArticleType;
use AdminBundle\Form\ArticleEditType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class AdminController extends Controller
{
  public function addAction(Request $request)
{
  $article = new Article();

  $form= $this->get('form.factory')->createBuilder(ArticleType::class, $article);


  $formBuilder = $form->getForm();
  if ($request->isMethod('POST')){
    $formBuilder->handleRequest($request);

    if($formBuilder->isValid()){
      $em = $this->getDoctrine()->getManager();
      $em->persist($article);
      $em->flush();

      $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée');

      return $this->redirectToRoute('lsdg_blog_view', array('id' => $article->getId()));
    }
  }

    return $this->render('@Admin/Default/index.html.twig', array(
      'form' => $formBuilder->createView()
    ));
  }
  public function editAction($id, Request $request)
{
  $em = $this->getDoctrine()->getManager();

    $article = $em->getRepository('FrontBundle:Article')->find($id);

    if (null === $article) {
      throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
    }

    $form= $this->get('form.factory')->createBuilder(ArticleEditType::class, $article);

    $formBuilder = $form->getForm();
    if ($request->isMethod('POST') && $formBuilder->handleRequest($request)->isValid()) {
      $em->flush();


      $request->getSession()->getFlashBag()->add('notice', 'Annonce bien modifiée.');

      return $this->redirectToRoute('lsdg_blog_view', array('id' => $article->getId()));
    }

    return $this->render('@Admin/Default/edit.html.twig', array(
      'article' => $article,
      'form'   => $formBuilder->createView(),
    ));
  }

  public function listArticleAction()
{
  $repository = $this->getDoctrine()
  ->getManager()
  ->getRepository('FrontBundle:Article');

  $listArticle = $repository->findAll();

  return $this->render('@Admin/Default/listarticle.html.twig', array('articles' => $listArticle));
  }
}
