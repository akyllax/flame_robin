<?php
// src/AppBundle/Controller/AdminController.php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;


/**
 * Admin Controller.
 *
 * @Route("/admin")
 * @Security("has_role('ROLE_SUPER_ADMIN')")
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
      $em = $this->getDoctrine()->getManager();
      $users = $em->getRepository('AppBundle:User')->findAll();

      return $this->render('admin/index.html.twig', array(
    'users' => $users,
  ));
  }

  /**
   * Displays a form to edit an existing User entity.
   *
   * @Route("/{id}/edit", name="admin_edit")
   * @Method({"GET", "POST"})
   */
  public function editAction(Request $request, User $user)
  {
      $editForm = $this->createForm('AppBundle\Form\AdminType', $user);
      $editForm->handleRequest($request);

      if ($editForm->isSubmitted() && $editForm->isValid()) {
          $em = $this->getDoctrine()->getManager();
          $em->persist($user);
          $em->flush();

          return $this->redirectToRoute('admin_edit', array('id' => $user->getId()));
      }

      return $this->render('admin/edit.html.twig', array(
          'user' => $user,
          'edit_form' => $editForm->createView(),
      ));
  }
}
