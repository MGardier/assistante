<?php
/**
 * Created by PhpStorm.
 * User: Mathieu
 * Date: 11/01/2018
 * Time: 14:21
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Dossier;
use AppBundle\Entity\Note;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ListController extends Controller
{
    /**
     * @Route("/", name="list_dossier",options={"expose"=true})
     */
    public function listDossierAction(){
        $repository = $this->getDoctrine()->getRepository('AppBundle:Patient');
        $patientCollection = $repository->findAll();
        $nbPatients = count($patientCollection);
        return $this->render('list/list_dossier.html.twig',array(
            'patientCollection'=>$patientCollection,
            'nbPatient'=> $nbPatients,


        ));

    }

    /**
     * @Route("/notesAjax/{id}/{date}", name="list_notes_ajax",options={"expose"=true})
     */
    public function listNotesAjax(Dossier $dossier, $date){
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
        return $this->render('ajax/noteAjax.html.twig', array('noteCollection'=> $result));
    }
}