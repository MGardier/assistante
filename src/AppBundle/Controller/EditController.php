<?php
/**
 * Created by PhpStorm.
 * User: Mathieu
 * Date: 12/01/2018
 * Time: 13:29
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Chambre;
use AppBundle\Entity\Dossier;
use AppBundle\Entity\Note;
use AppBundle\Entity\Patient;
use AppBundle\Entity\PieceJointe;
use AppBundle\Entity\ReferentFamilial;
use AppBundle\Form\ChambreType;
use AppBundle\Form\EditPieceJointeType;
use AppBundle\Form\NoteType;
use AppBundle\Form\PatientEditType;
use AppBundle\Form\PatientType;
use AppBundle\Form\PieceJointeType;
use AppBundle\Form\ReferentFamilialType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

class EditController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("edit/dossier/patient/{id}", name="edit_dossier_patient",options={"expose"=true})
     */
    public function editDossierAction(Request $request, Patient $patient)
    {
        /**
         * @var Patient $patient
         */
        $form = $this->createForm(PatientEditType::class, $patient);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $patient = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('open_dossier', array(
                'id' => $patient->getId(),
            ));
        }
        return $this->render('edit/edit.html.twig', array('form' => $form->createView())
        );
    }

    /**
     * @Route("/edit_ref/{id}", name="editRef",options={"expose"=true})
     */
    public function editReferentFamilialAction(Request $request, ReferentFamilial $referentFamilial)
    {

        $form = $this->createForm(ReferentFamilialType::class, $referentFamilial);
        $form->handleRequest($request);
        $patient = $referentFamilial->getPatient();
        if ($form->isSubmitted()) {
            $referentFamilial = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('open_dossier', array(
                'id' => $patient->getId(),
            ));
        }
        return $this->render('edit/editRef.html.twig', array('patient' => $patient,
            'form' => $form->createView(),
            'referentCollection' => $patient->getReferentFamilialCollection()
        ));
    }
    /**
     * @Route("edit_chambre/{id}", name="editChambre",options={"expose"=true})
     */
    public  function editChambre(Request $request, Chambre $chambre){

        $form = $this->createForm(ChambreType::class, $chambre);
        $form->handleRequest($request);
        $patient = $chambre->getPatient();
        if ($form->isSubmitted()) {
            $chambre = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('open_dossier', array(
                'id' => $patient->getId(),
            ));
        }
        return $this->render('edit/editChambre.html.twig', array('patient' => $patient,
            'form' => $form->createView(),
            'chambreCollection' => $patient->getChambreCollection()
        ));
    }
    /**
     * @Route("edit_piece/{id}", name="editPiece",options={"expose"=true})
     */
    public  function editPiece(Request $request, PieceJointe $pieceJointe){

        $form = $this->createForm(EditPieceJointeType::class, $pieceJointe);
        $form->handleRequest($request);
        $dossier = $pieceJointe->getDossier();
        $patient = $dossier->getPatient();
        if ($form->isSubmitted()) {
            $pieceJointe = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('open_dossier', array(
                'id' => $patient->getId(),
            ));
        }
        return $this->render('edit/editPiecesJointes.html.twig', array('patient' => $patient,
            'form' => $form->createView(),
            'pieceJointeCollection' => $dossier->getPieceJointeCollection()
        ));
    }
    /**
     * @Route("edit_note/{id}", name="editNote",options={"expose"=true})
     */
    public  function editNoteAction(Request $request, Note $note){

        $form = $this->createForm(NoteType::class, $note);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $note = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($note);
            $em->flush();
            return $this->redirectToRoute('open_dossier', array(
                'id' => $note->getDossier()->getPatient()->getId(),
            ));
        }
        return $this->render('edit/editNote.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}