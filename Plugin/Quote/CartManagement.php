<?php
declare(strict_types=1);

namespace Elgentos\FalconMollie\Plugin\Quote;

use Elgentos\FalconMollie\Model\UpdateOrderResponseInterface;
use Deity\QuoteApi\Api\CartManagementInterface;
use Deity\QuoteApi\Api\Data\OrderResponseInterface;
use Magento\Quote\Api\Data\PaymentInterface;

/**
 * Class CartManagement
 *
 * @package Elgentos\FalconMollie\Plugin\Quote
 */
class CartManagement
{

    /**
     * @var UpdateOrderResponseInterface
     */
    private $updateOrderResponse;

    /**
     * CartManagement constructor.
     * @param UpdateOrderResponseInterface $updateOrderResponse
     */
    public function __construct(UpdateOrderResponseInterface $updateOrderResponse)
    {
        $this->updateOrderResponse = $updateOrderResponse;
    }

    /**
     * Update OrderResponse data
     *
     * @param CartManagementInterface $subject
     * @param OrderResponseInterface $result
     * @param string $cartId
     * @param PaymentInterface $paymentMethod
     * @return OrderResponseInterface
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterPlaceOrder(
        CartManagementInterface $subject,
        OrderResponseInterface $result,
        string $cartId,
        PaymentInterface $paymentMethod = null
    ) {
        $this->updateOrderResponse->execute((int)$result->getOrderId(), $result);

        return $result;
    }
}
