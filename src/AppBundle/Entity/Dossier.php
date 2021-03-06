<?php

/**
 * Created by PhpStorm.
 * User: Mathieu
 * Date: 08/01/2018
 * Time: 13:32
 */
namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 * Class Dossier
 * @ORM\Entity()
 * @ORM\Table(name="Dossier")
 */
class Dossier
{
    /**
     * @var integer
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $auteur;


    /**
     * @var string
     * @ORM\Column(type="datetime")
     */
    private $dateCreation;
    /**
     * @var object Patient
     * @ORM\OneToOne(targetEntity="Patient", mappedBy="Dossier", cascade={"remove"})
     */
    private $Patient;
    /**
     * @var object PieceJointeCollection
     * @ORM\OneToMany(targetEntity="PieceJointe", mappedBy="Dossier", cascade={"remove"})
     */
    private $PieceJointeCollection;
    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="Note", mappedBy="Dossier", cascade={"persist", "refresh", "remove"})
     */
    private $noteCollection;
    /**
     * Dossier constructor.
     */
    public function __construct()
    {
        $this->PieceJointeCollection = new ArrayCollection();
        $this->noteCollection = new ArrayCollection();
    }

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
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     *
     * @return Dossier
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set patient
     *
     * @param \AppBundle\Entity\Patient $patient
     *
     * @return Dossier
     */
    public function setPatient(\AppBundle\Entity\Patient $patient = null)
    {
        $this->Patient = $patient;

        return $this;
    }

    /**
     * Get patient
     *
     * @return \AppBundle\Entity\Patient
     */
    public function getPatient()
    {
        return $this->Patient;
    }

    /**
     * Add pieceJointeCollection
     *
     * @param \AppBundle\Entity\PieceJointe $pieceJointeCollection
     *
     * @return Dossier
     */
    public function addPieceJointeCollection(\AppBundle\Entity\PieceJointe $pieceJointeCollection)
    {
        $this->PieceJointeCollection[] = $pieceJointeCollection;

        return $this;
    }

    /**
     * Remove pieceJointeCollection
     *
     * @param \AppBundle\Entity\PieceJointe $pieceJointeCollection
     */
    public function removePieceJointeCollection(\AppBundle\Entity\PieceJointe $pieceJointeCollection)
    {
        $this->PieceJointeCollection->removeElement($pieceJointeCollection);
    }

    /**
     * Get pieceJointeCollection
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPieceJointeCollection()
    {
        return $this->PieceJointeCollection;
    }

    /**
     * Add noteCollection
     *
     * @param \AppBundle\Entity\Note $noteCollection
     *
     * @return Dossier
     */
    public function addNoteCollection(\AppBundle\Entity\Note $noteCollection)
    {
        $this->noteCollection[] = $noteCollection;

        return $this;
    }

    /**
     * Remove noteCollection
     *
     * @param \AppBundle\Entity\Note $noteCollection
     */
    public function removeNoteCollection(\AppBundle\Entity\Note $noteCollection)
    {
        $this->noteCollection->removeElement($noteCollection);
    }

    /**
     * Get noteCollection
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNoteCollection()
    {
        return $this->noteCollection;
    }

    /**
     * Set auteur
     *
     * @param string $auteur
     *
     * @return Dossier
     */
    public function setAuteur($auteur)
    {
        $this->auteur = $auteur;

        return $this;
    }

    /**
     * Get auteur
     *
     * @return string
     */
    public function getAuteur()
    {
        return $this->auteur;
    }
}
