<?php
// src/AppBundle/Controller/MyPostsController.php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Post;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * MyPosts Controller.
 *
 * @Route("/myposts")
 * @Security("has_role('ROLE_AUTHOR')")
 */
class MyPostsController extends Controller
{
    /**
   * Lists Post entities.
   *
   * @Route("/", name="my_posts_index")
   * @Method("GET")
   */
  public function indexAction()
  {
      $em = $this->getDoctrine()->getManager();
      $userEntity = $this->getUser();
      $posts = $em->getRepository('AppBundle:Post')->findBy(['author' => $userEntity]);

      return $this->render('post/index.html.twig', array(
          'posts' => $posts,
      ));
  }
}
