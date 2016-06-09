<?php
// src/AppBundle/Controller/SecurityController.php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class SecurityController extends Controller
{
    /**
   * @Route("/login", name="login")
   */
  public function loginAction(Request $request)
  {
      $authenticationUtils = $this->get('security.authentication_utils');

    //get login error
    $error = $authenticationUtils->getLastAuthenticationError();


    //last username entered by the username
    $lastUsername = $authenticationUtils->getLastUsername();
      return $this->render(
    'security/login.html.twig',
    array(
      //last username entered by the user
      'last_username' => $lastUsername,
      'error' => $error,
        )
    );
  }

  /**
   * @Route("/login_check", name="login_check")
   */
  public function loginCheckAction()
  {
      //handled by the security system\

  }
  /**
   * @Route("/logout", name="logout")
   */
  public function logoutAction()
  {
    $session = $request->getSession();

    // get the login error if there is one
    $error = $session->get(SecurityContextInterface::AUTHENTICATION_ERROR);
    $session->remove(SecurityContextInterface::AUTHENTICATION_ERROR);

    return array(
        // last username entered by the user
        'last_username' => $session->get(SecurityContextInterface::LAST_USERNAME),
        'error'         => $error,
    );
  }
}
