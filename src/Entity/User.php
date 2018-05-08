<?php
/**
 * Created by PhpStorm.
 * User: jumu
 * Date: 02.03.18
 * Time: 17:37
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Insurance", mappedBy="user", orphanRemoval=true)
     */
    private $insurances;

    public function __construct()
    {
        parent::__construct();
        $this->insurances = new ArrayCollection();
        // your own logic
    }

    /**
     * @return Collection|Insurance[]
     */
    public function getInsurances(): Collection
    {
        return $this->insurances;
    }

    public function addInsurance(Insurance $insurance): self
    {
        if (!$this->insurances->contains($insurance)) {
            $this->insurances[] = $insurance;
            $insurance->setUser($this);
        }

        return $this;
    }

    public function removeInsurance(Insurance $insurance): self
    {
        if ($this->insurances->contains($insurance)) {
            $this->insurances->removeElement($insurance);
            // set the owning side to null (unless already changed)
            if ($insurance->getUser() === $this) {
                $insurance->setUser(null);
            }
        }

        return $this;
    }
}