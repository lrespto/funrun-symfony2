<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Grade;
use AppBundle\Utils\CSVHelper;
use AppBundle\Utils\CampaignHelper;
use AppBundle\Utils\QueryHelper;
use \DateTime;
use \DateTimeZone;


/**
 * Grade controller.
 *
 * @Route("/{campaignUrl}/grades")
 */
class GradeController extends Controller
{
    /**
     * Lists all Grade entities.
     *
     * @Route("/", name="grade_index")
     * @Method("GET")
     */
    public function indexAction($campaignUrl)
    {
        $entity = 'Grade';
        $em = $this->getDoctrine()->getManager();
        $logger = $this->get('logger');
        $limit = 3;

        $campaign = $em->getRepository('AppBundle:Campaign')->findOneByUrl($campaignUrl);

        $queryHelper = new QueryHelper($em, $logger);

        return $this->render('campaign/grade.index.html.twig', array(
            'grades' => $queryHelper->getGradeRanks(array('campaign' => $campaign, 'limit'=> 0)),
            'entity' => $entity,
            'campaign' => $em->getRepository('AppBundle:Campaign')->findOneByUrl($campaignUrl),
        ));
    }


    /**
     * Finds and displays a Grade entity.
     *
     * @Route("/show/{id}", name="grade_show")
     * @Method("GET")
     */
    public function showAction(Grade $grade, $campaignUrl)
    {
        $entity = 'Grade';
        $em = $this->getDoctrine()->getManager();

        return $this->render('campaign/grade.show.html.twig', array(
            'grade' => $grade,
            'entity' => $entity,
            'campaign' => $em->getRepository('AppBundle:Campaign')->findOneByUrl($campaignUrl),
        ));
    }



    private function clean($string)
    {
        $string = str_replace(' ', '_', $string); // Replaces all spaces with underscores.
   $string = preg_replace('/[^A-Za-z0-9\_]/', '', $string); // Removes special chars.
   return strtolower($string);
    }
}
