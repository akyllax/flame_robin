<?php
// src/AppBundle/Controller/AllPostsController.php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Post;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Admin Controller.
 *
 * @Route("/allposts")
 * @Security("has_role('ROLE_ADMIN')")
 */
class AllPostsController extends Controller
{
    /**
   * Lists Post entities.
   *
   * @Route("/", name="all_posts_index")
   * @Method("GET")
   */
  public function indexAction()
  {
      $em = $this->getDoctrine()->getManager();
          $posts = $em->getRepository('AppBundle:Post')->findAll();

      return $this->render('post/index.html.twig', array(
          'posts' => $posts,
      ));
  }
}
