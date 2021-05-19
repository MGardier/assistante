<?php
/**
 * Created by PhpStorm.
 * User: Mathieu
 * Date: 19/01/2018
 * Time: 09:39
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Chambre;
use AppBundle\Entity\Dossier;
use AppBundle\Entity\Patient;
use AppBundle\Entity\PieceJointe;
use AppBundle\Entity\ReferentFamilial;
use AppBundle\Form\ChambreType;
use AppBundle\Form\PatientType;
use AppBundle\Form\PieceJointeType;
use AppBundle\Form\ReferentFamilialType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

class AddController extends Controller
{
     
    /**
     * @Route("add_chambre/{id}", name="add_chambre",options={"expose"=true})
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
            return $this->redirectToRoute('open_dossier', array(
                'id' => $patient->getId(),
            ));
        }
        return $this->render('add/add_chambre.html.twig', array('form'=>$form->createView()));
    }
    /**
     * @Route("/add_fichier/{id}", name="add_file",options={"expose"=true})
     *
     */
    public function createFichierAction(Request $request, $id){
        $fichier=  new PieceJointe();
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
        if ($form->isSubmitted()){
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
            return $this->redirectToRoute('open_dossier', array(
                'id' => $patient->getId(),
            ));
        }

        $fileCollection = $dossier->getPieceJointeCollection();

        return $this->render('add/add_file.html.twig', array(
            'form'=>$form->createView(),
            'fileCollection'=>$fileCollection,
            'patient'=>$patient
        ));
    }
    /**
     * @Route("/add_ref/{id}", name="add_ref",options={"expose"=true})
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
        if($form->isSubmitted()){
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
            return $this->redirectToRoute('open_dossier', array(
                'id' => $patient->getId(),
            ));
        }
        return $this->render('add/add_ref.html.twig', array('patient'=>$patient,
            'form'=>$form->createView(),
            'referentCollection'=>$patient->getReferentFamilialCollection()
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

    /**
     * @param Request $request
     * @param $id
     * @Route("decryptFile/{id}",name="decryptFile",options={"expose"=true})
     * @return Response
     */
    public function decryptFileAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager()->getRepository(PieceJointe::class);
        /**
         * @var $pieceJointe PieceJointe
         */
        $pieceJointe = $em->find($id);
        $fichierCrypte = $pieceJointe->getFichier();
        $path = "P:\polesocial\\assistante\web\uploads\\files\user\\". $fichierCrypte;
        $oldName = $pieceJointe->getOldName();
        $this->printCryptedFile($path, $oldName);
        return new Response('ok');
    }
}