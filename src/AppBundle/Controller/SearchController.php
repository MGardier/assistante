<?php
/**
 * Created by PhpStorm.
 * User: c00338
 * Date: 16/01/2018
 * Time: 14:16
 */

namespace AppBundle\Controller;
use AppBundle\Entity\Patient;
use AppBundle\Entity\Search;
use AppBundle\Form\SearchDateType;
use Doctrine\Common\Collections\Collection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\DateTimeParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\SearchType;
use Symfony\Component\HttpFoundation\Response;

class SearchController extends Controller
{

    /**
     *@Route("/searchNom/{v0}", name="searchNom",options={"expose"=true})
     */
    public function SearchNom(Request $request, $v0){




        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);
        $query = $this->getDoctrine()->getRepository('AppBundle:Patient')->findBy(array('nom'=>$v0));



        return $this->render('tabAjax.html.twig', array(
            'patientCollection'=>$query
        ));
    }





    /**
     *@Route("/search/{v0}/{v1}", name="search",options={"expose"=true})
     */
    public function SearchNomPrenom(Request $request, $v0, $v1){




        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);
        $query = $this->getDoctrine()->getRepository('AppBundle:Patient')->findBy(array('nom'=>$v0, 'prenom'=>$v1));
        return $this->render('tabAjax.html.twig', array(
            'patientCollection'=>$query
        ));
    }



    /**
     *@Route("/searchDate/{annee}/{mois}/{jour}", name="searchDate",options={"expose"=true})
     */
    public function SearchDate(Request $request, $annee, $mois, $jour){
$date = "".$annee."-".$mois."-".$jour;
        $form = $this->createForm(SearchDateType::class);
        $form->handleRequest($request);
        $entityManager = $this->getDoctrine()->getManager();
        $queryBuilder = $entityManager->createQueryBuilder();
        $queryBuilder
            ->select('n')
            ->from(Patient::class, 'n')
            ->where('n.dateNaissance LIKE :date')

            ->setParameters(array('date'=> $date.'',
                ));
        $query = $queryBuilder->getQuery();
        $result = $query->getResult();
      //dump($result);
        return $this->render('tabAjax.html.twig', array('patientCollection'=> $result));

    }
}