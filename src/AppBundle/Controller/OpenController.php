<?php
/**
 * Created by PhpStorm.
 * User: Mathieu
 * Date: 11/01/2018
 * Time: 15:43
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Patient;
use AppBundle\Entity\Dossier;
use AppBundle\Entity\PieceJointe;
use AppBundle\Entity\ReferentFamilial;
use AppBundle\Form\PatientType;
use AppBundle\Form\PieceJointeType;
use AppBundle\Form\ReferentFamilialType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

class OpenController extends Controller
{
    /**
     * @Route("open/dossier/{id}", name="open_dossier",options={"expose"=true})
     */
    public function openDossierAction($id)
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Patient');
        /**
         * @var Patient $patient
         */
        $patient = $repository->find($id);
        /**
         * @var Dossier $dossier
         */
        $dossier = $patient->getDossier();
        $PieceJointeCollection = $dossier->getPieceJointeCollection();
        $age = $this->calculAge($patient);

        return $this->render('print/print_dossier.html.twig', array(
            'patient' => $patient,
            'dossier' => $dossier,
            'age' => $age,
        ));
    }

    public function calculAge(Patient $patient)
    {
        $dateInterval = $patient->getDateNaissance()->diff(new \DateTime('now'));
        return $dateInterval->y;
    }
}
