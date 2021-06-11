<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CoursRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CoursRepository::class)
 */
class Cours
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("cours:read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("cours:read")
     */
    private $nom;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="cours")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("cours:read")
     */
    private $categorie;

    

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="cours")
     * @Groups("cours:read")
     */
    private $autor;

    /**
     * @ORM\Column(type="string", length=999, nullable=true)
     * @Groups("cours:read")
     */
    private $img;

    /**
     * @ORM\Column(type="date")
     * @Groups("cours:read")
     */
    private $uploadDate;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups("cours:read")
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=CoursLike::class, mappedBy="cours")
     */
    private $likes;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="achat")
     */
    private $users;

    


    public function __construct()
    {
        $this->likes = new ArrayCollection();
        $this->users = new ArrayCollection();

    }

   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getCategorie(): ?Category
    {
        return $this->categorie;
    }

    public function setCategorie(?Category $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }


    public function getAutor(): ?User
    {
        return $this->autor;
    }

    public function setAutor(?User $autor): self
    {
        $this->autor = $autor;

        return $this;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(?string $img): self
    {
        $this->img = $img;

        return $this;
    }

    public function getUploadDate(): ?\DateTimeInterface
    {
        return $this->uploadDate;
    }

    public function setUploadDate(\DateTimeInterface $uploadDate): self
    {
        $this->uploadDate = $uploadDate;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|CoursLike[]
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(CoursLike $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes[] = $like;
            $like->setCours($this);
        }

        return $this;
    }

    public function removeLike(CoursLike $like): self
    {
        if ($this->likes->removeElement($like)) {
            // set the owning side to null (unless already changed)
            if ($like->getCours() === $this) {
                $like->setCours(null);
            }
        }

        return $this;
    }

    public function isLikedByUser(User $user):bool
    {
        foreach($this->likes as $like)
        {
            if($like->getUser() === $user)
            {
                return true;
            }
           
        }
        return false;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
          
        }

        return $this;
    }

   
}
