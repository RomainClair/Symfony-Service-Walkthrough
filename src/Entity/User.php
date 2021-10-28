<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $LoyaltyDiscount;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLoyaltyDiscount(): ?float
    {
        return $this->LoyaltyDiscount;
    }

    public function setLoyaltyDiscount(float $LoyaltyDiscount): self
    {
        $this->LoyaltyDiscount = $LoyaltyDiscount;

        return $this;
    }
}
