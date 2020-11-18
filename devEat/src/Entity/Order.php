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
     * @ORM\Column(type="integer")
     */
    private $Price;

    /**
     * @ORM\Column(type="boolean")
     */
    private $Status;

    /**
     * @ORM\ManyToMany(targetEntity=customer::class)
     */
    private $Customer;

    public function __construct()
    {
        $this->Customer = new ArrayCollection();
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

    public function getPrice(): ?int
    {
        return $this->Price;
    }

    public function setPrice(int $Price): self
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
     * @return Collection|customer[]
     */
    public function getCustomer(): Collection
    {
        return $this->Customer;
    }

    public function addCustomer(customer $customer): self
    {
        if (!$this->Customer->contains($customer)) {
            $this->Customer[] = $customer;
        }

        return $this;
    }

    public function removeCustomer(customer $customer): self
    {
        $this->Customer->removeElement($customer);

        return $this;
    }
}
