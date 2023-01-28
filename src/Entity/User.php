<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User implements PasswordAuthenticatedUserInterface, UserInterface
{
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  private ?int $id = null;

  #[ORM\Column(type: "string", length: 180, unique: true)]
  private ?string $Username = null;

  #[ORM\Column(length: 255)]
  private ?string $Email = null;

  #[ORM\Column(length: 255)]
  private ?string $Firstname = null;

  #[ORM\Column(length: 255)]
  private ?string $Lastname = null;

  #[ORM\Column(length: 255)]
  private ?string $JobTitle = null;

  #[ORM\Column]
  private ?bool $Enabled = null;

  #[ORM\Column]
  private ?\DateTimeImmutable $CreatedAt = null;

  #[ORM\Column]
  private ?\DateTimeImmutable $UpdatedAt = null;

  #[ORM\Column(type: "json")]
  private array $roles = [];

  #[ORM\Column(type: "string", length: 255)]
  private ?string $password = null;

  #[ORM\OneToMany(mappedBy: 'serveur', targetEntity: ClientOrder::class)]
  private Collection $clientOrders;

  public function __construct()
  {
      $this->clientOrders = new ArrayCollection();
  }

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getUsername(): ?string
  {
    return $this->Username;
  }

  public function setUsername(string $Username): self
  {
    $this->Username = $Username;

    return $this;
  }

  public function getEmail(): ?string
  {
    return $this->Email;
  }

  public function setEmail(string $Email): self
  {
    $this->Email = $Email;

    return $this;
  }

  public function getFirstname(): ?string
  {
    return $this->Firstname;
  }

  public function setFirstname(string $Firstname): self
  {
    $this->Firstname = $Firstname;

    return $this;
  }

  public function getLastname(): ?string
  {
    return $this->Lastname;
  }

  public function setLastname(string $Lastname): self
  {
    $this->Lastname = $Lastname;

    return $this;
  }

  public function getJobTitle(): ?string
  {
    return $this->JobTitle;
  }

  public function setJobTitle(string $JobTitle): self
  {
    $this->JobTitle = $JobTitle;

    return $this;
  }

  public function isEnabled(): ?bool
  {
    return $this->Enabled;
  }

  public function setEnabled(bool $Enabled): self
  {
    $this->Enabled = $Enabled;

    return $this;
  }

  public function getCreatedAt(): ?\DateTimeImmutable
  {
    return $this->CreatedAt;
  }

  public function setCreatedAt(\DateTimeImmutable $CreatedAt): self
  {
    $this->CreatedAt = $CreatedAt;

    return $this;
  }

  public function getUpdatedAt(): ?\DateTimeImmutable
  {
    return $this->UpdatedAt;
  }

  public function setUpdatedAt(\DateTimeImmutable $UpdatedAt): self
  {
    $this->UpdatedAt = $UpdatedAt;

    return $this;
  }

  public function __toString(): string
  {
    return $this->Username;
  }

  public function getRoles(): array
  {
      $roles =  $this->roles;
      $roles[] = 'ROLE_USER';

      return array_unique($roles);
  }

  public function setRoles(array $roles): self
  {
      $this->roles = $roles;

      return $this;
  }

  public function getPassword(): ?string
  {
      return $this->password;
  }

  public function setPassword(string $password): self
  {
      $this->password = $password;

      return $this;
  }

  public function getSalt()
  {
    // not needed when using the "bcrypt" algorithm in security.yaml
  }

  public function eraseCredentials()
  {
    // If you store any temporary, sensitive data on the user, clear it here
    // $this->plainPassword = null;
  }

  public function getUserIdentifier(): string
  {
    return (string)$this->Username;
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
          $clientOrder->setServeur($this);
      }

      return $this;
  }

  public function removeClientOrder(ClientOrder $clientOrder): self
  {
      if ($this->clientOrders->removeElement($clientOrder)) {
          // set the owning side to null (unless already changed)
          if ($clientOrder->getServeur() === $this) {
              $clientOrder->setServeur(null);
          }
      }

      return $this;
  }
}
