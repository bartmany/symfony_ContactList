<?php

namespace ContactListBundle\Controller;

use ContactListBundle\Entity\Contact;
use ContactListBundle\Form\ContactType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ContactController extends Controller
{
    /**
     * @Route("/new")
     * @Template(":contact:form.html.twig")
     * @Method("GET")
     */
    public function formAction()
    {
        $contact = new Contact();

        $form = $this->createForm(ContactType::class, $contact);

        return ['form' => $form->createView()];

    }

    /**
     * @Route("/new")
     * @Template(":contact:form.html.twig")
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        $contact = new Contact();

        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $em = $this->getDoctrine()->getManager();

            $em->persist($contact);

            $em->flush();

            return $this->redirectToRoute('contactlist_contact_showbyid', ['id' => $contact->getId()]);
        }

        return ['form' => $form->createView()];

    }

    /**
     * @Route("/")
     * @Template(":contact:show_all.html.twig")
     */
    public function showAllAction()
    {
        $contacts = $this->getDoctrine()->getRepository('ContactListBundle:Contact')->findAllAndSortAZ();

        if (!$contacts){
            throw new $this->createNotFoundException('Contacts not found');
        }

        return ['contacts' => $contacts];

    }

    /**
     * @Route("/{id}/modify")
     * @Template(":contact:form.html.twig")
     * @Method("GET")
     */
    public function showEditFormAction($id)
    {
        $contact = $this->getDoctrine()->getRepository('ContactListBundle:Contact')->find($id);

        if (!$contact){
            throw new $this->createNotFoundException('Contact not found');
        }

        $form = $this->createForm(ContactType::class, $contact);

        return ['form' => $form->createView()];

    }

    /**
     * @Route("/{id}/modify")
     * @Template(":contact:form.html.twig")
     * @Method("POST")
     */
    public function saveEditFromAction(Request $request, $id)
    {
        $contact = $this->getDoctrine()->getRepository('ContactListBundle:Contact')->find($id);

        if (!$contact){
            throw $this->createNotFoundException('Contact not Found');
        }

        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $em = $this->getDoctrine()->getManager();

            $em->flush();

            return $this->redirectToRoute('contactlist_contact_showall');
        }

        return ['form' => $form->createView()];

    }

    /**
     * @Route("/{id}")
     * @Template(":contact:show_contact.html.twig")
     */
    public function showByIdAction($id)
    {
        $contact = $this->getDoctrine()->getRepository('ContactListBundle:Contact')->find($id);

        if (!$contact){
            throw new $this->createNotFoundException('Contact not found');
        }

        $addresses = $this->getDoctrine()->getRepository('ContactListBundle:Address')->findAllById($id);

        return ['contact' => $contact,
                'addresses' => $addresses];
    }

    /**
     * @Route("/delete/{id}")
     */
    public function deleteAction($id)
    {
        $contact = $this->getDoctrine()->getRepository('ContactListBundle:Contact')->find($id);

        if (!$contact){
            throw $this->createNotFoundException('Contact not found');
        }

        $em = $this->getDoctrine()->getManager();

        $em->remove($contact);

        $em->flush();

        return $this->redirectToRoute('contactlist_contact_showall');
    }

}
