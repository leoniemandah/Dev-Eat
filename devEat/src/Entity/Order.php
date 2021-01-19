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
     * @ORM\Column(type="datetime")
     */
    private $OrderHour;

    /**
     * @ORM\Column(type="datetime")
     */
    private $DeliveryHour;

    /**
     * @ORM\Column(type="boolean")
     */
    private $Status;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="orders", cascade={"persist", "remove"})
     */
    private $User;

    /**
     * @ORM\OneToMany(targetEntity=OrderMeal::class, mappedBy="OrderId", cascade={"persist", "remove"})
     */
    private $orderMeals;



    public function __construct()
    {
        $this->Meal = new ArrayCollection();
        $this->orderMeals = new ArrayCollection();
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
            $orderMeal->setOrderId($this);
        }

        return $this;
    }

    public function removeOrderMeal(OrderMeal $orderMeal): self
    {
        if ($this->orderMeals->removeElement($orderMeal)) {
            // set the owning side to null (unless already changed)
            if ($orderMeal->getOrderId() === $this) {
                $orderMeal->setOrderId(null);
            }
        }

        return $this;
    }

   

}
