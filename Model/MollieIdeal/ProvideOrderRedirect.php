<?php
declare(strict_types=1);

namespace Elgentos\FalconMollie\Model\MollieIdeal;

use Deity\QuoteApi\Api\Data\OrderResponseExtensionInterface;
use Elgentos\FalconMollie\Api\Data\MollieResponseInterface;
use Elgentos\FalconMollie\Api\Data\MollieResponseInterfaceFactory;
use Elgentos\FalconMollie\Model\OrderResponse\ProvideOrderRedirectInterface;
use Deity\QuoteApi\Api\Data\OrderResponseInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Payment\Helper\Data as PaymentHelper;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Model\Order;
use Mollie\Api\Exceptions\ApiException;
use Mollie\Payment\Model\Mollie;

/**
 * Class ProvideOrderRedirect
 *
 * @package Elgentos\FalconMollie\Model\OrderResponse
 */
class ProvideOrderRedirect implements ProvideOrderRedirectInterface
{
    /**
     * @var PaymentHelper
     */
    public $paymentHelper;
    protected $mollieResponseInterfaceFactory;

    /**
     * ProvideOrderRedirect constructor.
     * @param MollieResponseInterfaceFactory $mollieResponseInterfaceFactory
     * @param PaymentHelper $paymentHelper
     */
    public function __construct(
        MollieResponseInterfaceFactory $mollieResponseInterfaceFactory,
        PaymentHelper $paymentHelper
    ) {
        $this->mollieResponseInterfaceFactory = $mollieResponseInterfaceFactory;
        $this->paymentHelper = $paymentHelper;
    }

    /**
     * Process order payment info
     *
     * @param OrderInterface $order
     * @param OrderResponseInterface $orderResponse
     * @throws LocalizedException
     * @throws ApiException
     */
    public function execute(OrderInterface $order, OrderResponseInterface $orderResponse): void
    {

        $method = $order->getPayment()->getMethod();
        $methodInstance = $this->paymentHelper->getMethodInstance($method);

        if (!$methodInstance instanceof Mollie) {
            return;
        }

        /** @var Order $order */
        /** @var MollieResponseInterface $mollieResponse */
        $mollieResponse = $this->mollieResponseInterfaceFactory->create(
            [
                MollieResponseInterface::REDIRECT_URL => $methodInstance->startTransaction($order)
            ]
        );

        /** @var OrderResponseExtensionInterface $extensionAttributes */
        $extensionAttributes = $orderResponse->getExtensionAttributes();
        $extensionAttributes->setMollieData($mollieResponse);
        $orderResponse->setExtensionAttributes($extensionAttributes);
    }

}
