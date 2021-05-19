<?php
/**
 * Created by PhpStorm.
 * User: Mathieu
 * Date: 09/01/2018
 * Time: 09:52
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
/**
 * Class PieceJointe
 * @package AppBundle\Entity
 * @ORM\Entity()
 * @ORM\Table(name="piece_jointe")
 */
class PieceJointe
{

    /**
     * @var integer
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @var Dossier
     * @ORM\ManyToOne(targetEntity="Dossier", inversedBy="PieceJointeCollection")
     */
    private $Dossier;
    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     * @Assert\File()
     */
    private $fichier;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $oldName;
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
     * Set dossier
     *
     * @param \AppBundle\Entity\Dossier $dossier
     *
     * @return PieceJointe
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
     * Set fichier
     *
     * @param string $fichier
     *
     * @return PieceJointe
     */
    public function setFichier($fichier)
    {
        $this->fichier = $fichier;

        return $this;
    }

    /**
     * Get fichier
     *
     * @return string
     */
    public function getFichier()
    {
        return $this->fichier;
    }

    /**
     * Get oldName
     * @return string
     */
    public function getOldName()
    {
        return $this->oldName;
    }

    /**
     * Set oldName
     * @param mixed $oldName
     * @return PieceJointe
     */
    public function setOldName($oldName)
    {
        $this->oldName = $oldName;
        return $this;
    }

}
