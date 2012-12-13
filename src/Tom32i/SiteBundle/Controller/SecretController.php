<?php

namespace Tom32i\SiteBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Tom32i\SiteBundle\Entity\Secret;
use Tom32i\SiteBundle\Form\SecretType;

/**
 * Secret controller.
 *
 * @Route("/sudo/secret")
 */
class SecretController extends Controller
{
    /**
     * Lists all Secret entities.
     *
     * @Route("/", name="secret")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('Tom32iSiteBundle:Secret')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Secret entity.
     *
     * @Route("/{id}/show", name="secret_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('Tom32iSiteBundle:Secret')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Secret entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Secret entity.
     *
     * @Route("/new", name="secret_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Secret();
        $form   = $this->createForm(new SecretType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Secret entity.
     *
     * @Route("/create", name="secret_create")
     * @Method("POST")
     * @Template("Tom32iSiteBundle:Secret:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Secret();
        $form = $this->createForm(new SecretType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('secret_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Secret entity.
     *
     * @Route("/{id}/edit", name="secret_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('Tom32iSiteBundle:Secret')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Secret entity.');
        }

        $editForm = $this->createForm(new SecretType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Secret entity.
     *
     * @Route("/{id}/update", name="secret_update")
     * @Method("POST")
     * @Template("Tom32iSiteBundle:Secret:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('Tom32iSiteBundle:Secret')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Secret entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new SecretType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('secret_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Secret entity.
     *
     * @Route("/{id}/delete", name="secret_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('Tom32iSiteBundle:Secret')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Secret entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('secret'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
