<?php

namespace AppBundle\Controller;

use AppBundle\Entity\PostsToCats;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Poststocat controller.
 *
 * @Route("admin/ptc")
 */
class PostsToCatsController extends Controller
{
    /**
     * Lists all postsToCat entities.
     *
     * @Route("/", name="admin_ptc_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $postsToCats = $em->getRepository('AppBundle:PostsToCats')->findAll();

        return $this->render('poststocats/index.html.twig', array(
            'postsToCats' => $postsToCats,
        ));
    }

    /**
     * Creates a new postsToCat entity.
     *
     * @Route("/new", name="admin_ptc_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $postsToCat = new PostsToCats();
        $form = $this->createForm('AppBundle\Form\PostsToCatsType', $postsToCat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($postsToCat);
            $em->flush();

            return $this->redirectToRoute('admin_ptc_show', array('id' => $postsToCat->getId()));
        }

        return $this->render('poststocats/new.html.twig', array(
            'postsToCat' => $postsToCat,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a postsToCat entity.
     *
     * @Route("/{id}", name="admin_ptc_show")
     * @Method("GET")
     */
    public function showAction(PostsToCats $postsToCat)
    {
        $deleteForm = $this->createDeleteForm($postsToCat);

        return $this->render('poststocats/show.html.twig', array(
            'postsToCat' => $postsToCat,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing postsToCat entity.
     *
     * @Route("/{id}/edit", name="admin_ptc_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, PostsToCats $postsToCat)
    {
        $deleteForm = $this->createDeleteForm($postsToCat);
        $editForm = $this->createForm('AppBundle\Form\PostsToCatsType', $postsToCat);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_ptc_edit', array('id' => $postsToCat->getId()));
        }

        return $this->render('poststocats/edit.html.twig', array(
            'postsToCat' => $postsToCat,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a postsToCat entity.
     *
     * @Route("/{id}", name="admin_ptc_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, PostsToCats $postsToCat)
    {
        $form = $this->createDeleteForm($postsToCat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($postsToCat);
            $em->flush();
        }

        return $this->redirectToRoute('admin_ptc_index');
    }

    /**
     * Creates a form to delete a postsToCat entity.
     *
     * @param PostsToCats $postsToCat The postsToCat entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(PostsToCats $postsToCat)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_ptc_delete', array('id' => $postsToCat->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
