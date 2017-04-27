<?php

namespace ContactListBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Contact
 *
 * @ORM\Table(name="contact")
 * @ORM\Entity(repositoryClass="ContactListBundle\Repository\ContactRepository")
 */
class Contact
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="Name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="ContactListBundle\Entity\Address", mappedBy="contact")
     */
    private $addresses;

    /**
     * @ORM\OneToMany(targetEntity="ContactListBundle\Entity\PhoneNumber", mappedBy="contact")
     */
    private $phonenumbers;

    /**
     * @ORM\OneToMany(targetEntity="ContactListBundle\Entity\Email", mappedBy="contact")
     */
    private $emails;

    /**
     * @ORM\ManyToMany(targetEntity="ContactListBundle\Entity\Groups", mappedBy="contacts")
     * @ORM\JoinTable(name="groups_contact")
     */
    private $groups;

    public function __construct()
    {
        $this->addresses = new ArrayCollection();
        $this->phonenumbers = new ArrayCollection();
        $this->emails = new ArrayCollection();
        $this->groups = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Contact
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Contact
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Add addresses
     *
     * @param \ContactListBundle\Entity\Address $addresses
     * @return Contact
     */
    public function addAddress(\ContactListBundle\Entity\Address $addresses)
    {
        $this->addresses[] = $addresses;

        return $this;
    }

    /**
     * Remove addresses
     *
     * @param \ContactListBundle\Entity\Address $addresses
     */
    public function removeAddress(\ContactListBundle\Entity\Address $addresses)
    {
        $this->addresses->removeElement($addresses);
    }

    /**
     * Get addresses
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAddresses()
    {
        return $this->addresses;
    }

    /**
     * Add phonenumbers
     *
     * @param \ContactListBundle\Entity\PhoneNumber $phonenumbers
     * @return Contact
     */
    public function addPhonenumber(\ContactListBundle\Entity\PhoneNumber $phonenumbers)
    {
        $this->phonenumbers[] = $phonenumbers;

        return $this;
    }

    /**
     * Remove phonenumbers
     *
     * @param \ContactListBundle\Entity\PhoneNumber $phonenumbers
     */
    public function removePhonenumber(\ContactListBundle\Entity\PhoneNumber $phonenumbers)
    {
        $this->phonenumbers->removeElement($phonenumbers);
    }

    /**
     * Get phonenumbers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPhonenumbers()
    {
        return $this->phonenumbers;
    }

    /**
     * Add emails
     *
     * @param \ContactListBundle\Entity\Email $emails
     * @return Contact
     */
    public function addEmail(\ContactListBundle\Entity\Email $emails)
    {
        $this->emails[] = $emails;

        return $this;
    }

    /**
     * Remove emails
     *
     * @param \ContactListBundle\Entity\Email $emails
     */
    public function removeEmail(\ContactListBundle\Entity\Email $emails)
    {
        $this->emails->removeElement($emails);
    }

    /**
     * Get emails
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEmails()
    {
        return $this->emails;
    }

    /**
     * Add groups
     *
     * @param \ContactListBundle\Entity\Groups $groups
     * @return Contact
     */
    public function addGroup(\ContactListBundle\Entity\Groups $groups)
    {
        $this->groups[] = $groups;

        return $this;
    }

    /**
     * Remove groups
     *
     * @param \ContactListBundle\Entity\Groups $groups
     */
    public function removeGroup(\ContactListBundle\Entity\Groups $groups)
    {
        $this->groups->removeElement($groups);
    }

    /**
     * Get groups
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGroups()
    {
        return $this->groups;
    }
}
