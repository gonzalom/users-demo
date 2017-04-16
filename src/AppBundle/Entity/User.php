<?php

namespace AppBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="`users`")
 * @@ORM\UniqueEntity(fields="email", message="Email is already in use")
 * @ORM\HasLifecycleCallbacks
 */
class User extends BaseUser
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(type="integer", name="user_id", options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="name", length=255)
     * @Assert\NotNull(message = "Name is missing", groups={"Registration", "Profile"})
     * @Assert\NotBlank(message="Please enter your name.", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=3,
     *     max=255,
     *     minMessage="The name is too short.",
     *     maxMessage="The name is too long.",
     *     groups={"Registration", "Profile"}
     * )
     */
    protected $name;

    /**
     * @var integer
     *
     * @ORM\Column(type="smallint", name="age", options={"unsigned":true}, nullable=false)
     * @Assert\NotNull(message = "Age is missing", groups={"Registration", "Profile"})
     * @Assert\Range(min=1, max=150, groups={"Registration", "Profile"})
     */
    protected $age;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="job_title", length=255, nullable=false)
     * @Assert\NotNull(message = "Job title is missing", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=3,
     *     max=255,
     *     minMessage="The name is too short.",
     *     maxMessage="The name is too long.",
     *     groups={"Registration", "Profile"}
     * )
     */
    protected $jobTitle;

    /**
     * Row adding date in format ISO-8601 YYYY-MM-DDThh:mm:ss±hhmm
     *
     * @var DateTime
     *
     * @ORM\Column(type="datetime", name="inserted_on", nullable=false)
     */
    protected $createdAt;

    /**
     * Row adding date in format ISO-8601 YYYY-MM-DDThh:mm:ss±hhmm
     *
     * @var DateTime
     *
     * @ORM\Column(type="datetime", name="last_updated", nullable=true)
     */
    protected $updatedAt;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", name="version", options={"unsigned":true}, nullable=false)
     * @ORM\Version
     */
    protected $version;

    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * {@inheritdoc}
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getJobTitle()
    {
        return $this->jobTitle;
    }

    /**
     * {@inheritdoc}
     */
    public function setJobTitle($jobTitle)
    {
        $this->jobTitle = $jobTitle;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * {@inheritdoc}
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * {@inheritdoc}
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @ORM\PrePersist
     * @link http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/events.html#lifecycle-callbacks
     */
    public function beforePersist()
    {
        $this->createdAt = new DateTime();
    }

    /**
     * @ORM\PreUpdate
     * @link http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/events.html#lifecycle-callbacks
     */
    public function beforeUpdate()
    {
        $this->updatedAt = new DateTime();
    }
}
