<?php

namespace ContactListBundle\Controller;

use ContactListBundle\Entity\PhoneNumber;
use ContactListBundle\Form\PhoneNumberType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class PhoneNumberController
 * @package ContactListBundle\Controller
 * @Route("{id}/phoneNumber")
 */
class PhoneNumberController extends Controller
{
    /**
     * @Route("/new")
     * @Template(":forms:form.html.twig")
     * @Method("GET")
     */
    public function formAction()
    {
        $phoneNumber = new PhoneNumber();

        $form = $this->createForm(PhoneNumberType::class, $phoneNumber);

        return ['form' => $form->createView()];
    }

    /**
     * @Route("/new")
     * @Template(":forms:form.html.twig")
     * @Method("POST")
     */
    public function createAction(Request $request, $id)
    {
        $phoneNumber = new PhoneNumber();

        $form = $this->createForm(PhoneNumberType::class, $phoneNumber);

        $contact = $this ->getDoctrine()->getRepository('ContactListBundle:Contact')->find($id);

        if (!$contact){
            throw $this->createNotFoundException('Contact not found');
        }

        $phoneNumber->setContact($contact);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $em = $this->getDoctrine()->getManager();

            $em->persist($phoneNumber);

            $em->flush();

            return $this->redirectToRoute('contactlist_contact_showbyid', ['id' => $id]);
        }

        return ['form' => $form->createView()];

    }

    /**
     * @Route("/delete/{phoneNumberId}")
     */
    public function deleteAction($phoneNumberId, $id)
    {
        $phoneNumber = $this->getDoctrine()->getRepository('ContactListBundle:PhoneNumber')->find($phoneNumberId);

        if (!$phoneNumber){
            throw $this->createNotFoundException('Number not found');
        }

        $em = $this->getDoctrine()->getManager();

        $em->remove($phoneNumber);

        $em->flush();

        return $this->redirectToRoute('contactlist_contact_showbyid', ['id' => $id]);
    }
}
