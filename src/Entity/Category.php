<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $category_name = null;

    #[ORM\ManyToMany(targetEntity: SmallBusiness::class, mappedBy: 'categories')]
    private Collection $smallBusinesses;

    public function __construct()
    {
        $this->smallBusinesses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategoryName(): ?string
    {
        return $this->category_name;
    }

    public function setCategoryName(string $category_name): static
    {
        $this->category_name = $category_name;

        return $this;
    }

    /**
     * @return Collection<int, SmallBusiness>
     */
    public function getSmallBusinesses(): Collection
    {
        return $this->smallBusinesses;
    }

    public function addSmallBusiness(SmallBusiness $smallBusiness): static
    {
        if (!$this->smallBusinesses->contains($smallBusiness)) {
            $this->smallBusinesses->add($smallBusiness);
            $smallBusiness->addCategory($this);
        }

        return $this;
    }

    public function removeSmallBusiness(SmallBusiness $smallBusiness): static
    {
        if ($this->smallBusinesses->removeElement($smallBusiness)) {
            $smallBusiness->removeCategory($this);
        }

        return $this;
    }
}
