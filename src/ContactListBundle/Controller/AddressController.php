<?php

namespace ContactListBundle\Controller;

use ContactListBundle\Entity\Address;
use ContactListBundle\Form\AddressType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AddressController
 * @package ContactListBundle\Controller
 * @Route("{id}/address")
 */
class AddressController extends Controller
{
    /**
     * @Route("/new")
     * @Template(":address:form.html.twig")
     * @Method("GET")
     */
    public function formAction()
    {
        $address = new Address();

        $form = $this->createForm(AddressType::class, $address);

        return ['form' => $form->createView()];
    }

    /**
     * @Route("/new")
     * @Template(":address:form.html.twig")
     * @Method("POST")
     */
    public function createAction(Request $request, $id)
    {
        $address = new Address();

        $form = $this->createForm(AddressType::class, $address);

        $contact = $this->getDoctrine()->getRepository('ContactListBundle:Contact')->find($id);

        if (!$contact){
            throw new $this->createNotFoundException('Contact not found');
        }

        $address->setContact($contact);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $em = $this->getDoctrine()->getManager();

            $em->persist($address);

            $em->flush();

            return $this->redirectToRoute('contactlist_contact_showbyid', ['id' => $id]);

        }

        return ['form' => $form->createView()];

    }

    /**
     * @Route("/delete/{addressId}")
     */
    public function deleteAction($addressId, $id)
    {
        $address = $this->getDoctrine()->getRepository('ContactListBundle:Address')->find($addressId);

        if (!$address){
            throw new $this->createNotFoundException('Address not found');
        }

        $em = $this->getDoctrine()->getManager();

        $em->remove($address);

        $em->flush();

        return $this->redirectToRoute('contactlist_contact_showbyid',['id' => $id]);
    }
}
