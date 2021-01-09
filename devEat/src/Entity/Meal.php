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
     * @ORM\Column(type="float",nullable=true)
     */
    private $Price;

    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    private $Note;

    /**
     * @ORM\ManyToOne(targetEntity=Restaurant::class, inversedBy="meals, nullable=true")
     */
    private $Restaurant;

    /**
     * @ORM\OneToMany(targetEntity=OrderMeal::class, mappedBy="Meal")
     */
    private $orderMeals;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Category;



    public function __construct()
    {
        $this->orders = new ArrayCollection();
        $this->orderMeals = new ArrayCollection();
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
     * @return Collection|OrderMeal[]
     */
    public function getOrderMeals(): Collection
    {
        return $this->orderMeals;
    }

    public function addOrderMeal(OrderMeal $orderMeal): self
    {
        if (!$this->orderMeals->contains($orderMeal)) {
            $this->orderMeals[] = $orderMeal;
            $orderMeal->setMeal($this);
        }

        return $this;
    }

    public function removeOrderMeal(OrderMeal $orderMeal): self
    {
        if ($this->orderMeals->removeElement($orderMeal)) {
            // set the owning side to null (unless already changed)
            if ($orderMeal->getMeal() === $this) {
                $orderMeal->setMeal(null);
            }
        }

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->Category;
    }

    public function setCategory(string $Category): self
    {
        $this->Category = $Category;

        return $this;
    }


}
