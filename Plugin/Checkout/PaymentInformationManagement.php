<?php
declare(strict_types=1);

namespace Elgentos\FalconMollie\Plugin\Checkout;

use Elgentos\FalconMollie\Model\UpdateOrderResponseInterface;
use Deity\CheckoutApi\Api\PaymentInformationManagementInterface;
use Deity\QuoteApi\Api\Data\OrderResponseInterface;
use Magento\Quote\Api\Data\AddressInterface;
use Magento\Quote\Api\Data\PaymentInterface;

/**
 * Class PaymentInformationManagement
 *
 * @package Elgentos\FalconMollie\Plugin\Checkout
 */
class PaymentInformationManagement
{

    /**
     * @var UpdateOrderResponseInterface
     */
    private $updateOrderResponse;

    /**
     * PaymentInformationManagement constructor.
     * @param UpdateOrderResponseInterface $updateOrderResponse
     */
    public function __construct(UpdateOrderResponseInterface $updateOrderResponse)
    {
        $this->updateOrderResponse = $updateOrderResponse;
    }

    /**
     * Update OrderResponse data
     *
     * @param PaymentInformationManagementInterface $subject
     * @param OrderResponseInterface $result
     * @param string $cartId
     * @param PaymentInterface $paymentMethod
     * @param AddressInterface $billingAddress
     * @return OrderResponseInterface
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterSavePaymentInformationAndPlaceOrder(
        PaymentInformationManagementInterface $subject,
        OrderResponseInterface $result,
        string $cartId,
        PaymentInterface $paymentMethod,
        AddressInterface $billingAddress = null
    ) {
        $this->updateOrderResponse->execute((int)$result->getOrderId(), $result);

        return $result;
    }
}
