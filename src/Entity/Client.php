<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column]
    private ?bool $validztion = null;

    /**
     * @var Collection<int, Market>
     */
    #[ORM\OneToMany(targetEntity: Market::class, mappedBy: 'Client')]
    private Collection $Market;

    public function __construct()
    {
        $this->Market = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getValidztion(): ?bool
    {
        return $this->validztion;
    }

    public function setValidztion(bool $validztion): static
    {
        $this->validztion = $validztion;

        return $this;
    }

    /**
     * @return Collection<int, Market>
     */
    public function getMarket(): Collection
    {
        return $this->Market;
    }

    public function addMarket(Market $market): static
    {
        if (!$this->Market->contains($market)) {
            $this->Market->add($market);
            $market->setClient($this);
        }

        return $this;
    }

    public function removeMarket(Market $market): static
    {
        if ($this->Market->removeElement($market)) {
            // set the owning side to null (unless already changed)
            if ($market->getClient() === $this) {
                $market->setClient(null);
            }
        }

        return $this;
    }
}
