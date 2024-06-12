<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

#[ORM\Entity]
#[ApiResource(
    normalizationContext: [
        'groups' => ['employee:read'],
        'enable_max_depth' => true,
    ],
    denormalizationContext: [
        'groups' => ['employee:write'],
    ]
)]
class Employee
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['employee:read', 'employee:write', 'company:read'])]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'employees')]
    #[Groups(['employee:read', 'employee:write'])]
    private ?Company $company = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['employee:read', 'employee:write', 'company:read'])]
    private ?string $email = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'subordinates')]
    #[Groups(['employee:read', 'employee:write', 'company:read'])]
    #[MaxDepth(1)]
    private ?self $manager = null;

    /**
     * @var Collection<int, self>
     */
    #[ORM\OneToMany(mappedBy: 'manager', targetEntity: self::class)]
    #[ApiProperty(readableLink: false, writableLink: false)]
    private Collection $subordinates;

    public function __construct()
    {
        $this->subordinates = new ArrayCollection();
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

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): static
    {
        $this->company = $company;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getManager(): ?self
    {
        return $this->manager;
    }

    public function setManager(?self $manager): static
    {
        $this->manager = $manager;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getSubordinates(): Collection
    {
        return $this->subordinates;
    }

    public function addSubordinate(self $subordinate): static
    {
        if (!$this->subordinates->contains($subordinate)) {
            $this->subordinates->add($subordinate);
            $subordinate->setManager($this);
        }

        return $this;
    }

    public function removeSubordinate(self $subordinate): static
    {
        if ($this->subordinates->removeElement($subordinate)) {
            // set the owning side to null (unless already changed)
            if ($subordinate->getManager() === $this) {
                $subordinate->setManager(null);
            }
        }

        return $this;
    }
}
