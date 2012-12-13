<?php

namespace Tom32i\UserBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Tom32i\SiteBundle\Entity\Secret;

/**
 * @ORM\Entity
 * @ORM\Table(name="account")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="Tom32i\SiteBundle\Entity\Secret", mappedBy="user", cascade={"persist","remove"}, orphanRemoval=true)
     */
    private $secret;

    // META

    public function __construct()
    {
        parent::__construct();
        
        $secret = new Secret();
        $secret->setUser($this);

        $this->secret = $secret;
    }

    // METHODS
    
    /**
     * Set secret
     *
     * @param \Tom32i\SiteBundle\Entity\Secret $secret
     * @return Secret
     */
    public function setSecret(\Tom32i\SiteBundle\Entity\Secret $secret = null)
    {
        $this->secret = $secret;
    
        return $this;
    }

    /**
     * Get secret
     *
     * @return \Tom32i\SiteBundle\Entity\Secret 
     */
    public function getSecret()
    {
        return $this->secret;
    }
}