<?php

namespace App\Entity;

use App\Repository\WhishlistItemRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WhishlistItemRepository::class)
 */
class WhishlistItem
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;

    /**
     * @ORM\ManyToOne(targetEntity=Whishlist::class, inversedBy="items")
     * @ORM\JoinColumn(nullable=false)
     */
    private $whishlist;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getWhishlist(): ?Whishlist
    {
        return $this->whishlist;
    }

    public function setWhishlist(?Whishlist $whishlist): self
    {
        $this->whishlist = $whishlist;

        return $this;
    }
}
