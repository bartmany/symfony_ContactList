<?php

namespace ContactListBundle\Controller;

use ContactListBundle\Entity\Email;
use ContactListBundle\Form\EmailType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class EmailController
 * @package ContactListBundle\Controller
 * @Route("{id}/email")
 */
class EmailController extends Controller
{
    /**
     * @Route("/new")
     * @Template(":forms:form.html.twig")
     * @Method("GET")
     */
    public function formAction()
    {
        $email = new Email();

        $form = $this->createForm(EmailType::class, $email);

        return ['form' => $form->createView()];
    }

    /**
     * @Route("/new")
     * @Template(":forms:form.html.twig")
     * @Method("POST")
     */
    public function createAction(Request $request, $id)
    {
        $email = new Email();

        $form = $this->createForm(EmailType::class, $email);

        $contact = $this->getDoctrine()->getRepository('ContactListBundle:Contact')->find($id);

        if (!$contact){
            throw $this->createNotFoundException('Contact not found');
        }

        $email->setContact($contact);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $em = $this->getDoctrine()->getManager();

            $em->persist($email);

            $em->flush();

            return $this->redirectToRoute('contactlist_contact_showbyid', ['id' => $id]);
        }

        return ['form' => $form->createView()];

    }

    /**
     * @Route("/delete/{emailId}")
     */
    public function deleteAction($emailId, $id)
    {
        $email = $this->getDoctrine()->getRepository('ContactListBundle:Email')->find($emailId);

        if (!$email){
            throw $this->createNotFoundException('Email not found');
        }

        $em = $this->getDoctrine()->getManager();

        $em->remove($email);

        $em->flush();

        return $this->redirectToRoute('contactlist_contact_showbyid', ['id' => $id]);
    }
}
