<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 */
class Order
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $OrderHour;

    /**
     * @ORM\Column(type="date")
     */
    private $DeliveryHour;

    /**
     * @ORM\Column(type="boolean")
     */
    private $Status;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="orders")
     */
    private $User;

    /**
     * @ORM\ManyToMany(targetEntity=Meal::class, inversedBy="orders")
     */
    private $Meal;

    public function __construct()
    {
        $this->Meal = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderHour(): ?\DateTimeInterface
    {
        return $this->OrderHour;
    }

    public function setOrderHour(\DateTimeInterface $OrderHour): self
    {
        $this->OrderHour = $OrderHour;

        return $this;
    }

    public function getDeliveryHour(): ?\DateTimeInterface
    {
        return $this->DeliveryHour;
    }

    public function setDeliveryHour(\DateTimeInterface $DeliveryHour): self
    {
        $this->DeliveryHour = $DeliveryHour;

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->Status;
    }

    public function setStatus(bool $Status): self
    {
        $this->Status = $Status;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }

    /**
     * @return Collection|Meal[]
     */
    public function getMeal(): Collection
    {
        return $this->Meal;
    }

    public function addMeal(Meal $meal): self
    {
        if (!$this->Meal->contains($meal)) {
            $this->Meal[] = $meal;
        }

        return $this;
    }

    public function removeMeal(Meal $meal): self
    {
        $this->Meal->removeElement($meal);

        return $this;
    }
}
