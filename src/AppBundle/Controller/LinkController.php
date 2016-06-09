<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Link;
use AppBundle\Form\LinkType;

/**
 * Link controller.
 *
 * @Route("/link")
 */
class LinkController extends Controller
{
    /**
     * Lists all Link entities.
     *
     * @Route("/", name="link_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $links = $em->getRepository('AppBundle:Link')->findAll();

        return $this->render('link/index.html.twig', array(
            'links' => $links,
        ));
    }

    /**
     * Creates a new Link entity.
     *
     * @Route("/new", name="link_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $link = new Link();
        $form = $this->createForm('AppBundle\Form\LinkType', $link);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($link);
            $em->flush();

            return $this->redirectToRoute('link_show', array('id' => $link->getId()));
        }

        return $this->render('link/new.html.twig', array(
            'link' => $link,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Link entity.
     *
     * @Route("/{id}", name="link_show")
     * @Method("GET")
     */
    public function showAction(Link $link)
    {
        $deleteForm = $this->createDeleteForm($link);

        return $this->render('link/show.html.twig', array(
            'link' => $link,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Link entity.
     *
     * @Route("/{id}/edit", name="link_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Link $link)
    {
        $deleteForm = $this->createDeleteForm($link);
        $editForm = $this->createForm('AppBundle\Form\LinkType', $link);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($link);
            $em->flush();

            return $this->redirectToRoute('link_edit', array('id' => $link->getId()));
        }

        return $this->render('link/edit.html.twig', array(
            'link' => $link,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Link entity.
     *
     * @Route("/{id}", name="link_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Link $link)
    {
        $form = $this->createDeleteForm($link);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($link);
            $em->flush();
        }

        return $this->redirectToRoute('link_index');
    }

    /**
     * Creates a form to delete a Link entity.
     *
     * @param Link $link The Link entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Link $link)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('link_delete', array('id' => $link->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
