<?php

/**
 * Created by PhpStorm.
 * User: Mathieu
 * Date: 08/01/2018
 * Time: 11:42
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 */
class Personne
{
    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $nom;
    /**
     * @var string
     * @ORM\Column(type="string")
     *
     */
    protected $prenom;
    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $adresse;
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $fixe;
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     *
     * numéro téléphone portable
     */
    protected $portable;
    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     * @Assert\Blank()
     */
    protected $mail;

}