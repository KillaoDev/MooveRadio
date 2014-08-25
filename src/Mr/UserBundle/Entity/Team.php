<?php

namespace Mr\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Team
 *
 * @ORM\Table(name="mr_team")
 * @ORM\Entity(repositoryClass="Mr\UserBundle\Entity\TeamRepository")
 */
class Team {
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="number", type="integer")
     */
    private $number;

    /**
     * @var string
     *
     * @ORM\Column(name="language", type="string", length=255)
     */
    private $language;

    /**
     * @var UserTeam[]
     * @ORM\OneToMany(targetEntity="Mr\UserBundle\Entity\UserTeam", mappedBy="team", cascade={"persist", "remove"})
     */
    private $userteam;


    public function __construct() {
        $this->userteam = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Team
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set number
     *
     * @param integer $number
     * @return Team
     */
    public function setNumber($number) {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return integer
     */
    public function getNumber() {
        return $this->number;
    }

    /**
     * Set language
     *
     * @param string $language
     * @return UserTeam
     */
    public function setLanguage($language) {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return string
     */
    public function getLanguage() {
        return $this->language;
    }

    /**
     * @return UserTeam[]
     */
    public function getUserteam() {
        return $this->userteam;
    }

    /**
     * @param UserTeam $userteam
     * @return Team
     */
    public function addUserteam($userteam) {
        $this->userteam[] = $userteam;
        $userteam->setTeam($this);
        return $this;
    }

    /**
     * @param UserTeam $userteam
     * @return Team
     */
    public function removeUserteam($userteam) {
        $this->userteam->removeElement($userteam);
        return $this;
    }
}