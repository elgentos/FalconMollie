<?php
declare(strict_types=1);

namespace Elgentos\FalconMollie\Plugin\Quote;

use Elgentos\FalconMollie\Model\UpdateOrderResponseInterface;
use Deity\QuoteApi\Api\Data\OrderResponseInterface;
use Deity\QuoteApi\Api\GuestCartManagementInterface;
use Deity\SalesApi\Api\Data\OrderIdMaskInterface;
use Deity\SalesApi\Api\OrderIdMaskRepositoryInterface;
use Magento\Quote\Api\Data\PaymentInterface;

/**
 * Class GuestCartManagement
 *
 * @package Elgentos\FalconMollie\Plugin\Quote
 */
class GuestCartManagement
{

    /**
     * @var UpdateOrderResponseInterface
     */
    private $updateOrderResponse;

    /**
     * @var OrderIdMaskRepositoryInterface
     */
    private $orderIdMaskRepository;

    /**
     * GuestCartManagement constructor.
     * @param UpdateOrderResponseInterface $updateOrderResponse
     * @param OrderIdMaskRepositoryInterface $orderIdMaskRepository
     */
    public function __construct(
        UpdateOrderResponseInterface $updateOrderResponse,
        OrderIdMaskRepositoryInterface $orderIdMaskRepository
    ) {
        $this->orderIdMaskRepository = $orderIdMaskRepository;
        $this->updateOrderResponse = $updateOrderResponse;
    }

    /**
     * Update OrderResponse data
     *
     * @param GuestCartManagementInterface $subject
     * @param OrderResponseInterface $result
     * @param string $cartId
     * @param PaymentInterface $paymentMethod
     * @return OrderResponseInterface
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterPlaceOrder(
        GuestCartManagementInterface $subject,
        OrderResponseInterface $result,
        string $cartId,
        PaymentInterface $paymentMethod = null
    ) {
        /** @var OrderIdMaskInterface $maskedOrderIdObject */
        $maskedOrderIdObject = $this->orderIdMaskRepository->getByMaskedOrderId((string)$result->getOrderId());
        $this->updateOrderResponse->execute((int)$maskedOrderIdObject->getOrderId(), $result);

        return $result;
    }
}
