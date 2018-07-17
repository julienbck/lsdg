<?php

namespace FrontBundle\Controller;

use FrontBundle\Entity\Article;
use FrontBundle\Entity\Comment;
use FrontBundle\Entity\User;

use FrontBundle\Form\CommentType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class ArticleController extends Controller
{
    public function indexAction(Request $request)
    {
      // On récupère le repository

      $repository = $this->getDoctrine()
      ->getManager()
      ->getRepository('FrontBundle:Article');

        $output = [];
        $categories = $this->getDoctrine()->getManager()->getRepository('FrontBundle:Category')->findAll();
        foreach ($categories as $value) {
          $output[]=$repository->getArticleWithCategoriesLimit($value->getId());
        }
        $lastArticle = $repository->findBy( array() ,array('date' => 'desc'), 3, 0);

        return $this->render('@Front/Default/index.html.twig', array('lastArticle' => $lastArticle, 'output' => $output, 'categories' => $categories
      ));
    }

    public function viewAction($id, Request $request)
    {
      //Création de l'objet comment
      $comment = new Comment();

      // On récupère le repository
      $repository = $this->getDoctrine()
        ->getManager()
        ->getRepository('FrontBundle:Article')
      ;

      $lastArticle = $repository->findBy( array() ,array('date' => 'desc'), 4, 0);
      // On récupère l'entité correspondante à l'id $id
      $article = $repository->find($id);
      $articleComments = $repository->getArticleWithCommentAndNoComment($id);

      $user = $this->getUser();

      // $article est donc une instance de OC\PlatformBundle\Entity\Advert
      // ou null si l'id $id  n'existe pas, d'où ce if :
      if (null === $article) {
        throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
      }

      $em = $this->getDoctrine()->getManager();

      // //On récupère le contenu de l'article avec son id. Cela permet d'aller voir en détail l'article voulu.
      // $articleComment = $em->getRepository('FrontBundle:Article')->find($id);

      // Je créé le formulaire pour les commentaires
      $form = $this->get('form.factory')->create(CommentType::class, $comment);


      //Je récupère tous les commentaires liés à l'article
      $commentsByArticle = $em->getRepository('FrontBundle:Comment')->findBy(array('article' => $id));




      if ($request->isMethod('POST') &&       $form->handleRequest($request)->isValid()) {
        //Je renseigne le change $article avec l'Id de l'article
        $comment->setArticle($article);
        $comment->setUser($user);
        $em->persist($comment);
        $em->flush();

        $request->getSession()->getFlashBag()->add('notice', 'Commentaire bien posté');

        return $this->redirectToRoute('lsdg_blog_view', array('id' => $article->getId()));
      }
    return $this->render('@Front/Default/view.html.twig', array(
      'article' => $articleComments,
      'form'   => $form->createView(),
      'comment' => $commentsByArticle,
      'currentUser' => $user,
      'lastArticle' => $lastArticle
    ));
    }

    public function viewCategoryAction($id)
    {

      // On récupère le repository
      $repoArticle = $this->getDoctrine()
        ->getManager()
        ->getRepository('FrontBundle:Article')
      ;

      $repoCategory = $this->getDoctrine()
        ->getManager()
        ->getRepository('FrontBundle:Category')
      ;
      // On récupère l'entité correspondante à l'id $id
      $category = $repoCategory->find($id);

      if (null === $category) {
        throw new NotFoundHttpException("La catégorie ".$id." n'existe pas.");
      }

      $articles = $repoArticle->getArticleWithCategories($id);

    return $this->render('@Front/Default/category.html.twig', array(
      'articles' => $articles
    ));
    }
}
