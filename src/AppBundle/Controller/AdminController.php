<?php
// src/AppBundle/Controller/AdminController.php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Post;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Admin Controller.
 *
 * @Route("/admin")
 * @Security("has_role('ROLE_AUTHOR')")
 */
class AdminController extends Controller
{
    /**
   * Lists Post entities.
   *
   * @Route("/", name="admin_index")
   * @Method("GET")
   */
  public function indexAction()
  {
      // var_dump($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN'));
      $em = $this->getDoctrine()->getManager();
      if (true === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
          $posts = $em->getRepository('AppBundle:Post')->findAll();
      } elseif (true === $this->get('security.authorization_checker')->isGranted('ROLE_AUTHOR')) {
          $current_user_id = $this->getUser()->getId();
          $userEntity = $this->getUser();
          $posts = $em->getRepository('AppBundle:Post')->findBy(['author' => $userEntity]);
      }

      return $this->render('post/index.html.twig', array(
          'posts' => $posts,
      ));
  }
}
