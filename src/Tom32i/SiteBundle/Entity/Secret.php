<?php

namespace Tom32i\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Secret
 *
 * @ORM\Table(name="secret")
 * @ORM\Entity
 */
class Secret
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", nullable=true)
     */
    private $content;

    /**
     * @ORM\OneToOne(targetEntity="Tom32i\UserBundle\Entity\User", inversedBy="secret")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    // METHODS

    public function isComplete()
    {
        return strlen($this->content) > 10;
    }

    // GETTERS & SETTERS

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
     * Set content
     *
     * @param string $content
     * @return Secret
     */
    public function setContent($content)
    {
        $this->content = $content;
    
        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set user
     *
     * @param \Tom32i\UserBundle\Entity\User $user
     * @return Secret
     */
    public function setUser(\Tom32i\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \Tom32i\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}