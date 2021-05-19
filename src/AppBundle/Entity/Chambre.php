<?php
/**
 * Created by PhpStorm.
 * User: Mathieu
 * Date: 12/01/2018
 * Time: 15:08
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Chambre
 * @package AppBundle\Entity
 * @ORM\Entity()
 * @ORM\Table(name="Chambre")
 */
class Chambre
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
    private $service;
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $numero;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $dateEntrer;
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $dateSortie;

    /**
     * @var object Patient
     * @ORM\ManyToOne(targetEntity="Patient", inversedBy="chambreCollection")
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
     * Set dateEntrer
     *
     * @param \DateTime $dateEntrer
     *
     * @return Chambre
     */
    public function setDateEntrer($dateEntrer)
    {
        $this->dateEntrer = $dateEntrer;

        return $this;
    }

    /**
     * Get dateEntrer
     *
     * @return \DateTime
     */
    public function getDateEntrer()
    {
        return $this->dateEntrer;
    }

    /**
     * Set dateSortie
     *
     * @param \DateTime $dateSortie
     *
     * @return Chambre
     */
    public function setDateSortie($dateSortie)
    {
        $this->dateSortie = $dateSortie;

        return $this;
    }

    /**
     * Get dateSortie
     *
     * @return \DateTime
     */
    public function getDateSortie()
    {
        return $this->dateSortie;
    }

    /**
     * Set patient
     *
     * @param \AppBundle\Entity\Patient $patient
     *
     * @return Chambre
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
     * Set numero
     *
     * @param string $numero
     *
     * @return Chambre
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return string
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set service
     *
     * @param string $service
     *
     * @return Chambre
     */
    public function setService($service)
    {
        $this->service = $service;

        return $this;
    }

    /**
     * Get service
     *
     * @return string
     */
    public function getService()
    {
        return $this->service;
    }
}
