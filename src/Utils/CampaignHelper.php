<?php

// src/App/Utils/CampaignHelper.php

namespace App\Utils;

use Psr\Log\LoggerInterface;
use Doctrine\ORM\EntityManager;
use DateTime;
use Monolog\Logger;
use App\Entity\Campaign;
use App\Entity\User;

class CampaignHelper
{

  protected $em;
  protected $logger;

  public function __construct(EntityManager $em, LoggerInterface $logger)
  {
      $this->em = $em;
      $this->logger = $logger;
  }

  /**
  *
  * campaignPermissionsCheck takes the campaign that was requested and verifies user has access to it
  *
  * Access is verified by looking at the CampaignUser entity and verifying a record exists
  * for that campaign and user combination
  *
  * @param Campaign $campaign
  *
  * @return boolean
  *
  */
  public function campaignPermissionsCheck(User $user, Campaign $campaign){
    //CODE TO PROTECT CONTROLLER FROM USERS WHO ARE NOT IN CAMPAIGNUSER TABLE
    //TODO: ADD CODE TO ALLOW ADMINS TO ACCESS
    $query = $this->em->createQuery('SELECT IDENTITY(cu.campaign) FROM App:CampaignUser cu where cu.user=?1');
    $query->setParameter(1, $user);
    $results = array_map('current', $query->getScalarResult());
    if(!in_array($campaign->getId(), $results)){
      return false;
    }
    return true;
  }

  /**
  *
  * campaignCheck takes a campaignUrl and verifies that a campaign exists
  *
  * @param String $campaignUrl
  *
  * @return boolean
  *
  */
  public function campaignCheck($campaignUrl){
    //CODE TO CHECK TO SEE IF CAMPAIGN EXISTS
    $campaign = $this->em->getRepository('App:Campaign')->findOneByUrl($campaignUrl);
    if(is_null($campaign)){
      return false;
    }
    return true;
  }

}
