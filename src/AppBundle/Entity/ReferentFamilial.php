<?php

/**
 * Created by PhpStorm.
 * User: Mathieu
 * Date: 08/01/2018
 * Time: 13:31
 */

namespace AppBundle\Entity;

use AppBundle\Entity\Personne;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class ReferentFamilial
 * @package AppBundle\Entity
 * @ORM\Entity()
 */
class ReferentFamilial extends Personne
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
     * @ORM\Column(type="string", nullable=true)
     */
    private $lieu;
    /**
     * @ORM\ManyToOne(targetEntity="Patient", inversedBy="ReferentFamilialCollection")
     */
    private $Patient;

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
     * Set lieu
     *
     * @param string $lieu
     *
     * @return ReferentFamilial
     */
    public function setLieu($lieu)
    {
        $this->lieu = $lieu;

        return $this;
    }

    /**
     * Get lieu
     *
     * @return string
     */
    public function getLieu()
    {
        return $this->lieu;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return ReferentFamilial
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return ReferentFamilial
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     *
     * @return ReferentFamilial
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set fixe
     *
     * @param integer $fixe
     *
     * @return ReferentFamilial
     */
    public function setFixe($fixe)
    {
        $this->fixe = $fixe;

        return $this;
    }

    /**
     * Get fixe
     *
     * @return integer
     */
    public function getFixe()
    {
        return $this->fixe;
    }

    /**
     * Set portable
     *
     * @param integer $portable
     *
     * @return ReferentFamilial
     */
    public function setPortable($portable)
    {
        $this->portable = $portable;

        return $this;
    }

    /**
     * Get portable
     *
     * @return integer
     */
    public function getPortable()
    {
        return $this->portable;
    }

    /**
     * Set mail
     *
     * @param string $mail
     *
     * @return ReferentFamilial
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     *
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set patient
     *
     * @param \AppBundle\Entity\Patient $patient
     *
     * @return ReferentFamilial
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
}
