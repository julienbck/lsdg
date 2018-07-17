<?php

namespace ForumBundle\Controller;


use ForumBundle\Entity\Forum;
use ForumBundle\Entity\Subforum;
use ForumBundle\Entity\Thread;
use ForumBundle\Entity\Post;
use FrontBundle\Entity\User;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

use ForumBundle\Form\ThreadType;
use ForumBundle\Form\PostType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ForumController extends Controller
{
  /**
   * @Route("/forum/index", name="forum_homepage")
   */
    public function indexAction()
    {
      $em = $this->getDoctrine()->getManager();

       // $forums = $forumList->findBy(array(), array('position' => 'ASC'));
        $forums = $em->getRepository('ForumBundle:Forum')->getForumWithSubForum();
        $nbThreadsAndPosts = $em->getRepository('ForumBundle:Forum')->getNbThreadsAndPostsInSubforum();

        $lastAuthor = $em->getRepository('ForumBundle:Subforum');

        $AllSubforum = $em->getRepository('ForumBundle:Subforum')->getSubforumId();



        $output2=[];
        foreach ($AllSubforum as $key =>  $value) {
          $output[] = $value->getId();
          $output2[]= $lastAuthor->getLastAuthor($output[$key]);
        }

        if($this->getUser() != null){
        $currentUsername = $this->getUser()->getUsername();
        return $this->render('@Forum/Forum/index.html.twig', ['forums' => $forums, 'nbThreadsAndPosts' => $nbThreadsAndPosts, 'getLastAuthor' => $output2, 'currentUsername' => $currentUsername]);
      } else {
        return $this->render('@Forum/Forum/index.html.twig', ['forums' => $forums, 'nbThreadsAndPosts' => $nbThreadsAndPosts, 'getLastAuthor' => $output2]);
    }
  }

    /**
     * @Route("/forum/get/{id}", name="forum_show_forum" )
     */

    #TODO
    public function showForumAction($id)
    {
      $repository = $this->getDoctrine()
      ->getManager()
      ->getRepository('ForumBundle:Forum');



      return $this->render('@Forum/Forum/show_forum.html.twig');

    }
    #TODO


    /**
     * @Route("/forum/subforum/{id}", name="forum_show_subforum")
     */
    public function showSubforumAction($id)
    {

      $em = $this->getDoctrine()->getManager();

      $subforum = $em->getRepository('ForumBundle:Subforum')->getSubforumWithThread($id);

      return $this->render('@Forum/Forum/show_subforum.html.twig', [
        'subforums' => $subforum,
      ]);

    }

    /**
     * @Route("/forum/newthread", name="forum_new_thread")
     */
    public function newThreadAction(Request $request)
    {
      $em = $this->getDoctrine()->getManager();
      $user = $this->getUser();

      $subforumId = $request->query->get('id');
      $subforum = $em->getRepository('ForumBundle:Subforum')->find($subforumId);

      $my_thread = new Thread();
      $my_post = new Post();
      $author = new User();
      $my_thread->addPost($my_post);



      // On inclue le formulaire après avoir appelé les sous-forums avec les sujets
      $form = $this->get('form.factory')->create(ThreadType::class, $my_thread);


      if ($request->isMethod('POST')){
        $form->handleRequest($request);

        if($form->isValid()){

          $my_thread->setSubforum($subforum);
          $my_thread->setUser($user);
          $user->addNbThread(1);
          $em->persist($subforum);

          $my_post->setThread($my_thread);
          $my_post->setUser($user);
          $em->persist($my_thread);
          $em->flush();


          $request->getSession()->getFlashBag()->add('notice', 'Sujet bien enregistrée');

          return $this->redirectToRoute('forum_view_thread', array('threadId' => $my_thread->getId()));
        }
      }

      return $this->render('@Forum/Forum/new_thread.html.twig', array( 'form' => $form->createView()));

    }

    /**
    * @Route("/forum/get/thread/{threadId}", name="forum_view_thread")
    */
    public function showThreadAction($threadId, Request $request)
    {
      $post = new Post();
      $user = $this->getUser();

      $em = $this->getDoctrine()->getManager();


      $threadToPost = $em->getRepository('ForumBundle:Thread')->find($threadId);

      $thread = $em->getRepository('ForumBundle:Thread')->getThread($threadId);

      $listpost = $em->getRepository('ForumBundle:Post')->findAll();
          $user->addNbPost(1);

      $form = $this->get('form.factory')->create(PostType::class, $post);
      if ($request->isMethod('POST')){
        $form->handleRequest($request);

        if($form->isValid()){

          $user->addNbPost(1);
          $post->setThread($threadToPost);
          $post->setUser($user);
          $em->persist($post);
          $em->flush();

          $request->getSession()->getFlashBag()->add('notice', 'Message bien enregistrée');

          return $this->redirectToRoute('forum_view_thread', array('threadId' => $threadToPost->getId()));
        }
      }
      return $this->render('@Forum/Forum/show_thread.html.twig', array('threads' => $thread, 'listpost' => $listpost, 'form' => $form->createView()));
    }
}
