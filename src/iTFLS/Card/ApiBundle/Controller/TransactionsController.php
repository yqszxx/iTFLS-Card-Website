<?php

namespace iTFLS\Card\ApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Util\Codes;
use iTFLS\Card\ApiBundle\Entity\Transaction;
use iTFLS\Card\ApiBundle\Form\Type\TransactionType;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Routing\ClassResourceInterface;

class TransactionsController extends FOSRestController implements ClassResourceInterface
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

        $allTransactions = $em->getRepository('iTFLSCardApiBundle:Transaction')->findBy(array(), array(), $limit);

        return $allTransactions;
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
    public function getAction($transactionNumber)
    {
        $em = $this->getDoctrine()->getManager();

        $transaction = $em->getRepository('iTFLSCardApiBundle:Transaction')->findOneBy(array('number' => $transactionNumber));

        if (!$transaction) {
            throw $this->createNotFoundException('No transactions found.');
        }
        return $transaction;
    }

    /**
     * New a card
     * @param Request $request
     * @return array
     * @internal param int $id Id of the entity
     */
    public function postAction(Request $request)
    {
        $transaction = new Transaction();
        $form = $this->createForm(new TransactionType(), $transaction);
        $form->submit($request);

        if ($form->isValid()) {
            $transactionNumber = $this->generateTransactionNumber();
            $transaction
                ->setTime($transactionNumber['dateTime'])
                ->setNumber($transactionNumber['transactionNumber']);
            $form->getData()['card_sn'];
            $em = $this->getDoctrine()->getManager();
            $em->persist($transaction);
            $em->flush();

            $view = $this->view()->create(
                array(
                    'no' => $transaction->getNumber(),
                    'sn' => ''
                ),
                Codes::HTTP_CREATED
            );
            return $view;
        }

        return array(
            'form' => $form,
        );
    }

    protected function generateTransactionNumber()
    {
        $dateTime = new \DateTime;
        $aRandomNumber = rand(100, 999);
        $timestamp = strval($dateTime->getTimestamp() * $aRandomNumber);
        $lenOfTimestamp = strlen($timestamp);

        $transactionNumber =
            (
            $lenOfTimestamp < 13 ?
                rand(pow(10, (12 - $lenOfTimestamp)), (pow(10, (13 - $lenOfTimestamp)) - 1)) : null
            ) .
            $timestamp . //12 digits
            $aRandomNumber //15 digits
        ;

        $checksum = 0;
        for ($i = 0; $i <= 15; $i++) {
            global $checksum;
            $checksum += intval(substr($transactionNumber, $i, 1));
        }
        $checksum = $checksum % 10;
        $transactionNumber .= $checksum; //16 digits

        return array(
            'transactionNumber' => $transactionNumber,
            'dateTime' => $dateTime
        );
    }
}
