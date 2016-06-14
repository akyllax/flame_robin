<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\PostImage;

/**
 * PostImage controller.
 *
 * @Route("/postimage")
 */
class PostImageController extends Controller
{
    /**
     * Lists all PostImage entities.
     *
     * @Route("/", name="postimage_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $postImages = $em->getRepository('AppBundle:PostImage')->findAll();

        return $this->render('postimage/index.html.twig', array(
            'postImages' => $postImages,
        ));
    }

    /**
     * Creates a new PostImage entity.
     *
     * @Route("/new", name="postimage_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $postImage = new PostImage();
        $form = $this->createForm('AppBundle\Form\PostImageType', $postImage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($postImage);

          $post_title = $postImage->getPost()->getTitle();

            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $postImage->getImage();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
            $this->container->getParameter('post_image').$post_title,
            $fileName
            );
            $path = '../web/assets/post_images/'.$post_title.'/';
            $postImage->setPath($path);
            $postImage->setImage($fileName);
            $postImage->setImageName($fileName);
            $em->flush();

            return $this->redirectToRoute('postimage_show', array('id' => $postImage->getId()));
        }

        return $this->render('postimage/new.html.twig', array(
            'postImage' => $postImage,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a PostImage entity.
     *
     * @Route("/{id}", name="postimage_show")
     * @Method("GET")
     */
    public function showAction(PostImage $postImage)
    {
        $deleteForm = $this->createDeleteForm($postImage);

        return $this->render('postimage/show.html.twig', array(
            'postImage' => $postImage,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing PostImage entity.
     *
     * @Route("/{id}/edit", name="postimage_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, PostImage $postImage)
    {
        $deleteForm = $this->createDeleteForm($postImage);
        $editForm = $this->createForm('AppBundle\Form\PostImageType', $postImage);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($postImage);
            $em->flush();

            return $this->redirectToRoute('postimage_edit', array('id' => $postImage->getId()));
        }

        return $this->render('postimage/edit.html.twig', array(
            'postImage' => $postImage,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a PostImage entity.
     *
     * @Route("/{id}", name="postimage_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, PostImage $postImage)
    {
        $form = $this->createDeleteForm($postImage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($postImage);
            $em->flush();
        }

        return $this->redirectToRoute('postimage_index');
    }

    /**
     * Creates a form to delete a PostImage entity.
     *
     * @param PostImage $postImage The PostImage entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(PostImage $postImage)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('postimage_delete', array('id' => $postImage->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
