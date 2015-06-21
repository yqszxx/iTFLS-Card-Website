<?php

namespace iTFLS\Card\ApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use iTFLS\Card\ApiBundle\Entity\Card;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\Routing\Annotation\Route;

class CardsController extends FOSRestController implements ClassResourceInterface
{
    /**
     * Collection get action
     * @var Request $request
     * @return array
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Get all cards.",
     *  parameters={
     *      {"name"="limit", "dataType"="integer", "required"=false, "description"="Fetch limit."}
     *  }
     * )
     */
    public function cgetAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $limit = $request->get('limit', null);

        $allCards = $em->getRepository('iTFLSCardApiBundle:Card')->findBy(array(),array(),$limit);

        return $allCards;
    }

    /**
     * Get action
     * @var integer $id Id of the entity
     * @return array
     *
     * @ApiDoc(
     *  description="Get a card by SN.",

     * )
     *     *  filters={
     *      {"name"="a-filter", "dataType"="integer"},
     *      {"name"="another-filter", "dataType"="string", "pattern"="(foo|bar) ASC|DESC"}
     *  }
     */
    public function getAction($cardSN)
    {
        $em = $this->getDoctrine()->getManager();

        $card = $em->getRepository('iTFLSCardApiBundle:Card')->findOneBy(array('cardSN'=>$cardSN));

        if (!$card) {
            throw $this->createNotFoundException('Unable to find card entity');
        }
        return $card;
    }
}
