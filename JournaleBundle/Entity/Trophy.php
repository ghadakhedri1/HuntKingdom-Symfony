<?php

namespace JournaleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trophy
 *
 * @ORM\Table(name="trophy")
 * @ORM\Entity(repositoryClass="JournaleBundle\Repository\TrophyRepository")
 */
class Trophy
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="score", type="integer")
     */
    private $score;

    /**
     * @var string
     *
     * @ORM\Column(name="niveau", type="string", length=255)
     */
    private $niveau;
    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string",length=255)

     */
    private $image;

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @ORM\ManyToOne(targetEntity="Journale")
     * ORM\JoinColumn(name="journale_id",refrencedColumnName="id")
     */
    protected $journale;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * ORM\JoinColumn(name="user_id",refrencedColumnName="id")
     */
    protected $user;

    /**
     * @return mixed
     */
    public function getCompetition()
    {
        return $this->competition;
    }

    /**
     * @param mixed $competition
     */
    public function setCompetition($competition)
    {
        $this->competition = $competition;
    }
    /**
     * @ORM\ManyToOne(targetEntity="Competition")
     * ORM\JoinColumn(name="competition_id",refrencedColumnName="id")
     */
    protected $competition;
    /**
     * @return mixed
     */
    public function getJournale()
    {
        return $this->journale;
    }

    /**
     * @param mixed $journale
     */
    public function setJournale($journale)
    {
        $this->journale = $journale;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set score
     *
     * @param integer $score
     *
     * @return Trophy
     */
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get score
     *
     * @return int
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Set niveau
     *
     * @param string $niveau
     *
     * @return Trophy
     */
    public function setNiveau($niveau)
    {
        $this->niveau = $niveau;

        return $this;
    }

    /**
     * Get niveau
     *
     * @return string
     */
    public function getNiveau()
    {
        return $this->niveau;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Trophy
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
