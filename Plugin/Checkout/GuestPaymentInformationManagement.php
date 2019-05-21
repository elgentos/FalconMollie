<?php
declare(strict_types=1);

namespace Elgentos\FalconMollie\Plugin\Checkout;

use Elgentos\FalconMollie\Model\UpdateOrderResponseInterface;
use Deity\CheckoutApi\Api\GuestPaymentInformationManagementInterface;
use Deity\QuoteApi\Api\Data\OrderResponseInterface;
use Deity\SalesApi\Api\Data\OrderIdMaskInterface;
use Deity\SalesApi\Api\OrderIdMaskRepositoryInterface;
use Magento\Quote\Api\Data\AddressInterface;
use Magento\Quote\Api\Data\PaymentInterface;

/**
 * Class GuestPaymentInformationManagement
 *
 * @package Elgentos\FalconMollie\Plugin\Checkout
 */
class GuestPaymentInformationManagement
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
     * GuestPaymentInformationManagement constructor.
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
     * @param GuestPaymentInformationManagementInterface $subject
     * @param OrderResponseInterface $result
     * @param string $cartId
     * @param string $email
     * @param PaymentInterface $paymentMethod
     * @param AddressInterface $billingAddress
     * @return OrderResponseInterface
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterSavePaymentInformationAndPlaceOrder(
        GuestPaymentInformationManagementInterface $subject,
        OrderResponseInterface $result,
        string $cartId,
        string $email,
        PaymentInterface $paymentMethod,
        AddressInterface $billingAddress = null
    ) {
        /** @var OrderIdMaskInterface $maskedOrderIdObject */
        $maskedOrderIdObject = $this->orderIdMaskRepository->getByMaskedOrderId((string)$result->getOrderId());
        $this->updateOrderResponse->execute((int)$maskedOrderIdObject->getOrderId(), $result);

        return $result;
    }
}
