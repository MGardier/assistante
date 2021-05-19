<?php
/**
 * Created by PhpStorm.
 * User: c00338
 * Date: 23/01/2018
 * Time: 10:21
 */

namespace AppBundle\Controller;
use AppBundle\Entity\Dossier;
use AppBundle\Entity\Note;
use AppBundle\Entity\Patient;
use AppBundle\Entity\PieceJointe;
use AppBundle\Entity\ReferentFamilial;
use AppBundle\Form\PatientType;
use AppBundle\Form\PieceJointeType;
use AppBundle\Form\ReferentFamilialType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use AppBundle\Entity\Search;
use Doctrine\Common\Collections\Collection;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\DateTimeParamConverter;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\SearchType;



use Spipu\Html2Pdf\Html2Pdf;
use Symfony\Component\HttpFoundation\Response;

class ImprimerController extends Controller
{

    /**
     * @Route("/imprimer/{id}", name="imprimer",options={"expose"=true})
     */
    public function Imprimer(Request $request, $id){

        $em = $this->getDoctrine()->getManager();
        $collab = $em->getRepository('AppBundle:Patient');

        $patient = $collab->find($id);
        $dossier = $patient->getDossier();

        $age = $this->calculAge($patient);

        return $this->render('tabImprimer.html.twig', array(
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
    /**
     * @Route("/imprimerAll/",name="imprimerAll",options={"expose"=true})
     */
    public function ImprimerAll(){

        $entityManager = $this->getDoctrine()->getManager();
        $repository = $entityManager->getRepository(Note::class);
        $noteCollection = $repository->findAll();


        return $this->render('ajax/notesAjax.html.twig', array('noteCollection'=> $noteCollection));


    }




    /**
     * @Route("/imprimerNotes/{id}/{date}", name="imprimerNotes",options={"expose"=true})
     */
    public function ImprimerNote(Dossier $dossier , $date){
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $entityManager->getRepository(Note::class);
        $queryBuilder = $entityManager->createQueryBuilder();
        $queryBuilder
            ->select('n')
            ->from(Note::class, 'n')
            ->where('n.date LIKE :date')
            ->andWhere('n.Dossier = :dossier')
            ->setParameters(array('date'=> $date.'%',
                'dossier'=>$dossier->getId()
            ));
        $query = $queryBuilder->getQuery();
        $result = $query->getResult();
//        return new Response('kbjbtrjt');
        return $this->render('ajax/notesAjax.html.twig', array('noteCollection'=> $result));

    }
}