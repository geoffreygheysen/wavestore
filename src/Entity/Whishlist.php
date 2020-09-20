<?php

namespace App\Entity;

use App\Repository\WhishlistRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WhishlistRepository::class)
 */
class Whishlist
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="whishlist", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=WhishlistItem::class, mappedBy="whishlist", orphanRemoval=true)
     */
    private $items;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|WhishlistItem[]
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(WhishlistItem $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items[] = $item;
            $item->setWhishlist($this);
        }

        return $this;
    }

    public function removeItem(WhishlistItem $item): self
    {
        if ($this->items->contains($item)) {
            $this->items->removeElement($item);
            // set the owning side to null (unless already changed)
            if ($item->getWhishlist() === $this) {
                $item->setWhishlist(null);
            }
        }

        return $this;
    }
}
