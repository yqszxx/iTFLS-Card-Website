<?php

namespace iTFLS\Card\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(name="card_sn", type="string", length=8)
     */
    private $cardSN;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * @var float
     *
     * @ORM\Column(name="balance", type="float")
     */
    private $balance;


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
     * Get cardNo
     *
     * @return string
     */
    public function getCardSN()
    {
        return $this->cardSN;
    }

    /**
     * Set cardNo
     *
     * @param string $cardSN
     * @return Card
     */
    public function setCardSN($cardSN)
    {
        $this->cardSN = $cardSN;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return Card
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get balance
     *
     * @return float
     */
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * Set balance
     *
     * @param float $balance
     * @return Card
     */
    public function setBalance($balance)
    {
        $this->balance = $balance;

        return $this;
    }
}
