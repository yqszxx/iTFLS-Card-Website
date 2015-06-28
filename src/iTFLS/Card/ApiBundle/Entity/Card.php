<?php

namespace iTFLS\Card\ApiBundle\Entity;

use Application\Sonata\UserBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Asserts;

/**
 * Card
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="iTFLS\Card\ApiBundle\Entity\CardRepository")
 */
class Card
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
     * @ORM\Column(name="sn", type="string", length=8, unique=true)
     *
     * @Asserts\NotBlank()
     */
    private $sn;

    /**
     * @var array
     *
     * @ORM\Column(name="passwords", type="array")
     */
    private $passwords;

    /**
     * @var integer
     *
     * @ORM\OneToOne(targetEntity="Application\Sonata\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id", nullable=true)
     */
    private $owner;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="smallint")
     */
    private $status;


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
     * Set sn
     *
     * @param string $sn
     * @return Card
     */
    public function setSn($sn)
    {
        $this->sn = strtoupper($sn);

        return $this;
    }

    /**
     * Get sn
     *
     * @return string 
     */
    public function getSn()
    {
        return $this->sn;
    }

    /**
     * Set passwords
     *
     * @param array $passwords
     * @return Card
     */
    public function setPasswords($passwords)
    {
        $this->passwords = $passwords;

        return $this;
    }

    /**
     * Get passwords
     *
     * @return array 
     */
    public function getPasswords()
    {
        return $this->passwords;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return Card
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }



    /**
     * Set owner
     *
     * @param User $owner
     * @return Card
     */
    public function setOwner(User $owner = null)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get owner
     *
     * @return User
     */
    public function getOwner()
    {
        return $this->owner;
    }

    public function __toString()
    {
        return $this->getSn();
    }
}
