<?php

namespace App\Entity;

use App\Repository\PortfolioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use RuntimeException;
use Twig\Error\RuntimeError;

#[ORM\Entity(repositoryClass: PortfolioRepository::class)]
class Portfolio
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'portfolios')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column]
    private ?float $balance = null;

    /**
     * @var Collection<int, Depositary>
     */
    #[ORM\OneToMany(targetEntity: Depositary::class, mappedBy: 'portfolio')]
    private Collection $depositaries;

    public function __construct()
    {
        $this->depositaries = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getBalance(): ?float
    {
        return $this->balance;
    }

    public function setBalance(float $balance): static
    {
        $this->balance = $balance;

        return $this;
    }


    public function AddBalance(float $sum): static
    {
        assert($sum > 0);
        $this-> balance += $sum;

        return $this;
    }

    public function subBalance(float $sum): static
    {
        $this->balance -= $sum;
        return $this;
    }





    /**
     * @return Collection<int, Depositary>
     */
    public function getDepositaries(): Collection
    {
        return $this->depositaries;
    }

    public function addDepositaryQuantityByStock(Stock $stock, int $quantity): static
    {
       $depositary = $this->getDepositaries()->filter(function (Depositary $depositary) use ($stock){
            return $depositary->getStock()->getId() === $stock?->getId();
         })->first();

        if(!$depositary){
            $depositary = (new Depositary())
                ->setStock($stock)
                ->setPortfolio($this)
            ;

            $this->depositaries->add($depositary);
        }
        $depositary->addQuantity($quantity);

        return $this;
    }

    public function subDepositaryQuantityByStockId(Stock $stock, int $quantity): static
    {
        $depositary = $this->getDepositaries()->filter(function (Depositary $depositary) use ($stock){
            return $depositary->getStock()->getId() === $stock?->getId();
         })->first();

         if ($depositary === null){
            throw new RuntimeException('Depositary not found for sub quantity');
         }

         if ($depositary->getQuantity()- $quantity = 0){
            $this->removeDepositary($depositary);
         }else{
            $depositary->subQuantity($quantity);
         }

         return $this;
    }








    public function addDepositary(Depositary $depositary): static
    {
        if (!$this->depositaries->contains($depositary)) {
            $this->depositaries->add($depositary);
            $depositary->setPortfolio($this);
        }

        return $this;
    }

   public function removeDepositary(Depositary $depositary): static
   {
       if ($this->depositaries->removeElement($depositary)) {
           // set the owning side to null (unless already changed)
           if ($depositary->getPortfolio() === $this) {
               $depositary->setPortfolio(null);
           }
       }

       return $this;
   }
}