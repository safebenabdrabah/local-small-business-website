<?php

namespace App\Entity;

use App\Repository\ProfileRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProfileRepository::class)]
class Profile
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $full_Name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $profile_pic = null;

    #[ORM\OneToOne(inversedBy: 'profile', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $User = null;

    #[ORM\OneToMany(targetEntity: SmallBusiness::class, mappedBy: 'profile', orphanRemoval: true)]
    private Collection $smallBusinesses;

    public function __construct()
    {
        $this->smallBusinesses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullName(): ?string
    {
        return $this->full_Name;
    }

    public function setFullName(string $full_Name): static
    {
        $this->full_Name = $full_Name;

        return $this;
    }

    public function getProfilePic(): ?string
    {
        return $this->profile_pic;
    }

    public function setProfilePic(?string $profile_pic): static
    {
        $this->profile_pic = $profile_pic;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(User $User): static
    {
        $this->User = $User;

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
            $smallBusiness->setProfile($this);
        }

        return $this;
    }

    public function removeSmallBusiness(SmallBusiness $smallBusiness): static
    {
        if ($this->smallBusinesses->removeElement($smallBusiness)) {
            // set the owning side to null (unless already changed)
            if ($smallBusiness->getProfile() === $this) {
                $smallBusiness->setProfile(null);
            }
        }

        return $this;
    }

}
