<?php

namespace App\CoreBundle\Controller;

use App\CoreBundle\Entity\Person;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PersonController extends Controller
{
    public function indexAction()
    {
        $em = $this->getManager();
        $entities = $em->getRepository(Person::class)->findAll();

        return $this->render('CoreBundle:Person:index.html.twig', [
            'entities' => $entities,
        ]);
    }

    public function createAction(Request $request)
    {
        $entity = new Person();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('person_show', ['id' => $entity->getId()]));
        }

        return $this->render('CoreBundle:Person:new.html.twig', [
            'entity' => $entity,
            'form' => $form->createView(),
        ]);
    }

    public function newAction()
    {
        $entity = new Person();
        $form = $this->createCreateForm($entity);

        return $this->render('CoreBundle:Person:new.html.twig', [
            'entity' => $entity,
            'form' => $form->createView(),
        ]);
    }

    public function showAction($id)
    {
        $em = $this->getManager();
        $entity = $em->getRepository(Person::class)->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Person entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CoreBundle:Person:show.html.twig', [
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    public function editAction($id)
    {
        $em = $this->getManager();

        $entity = $em->getRepository(Person::class)->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Person entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CoreBundle:Person:edit.html.twig', [
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    public function updateAction(Request $request, $id)
    {
        $em = $this->getManager();

        $entity = $em->getRepository(Person::class)->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Person entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->persist($editForm->getData()->getPerson());
            $em->flush();

            return $this->redirect($this->generateUrl('person_edit', ['id' => $id]));
        }

        return $this->render('CoreBundle:Person:edit.html.twig', [
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository(Person::class)->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Person entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('person'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('person_delete', ['id' => $id]))
            ->setMethod('DELETE')
            ->add('submit', 'submit', ['label' => 'Delete'])
            ->getForm()
        ;
    }

    private function createCreateForm(Person $entity)
    {
        $personDtoFactory = $this->get('app_core.factory.person_dto');

        $form = $this->createForm('person', $personDtoFactory->getPersonDto($entity), [
            'action' => $this->generateUrl('person_create'),
            'method' => 'POST',
        ]);

        $form->add('submit', 'submit', ['label' => 'Create']);

        return $form;
    }

    private function createEditForm(Person $entity)
    {
        $personDtoFactory = $this->get('app_core.factory.person_dto');

        $form = $this->createForm('person', $personDtoFactory->getPersonDto($entity), [
            'action' => $this->generateUrl('person_update', ['id' => $entity->getId()]),
            'method' => 'PUT',
        ]);

        $form->add('submit', 'submit', ['label' => 'Update']);

        return $form;
    }

    private function getManager()
    {
        return $this->get('neo4j.manager');
    }
}
