<?php
/**
 * Created by PhpStorm.
 * User: Mathieu
 * Date: 23/01/2018
 * Time: 11:59
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Note
 * @package AppBundle\Entity
 * @ORM\Entity()
 * @ORM\Table(name="Note")
 *
 */
class Note
{
    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @var string
     * @ORM\Column(type="text")
     */
    private $contenu;
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @var Dossier $Dossier
     * @ORM\ManyToOne(targetEntity="Dossier", inversedBy="noteCollection", cascade={"persist"})
     */
    private $Dossier;
    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $auteur;
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
     * Set contenu
     *
     * @param string $contenu
     *
     * @return Note
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get contenu
     *
     * @return string
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Note
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set dossier
     *
     * @param \AppBundle\Entity\Dossier $dossier
     *
     * @return Note
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
     * Set dossierId
     *
     * @param integer $dossierId
     *
     * @return Note
     */
    public function setDossierId($dossierId)
    {
        $this->dossier_id = $dossierId;

        return $this;
    }

    /**
     * Get dossierId
     *
     * @return integer
     */
    public function getDossierId()
    {
        return $this->dossier_id;
    }

    /**
     * Set auteur
     *
     * @param string $auteur
     *
     * @return Note
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
