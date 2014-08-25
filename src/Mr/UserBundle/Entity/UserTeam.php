<?php

namespace Mr\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserTeam
 *
 * @ORM\Table(name="mr_userteam")
 * @ORM\Entity(repositoryClass="Mr\UserBundle\Entity\UserTeamRepository")
 */
class UserTeam
{
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Mr\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @var Team
     *
     * @ORM\ManyToOne(targetEntity="Mr\UserBundle\Entity\Team", inversedBy="userteam")
     * @ORM\JoinColumn(nullable=false)
     */
    private $team;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return UserTeam
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return UserTeam
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return User
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * @param User $user
     * @return UserTeam
     */
    public function setUser($user) {
        $this->user = $user;
        return $this;
    }

    /**
     * @return Team
     */
    public function getTeam() {
        return $this->team;
    }

    /**
     * @param Team $team
     * @return UserTeam
     */
    public function setTeam($team) {
        $this->team = $team;
        return $this;
    }
}
