<?php

/**
 * Created by PhpStorm.
 * User: Mathieu
 * Date: 08/01/2018
 * Time: 13:28
 */

namespace AppBundle\Entity;

use AppBundle\Entity\Personne;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * Class Patient
 * @package AppBundle\Entity
 * @ORM\Entity
 * @ORM\Table(name="Patient")
 */
class Patient extends Personne
{
    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var object \DateTime
     * Date de naissance
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Blank()
     */
    private $dateNaissance;
    /**
     * One Patient has many ReferentFamilial
     * @ORM\OneToMany(targetEntity="ReferentFamilial", mappedBy="Patient", cascade={"remove"})
     */
    private $ReferentFamilialCollection;
    /**
     * @var Dossier
     * @ORM\OneToOne(targetEntity="Dossier", inversedBy="Patient", cascade={"remove"})
     */
    private $Dossier;
    /**
     * @ORM\OneToMany(targetEntity="Chambre", mappedBy="Patient", cascade={"remove"})
     */
    private $chambreCollection;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $situationPro;
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $situationFamiliale;
    /**
     * 0 pour M, 1 pour F
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    private $genre;

    /**
     * Calcul l'âge
     * du patient
     * return integer age
     */
    public function calculAge()
    {

    }
    public function __construct()
    {
        $this->ReferentFamilialCollection = new ArrayCollection();
        $this->chambreCollection = new ArrayCollection();
    }

    /**
     * Get idPatient
     *
     * @return integer
     */
    public function getIdPatient()
    {
        return $this->idPatient;
    }

    /**
     * Set dateNaissance
     *
     * @param \DateTime $dateNaissance
     *
     * @return Patient
     */
    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * Get dateNaissance
     *
     * @return \DateTime
     */
    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Patient
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
     * @return Patient
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
     * @return Patient
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
     * @return Patient
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
     * @return Patient
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
     * @return Patient
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Add referentFamilialCollection
     *
     * @param \AppBundle\Entity\ReferentFamilial $referentFamilialCollection
     *
     * @return Patient
     */
    public function addReferentFamilialCollection(\AppBundle\Entity\ReferentFamilial $referentFamilialCollection)
    {
        $this->ReferentFamilialCollection[] = $referentFamilialCollection;

        return $this;
    }

    /**
     * Remove referentFamilialCollection
     *
     * @param \AppBundle\Entity\ReferentFamilial $referentFamilialCollection
     */
    public function removeReferentFamilialCollection(\AppBundle\Entity\ReferentFamilial $referentFamilialCollection)
    {
        $this->ReferentFamilialCollection->removeElement($referentFamilialCollection);
    }

    /**
     * Get referentFamilialCollection
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getReferentFamilialCollection()
    {
        return $this->ReferentFamilialCollection;
    }

    /**
     * Set dossier
     *
     * @param \AppBundle\Entity\Dossier $dossier
     *
     * @return Patient
     */
    public function setDossier(\AppBundle\Entity\Dossier $dossier = null)
    {
        $this->Dossier = $dossier;

        return $this;
    }

    /**
     * Get dossier
     *
     * @return \AppBundle\Entity\Dossier
     */
    public function getDossier()
    {
        return $this->Dossier;
    }

    /**
     * Add chambreCollection
     *
     * @param \AppBundle\Entity\Chambre $chambreCollection
     *
     * @return Patient
     */
    public function addChambreCollection(\AppBundle\Entity\Chambre $chambreCollection)
    {
        $this->chambreCollection[] = $chambreCollection;

        return $this;
    }

    /**
     * Remove chambreCollection
     *
     * @param \AppBundle\Entity\Chambre $chambreCollection
     */
    public function removeChambreCollection(\AppBundle\Entity\Chambre $chambreCollection)
    {
        $this->chambreCollection->removeElement($chambreCollection);
    }

    /**
     * Get chambreCollection
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChambreCollection()
    {
        return $this->chambreCollection;
    }


    /**
     * Set situationPro
     *
     * @param string $situationPro
     *
     * @return Patient
     */
    public function setSituationPro($situationPro)
    {
        $this->situationPro = $situationPro;

        return $this;
    }

    /**
     * Get situationPro
     *
     * @return string
     */
    public function getSituationPro()
    {
        return $this->situationPro;
    }

    /**
     * Set situationFamiliale
     *
     * @param string $situationFamiliale
     *
     * @return Patient
     */
    public function setSituationFamiliale($situationFamiliale)
    {
        $this->situationFamiliale = $situationFamiliale;

        return $this;
    }

    /**
     * Get situationFamiliale
     *
     * @return string
     */
    public function getSituationFamiliale()
    {
        return $this->situationFamiliale;
    }

    /**
     * Set genre
     *
     * @param boolean $genre
     *
     * @return Patient
     */
    public function setGenre($genre)
    {
        $this->genre = $genre;

        return $this;
    }

    /**
     * Get genre
     *
     * @return boolean
     */
    public function getGenre()
    {
        return $this->genre;
    }
}
