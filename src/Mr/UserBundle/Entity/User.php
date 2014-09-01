<?php

namespace Mr\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 *
 * @ORM\Table(name="mr_user")
 * @ORM\Entity
 */
class User extends BaseUser {
    const GENDER_MALE = true;
    const GENDER_FEMALE = false;
    const GENDER_UNDEFINED = null;
    const GENDER_STR_MALE = 'm';
    const GENDER_STR_FEMALE = 'f';
    const GENDER_STR_UNDEFINED = 'null';

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @Assert\Regex("/^[A-Za-z0-9-]+$/")
     */
    protected $username;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthdate", type="datetime", nullable=true)
     */
    private $birthdate;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255, nullable=true)
     */
    private $city;

    /**
     * @var boolean
     *
     * @ORM\Column(name="gender", type="boolean", nullable=true)
     */
    private $gender;

    /**
     * @var boolean
     *
     * @ORM\Column(name="newsletter", type="boolean")
     */
    private $newsletter;

    /**
     * @var string
     *
     * @ORM\Column(name="avatar", type="string", length=255, nullable=true)
     */
    private $avatar;


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
     * Set birthdate
     *
     * @param \DateTime $birthdate
     * @return User
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**
     * Get birthdate
     *
     * @return \DateTime 
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return User
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set gender
     *
     * @param boolean $gender
     * @return User
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Set gender as string
     *
     * @param string $genderStr must be User::GENDER_STR_MALE, User::GENDER_STR_FEMALE or User::GENDER_STR_UNDEFINED.
     * @return User
     *
     * @throws \InvalidArgumentException When genderStr is not a valid expression.
     */
    public function setGenderStr($genderStr)
    {
        switch (strtolower($genderStr)) {
            case self::GENDER_STR_MALE: $this->gender = self::GENDER_MALE; break;
            case self::GENDER_STR_FEMALE: $this->gender = self::GENDER_FEMALE; break;
            case self::GENDER_STR_UNDEFINED: $this->gender = self::GENDER_UNDEFINED; break;
            default: throw new \InvalidArgumentException('genderStr must be "m", "f" or "null"');
        }
        return $this;
    }

    /**
     * Get gender
     *
     * @return boolean 
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Get gender as string
     *
     * @return string The gender (User::GENDER_STR_MALE, User::GENDER_STR_FEMALE or User::GENDER_STR_UNDEFINED)
     */
    public function getGenderStr() {
        switch ($this->gender) {
            case self::GENDER_MALE: return self::GENDER_STR_MALE; break;
            case self::GENDER_FEMALE: return self::GENDER_STR_FEMALE; break;
            case self::GENDER_UNDEFINED: return self::GENDER_STR_UNDEFINED; break;
        }
    }

    /**
     * Set newsletter
     *
     * @param boolean $newsletter
     * @return User
     */
    public function setNewsletter($newsletter)
    {
        $this->newsletter = $newsletter;

        return $this;
    }

    /**
     * Get newsletter
     *
     * @return boolean 
     */
    public function getNewsletter()
    {
        return $this->newsletter;
    }

    /**
     * @return string
     */
    public function getAvatar() {
        return $this->avatar;
    }

    /**
     * @param string $avatar
     * @return User
     */
    public function setAvatar($avatar) {
        $this->avatar = $avatar;
        return $this;
    }
}
