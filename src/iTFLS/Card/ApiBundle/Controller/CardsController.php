<?php

namespace iTFLS\Card\ApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Util\Codes;
use iTFLS\Card\ApiBundle\Form\Type\CardType;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use iTFLS\Card\ApiBundle\Entity\Card;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Routing\ClassResourceInterface;

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
     * Get a card by SN
     * @var integer $id Id of the entity
     * @return array
     *
     * @ApiDoc(
     *  description="Get a card by SN.",
     * )
     */
    public function getAction($sn)
    {
        $em = $this->getDoctrine()->getManager();

        $card = $em->getRepository('iTFLSCardApiBundle:Card')->findOneBy(array('sn' => $sn));

        if (!$card) {
            throw $this->createNotFoundException('No cards found.');
        }
        return $card;
    }

    /**
     * New a card
     * @param Request $request
     * @return array
     * @internal param int $id Id of the entity
     */
    public function postAction(Request $request)
    {
        $card = new Card();
        $form = $this->createForm(new CardType(), $card);
        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($card);
            $em->flush();

            return $this->redirectView(
                $this->generateUrl(
                    'get_cards',
                    array('sn' => $card->getSn())
                ),
                Codes::HTTP_CREATED
            );
        }

        return array(
            'form' => $form,
        );
    }

}
