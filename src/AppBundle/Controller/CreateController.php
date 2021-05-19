<?php
/**
 * Created by PhpStorm.
 * User: Mathieu
 * Date: 08/01/2018
 * Time: 16:12
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Chambre;
use AppBundle\Entity\Dossier;
use AppBundle\Entity\Note;
use AppBundle\Entity\Patient;
use AppBundle\Entity\PieceJointe;
use AppBundle\Entity\ReferentFamilial;
use AppBundle\Form\ChambreType;
use AppBundle\Form\DossierType;
use AppBundle\Form\NoteType;
use AppBundle\Form\PatientType;
use AppBundle\Form\PieceJointeType;
use AppBundle\Form\ReferentFamilialType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

class CreateController extends Controller
{
    /**
     * @Route("/creer", name="creer",options={"expose"=true})
     */
    public function createPersonneAction(Request $request)
    {

        $dossier = new Dossier();
        $dossier->setDateCreation(new \DateTime('now'));
        $patient = new Patient();
        $form = $this->createForm(PatientType::class, $patient);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $dossier->setAuteur($this->getUser());
            $patient = $form->getData();
            $patient->setDossier($dossier);
            $em = $this->getDoctrine()->getManager();
            $em->persist($dossier);
            $em->flush();
            $em->persist($patient);
            $em->flush();
            return $this->redirectToRoute('chambre', array(
                'id' => $patient->getId(),
            ));
        }
        return $this->render('creer.html.twig', array('form' => $form->createView())
        );
    }

    /**
     * @Route("chambre/{id}", name="chambre",options={"expose"=true})
     */
    public function createChambreAction(Request $request, $id)
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Patient');
        /**
         * @var Patient $patient
         */
        $patient = $repository->find($id);
        $chambre = new Chambre();
        $form = $this->createForm(ChambreType::class, $chambre);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            /**
             * @var object ReferentFamilial $referentFamilial
             */
            $chambre = $form->getData();
            $patient->addChambreCollection($chambre);
            $em = $this->getDoctrine()->getManager();
            $chambre->setPatient($patient);
            $em->persist($chambre);
            $em->flush();
            $em->persist($patient);
            $em->flush();
            return $this->redirectToRoute('ref', array(
                'id' => $patient->getId(),
            ));
        }
        return $this->render('creerChambre.html.twig', array('id' => $patient->getId(),
            'form' => $form->createView()));
    }


    /**
     * @Route("/ref/{id}", name="ref",options={"expose"=true})
     */
    public function createReferentFamilialAction(Request $request, $id)
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Patient');
        /**
         * @var Patient $patient
         */
        $patient = $repository->find($id);
        $referentFamilial = new ReferentFamilial();
        $form = $this->createForm(ReferentFamilialType::class, $referentFamilial);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            /**
             * @var object ReferentFamilial $referentFamilial
             */
            $referentFamilial = $form->getData();
            $patient->addReferentFamilialCollection($referentFamilial);
            /**
             * @var Dossier
             */
            $em = $this->getDoctrine()->getManager();
            $referentFamilial->setPatient($patient);
            $em->persist($referentFamilial);
            $em->flush();
            $em->persist($patient);
            $em->flush();
        }
        return $this->render('creerRef.html.twig', array(
            'patient' => $patient,
            'form' => $form->createView(),
            'referentCollection' => $patient->getReferentFamilialCollection()
        ));
    }

    /**
     * @Route("/fichier/{id}", name="fichier",options={"expose"=true})
     *
     */
    public function createFichierAction(Request $request, $id)
    {
        $fichier = new PieceJointe();
        $form = $this->createForm(PieceJointeType::class, $fichier);
        $form->handleRequest($request);

        $repository = $this->getDoctrine()->getRepository('AppBundle:Patient');
        /**
         * @var Patient
         */
        $patient = $repository->find($id);
        /**
         * @var Dossier
         */
        $dossier = $patient->getDossier();
        if ($form->isSubmitted()) {
            /** @var UploadedFile $file */
            $file = $fichier->getFichier();
            $fichier->setOldName($file->getClientOriginalName());
            $id = md5(uniqid());
            $fileName=  $id.'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('file_directory'),
                $fileName
            );
            $fichier->setFichier($id.".encrypt");
            $dossier->addPieceJointeCollection($fichier);
            $patient->setDossier($dossier);
            $em = $this->getDoctrine()->getManager();
            $fichier->setDossier($dossier);
            $path = "P:\polesocial\\assistante\web\uploads\\files\user\\".$fileName;
            $newName = $id;
            $this->cryptFile($path, $newName);
            unlink($path);
            /**
             * Stockage en BDD
             */
            $em->persist($fichier);
            $em->flush();
            $em->persist($dossier);
            $em->flush();
            $em->persist($patient);
            $em->flush();
            $em->persist($dossier);
            $em->flush();
        }

        $fileCollection = $dossier->getPieceJointeCollection();
        return $this->render('createFile.html.twig', array(
            'form' => $form->createView(),
            'fileCollection' => $fileCollection,
            'patient' => $patient
        ));
    }

    /**
     * @Route("create/note/{id}", name="create_note",options={"expose"=true})
     */
    public function createNoteAction(Request $request, Dossier $dossier)
    {
        $note = new Note();
        $form = $this->createForm(NoteType::class, $note);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $note->setAuteur($this->getUser());
            $em = $this->getDoctrine()->getManager();
            $dossier->addNoteCollection($note);
            $note->setDate(new \DateTime('now'));
            $note->setDossier($dossier);
            $em->persist($dossier);
            $em->persist($note);
            $em->flush();
            return $this->redirectToRoute('open_dossier', array(
                'id' => $dossier->getPatient()->getId(),
            ));
        }
        return $this->render('create_note.html.twig', array(
            'form' => $form->createView(),
            'dossier' => $dossier
        ));
    }
    /**
     * @param $pathFile string Chemin qui pointe le fichier à crypter; e.g ("D:\wamp64\www\usine_a_gaz\\test.pdf")
     * @param $newName string Nouveau nom unique générer dans la route; e.g ("azefzvgrvrgezfds")
     */
    public function cryptFile($pathFile, $newName)
    {
        /**
         * Initialisation des variables
         */
        $cipher = 'AES-256-CBC';
        $key = hex2bin('5ae1b8a17bad4da4fdac796f64c16ecd');
        $iv = "1234567812345678";
        /**
         * Récupération et cryptage des données de test.pdf
         */
        $handle = fopen($pathFile, 'r');
        $contents = fread($handle, filesize($pathFile));
        fclose($handle);
        $dataCrypted = openssl_encrypt($contents, $cipher, $key, 0, $iv);
        $handle = fopen("P:\polesocial\\assistante\web\uploads\\files\user\\".$newName . ".encrypt", 'w');
        fwrite($handle, $dataCrypted);
        fclose($handle);
    }

    /**
     * @param $pathFileCrypted string Chemin du fichier crypté; e.g("D:\wamp64\www\usine_a_gaz\\test.encrypt")
     * @param $oldName string Nom de lancien fichier avec le type mime; e.g("titi.pdf")
     */
    public function decryptFile($pathFileCrypted, $oldName){
        /**
         * Initialisation des variables
         */
        $cipher = 'AES-256-CBC';
        $key = hex2bin('5ae1b8a17bad4da4fdac796f64c16ecd');
        $iv = "1234567812345678";
        /**
         * Récupération et décryptage des données de test.pdf
         */
        $handle = fopen($pathFileCrypted, 'r');
        $dataCrypted = fread($handle, filesize($pathFileCrypted));
        fclose($handle);
        $dateEncrypted = openssl_decrypt($dataCrypted, $cipher, $key, 0, $iv);
        $handle = fopen($oldName, 'w');
        fwrite($handle, $dateEncrypted);
        fclose($handle);

    }

    /**
     * @param $path string Chemin du fichier crypté; e.g("D:\wamp64\www\usine_a_gaz\\test.encrypt"
     * @param $oldName string Nom de l'ancien fichier avec le type mime; e.g("titi.pdf")
     */
    public function printCryptedFile($path,$oldName){
        /**
         * Initialisation des variables
         */
        $this->decryptFile($path, $oldName);
        if (file_exists($oldName)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($oldName).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($oldName));
            readfile($oldName);
            /**
             * Supprime le fichier $file
             */
            unlink($oldName);
            exit;
        }
    }
}