<?php

namespace App\Entity;

use App\Repository\OrderMealRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderMealRepository::class)
 */
class OrderMeal
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Meal::class, inversedBy="orderMeals")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Meal;

    /**
     * @ORM\ManyToOne(targetEntity=Order::class, inversedBy="orderMeals", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $OrderId;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMeal(): ?Meal
    {
        return $this->Meal;
    }

    public function setMeal(?Meal $Meal): self
    {
        $this->Meal = $Meal;

        return $this;
    }

    public function getOrderId(): ?Order
    {
        return $this->OrderId;
    }

    public function setOrderId(?Order $OrderId): self
    {
        $this->OrderId = $OrderId;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }
}
