<?php

namespace ContactListBundle\Controller;

use ContactListBundle\Entity\Groups;
use ContactListBundle\Form\GroupsType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class GroupsController
 * @package ContactListBundle\Controller
 * @Route("/groups")
 */
class GroupsController extends Controller
{
    /**
     * @Route("/new")
     * @Template(":forms:form.html.twig")
     * @Method("GET")
     */
    public function formAction()
    {
        $group = new Groups();

        $form = $this->createForm(GroupsType::class, $group);

        return ['form' => $form->createView()];
    }

    /**
     * @Route("/new")
     * @Template(":forms:form.html.twig")
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        $group = new Groups();

        $form = $this->createForm(GroupsType::class, $group);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $em = $this->getDoctrine()->getManager();

            $em->persist($group);

            $em->flush();

            return $this->redirectToRoute('contactlist_groups_showall');
        }

        return ['form' => $form->createView()];

    }

    /**
     * @Route("/showAll")
     * @Template(":groups:show_all.html.twig")
     */
    public function showAllAction()
    {
        $groups = $this->getDoctrine()->getRepository('ContactListBundle:Groups')->findAll();

        return ['groups' => $groups];
    }

    /**
     * @Route("/show/{id}")
     * @Template(":groups:show_group.html.twig")
     */
    public function showByIdAction($id)
    {
        $group = $this->getDoctrine()->getRepository('ContactListBundle:Groups')->find($id);

        if(!$group){
            throw new $this->createNotFoundException('Group not found');
        }

        return ['group' => $group];
    }

    /**
     * @Route("/delete/{id}")
     */
    public function deleteAction($id)
    {
        $group = $this->getDoctrine()->getRepository('ContactListBundle:Groups')->find($id);

        if (!$group){
            throw new $this->createNotFoundException('Group not found');
        }

        $em = $this->getDoctrine()->getManager();

        $em->remove($group);

        $em->flush();

        return $this->redirectToRoute('contactlist_groups_showall');
    }
}
