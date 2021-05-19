<?php
/**
 * Created by PhpStorm.
 * User: Mathieu
 * Date: 16/01/2018
 * Time: 08:56
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Dossier;
use AppBundle\Entity\Chambre;
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
use Symfony\Component\HttpFoundation\Request;
class DeleteController extends Controller
{
    /**
     * @Route("delete/dossier/{id}", name="delete_dossier",options={"expose"=true})
     */
    public function deleteDossierAction(Dossier $dossier){
        $em = $this->getDoctrine()->getManager();
        $em->remove($dossier);
        $em->flush();
        return $this->redirectToRoute('list_dossier');
    }  /**
     * @Route("delete/referent/{id}", name="deleteRef",options={"expose"=true})
     */
    public function deleteReferent(ReferentFamilial $referentFamilial){
        $em = $this->getDoctrine()->getManager();
        $em->remove($referentFamilial);
        $em->flush();
        return $this->redirectToRoute('list_dossier');
    }
    /**
     * @Route("delete/chambre/{id}", name="delete_chambre",options={"expose"=true})
     */
    public function deleteChambreAction(Chambre $chambre){
        $em = $this->getDoctrine()->getManager();
        $em->remove($chambre);
        $em->flush();
        return $this->redirectToRoute('open_dossier', array(
            'id' => $chambre->getPatient()->getId(),
        ));
    }
    /**
     * @Route("delete/pieceJointe/{id}", name="delete_PieceJointe",options={"expose"=true})
     */
    public function deletePieceJointeAction(PieceJointe $pieceJointe){
        $em = $this->getDoctrine()->getManager();
        $em->remove($pieceJointe);
        $em->flush();
        $fichier = 'web/uploads/files/user/'.$pieceJointe->getFichier();

        if( file_exists ( $fichier))
            if(unlink( $fichier )){

                return $this->redirectToRoute('open_dossier', array(
                    'id' => $pieceJointe->getDossier()->getPatient()->getId(),  ));
            }
                return $this->redirectToRoute('open_dossier', array(
                    'id' => $pieceJointe->getDossier()->getPatient()->getId(),  ));
    }
    /**
     * @Route("delete/note/{id}", name="delete_note",options={"expose"=true})
     */
    public function deleteNoteAction(Note $note){
        $em = $this->getDoctrine()->getManager();
        $em->remove($note);
        $em->flush();
        return $this->redirectToRoute('open_dossier', array(
            'id' => $note->getDossier()->getPatient()->getId(),
        ));
    }
}