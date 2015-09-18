<?php

namespace TestAppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use TestAppBundle\Entity\Obrazki;
use TestAppBundle\Form\ObrazkiType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Obrazki controller.
 *
 * @Route("/Obrazki")
 */
class ObrazkiController extends Controller {

    /**
     * Lists all Obrazki entities.
     *
     * @Route("/", name="Obrazki")
     *
     * @Template()
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('TestAppBundle:Obrazki')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Obrazki entity.
     *
     * @Route("/ajax/new", name="Obrazki_create")
     * @Template("TestAppBundle:Obrazki:new.html.twig")
     */
    public function createAction(Request $request) {
        $entity = new Obrazki();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        $files = new \TestAppBundle\Component\File($this->get('kernel')->getRootDir());
        $files->setRozmiar(ini_get('post_max_size'));
        $files->setFormat(array("txt", "pdf", "doc", "rtf", "ppt", "odt", "ods", "jpeg",'jpg', "bmp", "png", "gif"));
        $files->setPath('test/');
        $odpowiedz = $files->zapiszplik('data0');

        if($odpowiedz=="Pliki zapisano"){
        $em = $this->getDoctrine()->getManager();
        $entity->setNazwa($files->getPath());

        $em->persist($entity);
        $em->flush();
        }
        $response = new JsonResponse(
                array(
            'nazwa' => $files->getname(),
            'rozmiar' => $files->getSize(),
            'typ' => $files->getType(),
            'tymczasowa' => $files->getTmpname(),
            'docelowa'=>$files->getPath(),        
            'wiadomosc' => $odpowiedz, 
             'status'=>$files->getStatus()));
        
        return $response;
        
    }

    /**
     * Creates a form to create a Obrazki entity.
     *
     * @param Obrazki $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Obrazki $entity) {
        $form = $this->createForm(new ObrazkiType(), $entity, array(
            'action' => $this->generateUrl('Obrazki_new'),
            'attr' => array('id' => 'myForm'),
            'method' => 'POST',
        ));

        $form->add('button', 'submit', array('label' => 'Upload', 'attr' => array('class' => 'btn btn-primary')));

        return $form;
    }

    /**
     * Displays a form to create a new Obrazki entity.
     *
     * @Route("/new", name="Obrazki_new")
     * 
     * @Template("TestAppBundle:Obrazki:new.html.twig")
     */
    public function newAction(Request $request) {
        $entity = new Obrazki();
        $form = $this->createCreateForm($entity);
        $obrazki = $this->getDoctrine()->getRepository('TestAppBundle:Obrazki')->findAll();

        return array(
            'obrazki' => $obrazki,
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a Obrazki entity.
     *
     * @Route("/{id}", name="Obrazki_show")
     * 
     * @Template()
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TestAppBundle:Obrazki')->find($id);



        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Obrazki entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Obrazki entity.
     *
     * @Route("/{id}/edit", name="Obrazki_edit")
     *
     * @Template()
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TestAppBundle:Obrazki')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Obrazki entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Creates a form to edit a Obrazki entity.
     *
     * @param Obrazki $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Obrazki $entity) {
        $form = $this->createForm(new ObrazkiType(), $entity, array(
            'action' => $this->generateUrl('Obrazki_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Obrazki entity.
     *
     * @Route("/{id}", name="Obrazki_update")
     * @Method("PUT")
     * @Template("TestAppBundle:Obrazki:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TestAppBundle:Obrazki')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Obrazki entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('Obrazki_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Obrazki entity.
     *
     * @Route("/{id}", name="Obrazki_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('TestAppBundle:Obrazki')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Obrazki entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('Obrazki'));
    }

    /**
     * Creates a form to delete a Obrazki entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('Obrazki_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm()
        ;
    }

}
