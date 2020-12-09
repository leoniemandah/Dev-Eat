<?php

namespace App\Entity;

use App\Repository\MealRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MealRepository::class)
 */
class Meal
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Picture;

    /**
     * @ORM\Column(type="float")
     */
    private $Price;

    /**
     * @ORM\Column(type="integer")
     */
    private $Note;

    /**
     * @ORM\ManyToOne(targetEntity=Restaurant::class, inversedBy="meals")
     */
    private $Restaurant;

    /**
     * @ORM\ManyToMany(targetEntity=Order::class, inversedBy="meals")
     */
    private $OrderMeal;

    public function __construct()
    {
        $this->OrderMeal = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->Picture;
    }

    public function setPicture(string $Picture): self
    {
        $this->Picture = $Picture;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->Price;
    }

    public function setPrice(float $Price): self
    {
        $this->Price = $Price;

        return $this;
    }

    public function getNote(): ?int
    {
        return $this->Note;
    }

    public function setNote(int $Note): self
    {
        $this->Note = $Note;

        return $this;
    }

    public function getRestaurant(): ?Restaurant
    {
        return $this->Restaurant;
    }

    public function setRestaurant(?Restaurant $Restaurant): self
    {
        $this->Restaurant = $Restaurant;

        return $this;
    }

    /**
     * @return Collection|Order[]
     */
    public function getOrderMeal(): Collection
    {
        return $this->OrderMeal;
    }

    public function addOrderMeal(Order $orderMeal): self
    {
        if (!$this->OrderMeal->contains($orderMeal)) {
            $this->OrderMeal[] = $orderMeal;
        }

        return $this;
    }

    public function removeOrderMeal(Order $orderMeal): self
    {
        $this->OrderMeal->removeElement($orderMeal);

        return $this;
    }
}
