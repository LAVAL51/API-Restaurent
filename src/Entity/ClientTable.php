<?php

namespace App\Entity;

use App\Repository\ClientTableRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientTableRepository::class)]
class ClientTable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $numTable = null;

    #[ORM\Column(length: 255)]
    private ?string $salle = null;

    #[ORM\OneToMany(mappedBy: 'numTable', targetEntity: ClientOrder::class)]
    private Collection $clientOrders;

    public function __construct()
    {
        $this->clientOrders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumTable(): ?string
    {
        return $this->numTable;
    }

    public function setNumTable(string $numTable): self
    {
        $this->numTable = $numTable;

        return $this;
    }

    public function getSalle(): ?string
    {
        return $this->salle;
    }

    public function setSalle(string $salle): self
    {
        $this->salle = $salle;

        return $this;
    }

    /**
     * @return Collection<int, ClientOrder>
     */
    public function getClientOrders(): Collection
    {
        return $this->clientOrders;
    }

    public function addClientOrder(ClientOrder $clientOrder): self
    {
        if (!$this->clientOrders->contains($clientOrder)) {
            $this->clientOrders->add($clientOrder);
            $clientOrder->setNumTable($this);
        }

        return $this;
    }

    public function removeClientOrder(ClientOrder $clientOrder): self
    {
        if ($this->clientOrders->removeElement($clientOrder)) {
            // set the owning side to null (unless already changed)
            if ($clientOrder->getNumTable() === $this) {
                $clientOrder->setNumTable(null);
            }
        }

        return $this;
    }

  public function __toString(): string
  {
    return $this->numTable;
  }
}
