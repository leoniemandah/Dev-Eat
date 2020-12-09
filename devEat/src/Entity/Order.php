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
     * @ORM\Column(type="integer")
     */
    private $NbrMeal;

    /**
     * @ORM\Column(type="float")
     */
    private $Price;

    /**
     * @ORM\Column(type="boolean")
     */
    private $Status;

    /**
     * @ORM\ManyToMany(targetEntity=Customer::class, inversedBy="orders")
     */
    private $CustomerOrder;

    /**
     * @ORM\ManyToMany(targetEntity=Meal::class, mappedBy="OrderMeal")
     */
    private $meals;

    public function __construct()
    {
        $this->CustomerOrder = new ArrayCollection();
        $this->meals = new ArrayCollection();
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

    public function getNbrMeal(): ?int
    {
        return $this->NbrMeal;
    }

    public function setNbrMeal(int $NbrMeal): self
    {
        $this->NbrMeal = $NbrMeal;

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

    public function getStatus(): ?bool
    {
        return $this->Status;
    }

    public function setStatus(bool $Status): self
    {
        $this->Status = $Status;

        return $this;
    }

    /**
     * @return Collection|Customer[]
     */
    public function getCustomerOrder(): Collection
    {
        return $this->CustomerOrder;
    }

    public function addCustomerOrder(Customer $customerOrder): self
    {
        if (!$this->CustomerOrder->contains($customerOrder)) {
            $this->CustomerOrder[] = $customerOrder;
        }

        return $this;
    }

    public function removeCustomerOrder(Customer $customerOrder): self
    {
        $this->CustomerOrder->removeElement($customerOrder);

        return $this;
    }

    /**
     * @return Collection|Meal[]
     */
    public function getMeals(): Collection
    {
        return $this->meals;
    }

    public function addMeal(Meal $meal): self
    {
        if (!$this->meals->contains($meal)) {
            $this->meals[] = $meal;
            $meal->addOrderMeal($this);
        }

        return $this;
    }

    public function removeMeal(Meal $meal): self
    {
        if ($this->meals->removeElement($meal)) {
            $meal->removeOrderMeal($this);
        }

        return $this;
    }
}
