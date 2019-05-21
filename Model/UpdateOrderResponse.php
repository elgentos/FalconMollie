<?php
declare(strict_types=1);

namespace Elgentos\FalconMollie\Model;

use Elgentos\FalconMollie\Model\OrderResponse\ProvideOrderRedirectInterface;
use Deity\QuoteApi\Api\Data\OrderResponseInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Sales\Api\OrderRepositoryInterface;

/**
 * Class UpdateOrderResponse
 *
 * @package Elgentos\FalconMollie\Model
 */
class UpdateOrderResponse implements UpdateOrderResponseInterface
{

    /**
     * @var OrderRepositoryInterface
     */
    private $orderRepository;

    /**
     * @var ProvideOrderRedirectInterface[]
     */
    private $paymentMethodProcessors;

    /**
     * OrderPlaceObserver constructor.
     * @param OrderRepositoryInterface $orderRepository
     * @param ProvideOrderRedirectInterface[] $paymentMethodProcessors
     * @throws LocalizedException
     */
    public function __construct(
        OrderRepositoryInterface $orderRepository,
        array $paymentMethodProcessors = []
    ) {
        $this->orderRepository = $orderRepository;
        foreach ($paymentMethodProcessors as $paymentMethodProcessor) {
            if (!$paymentMethodProcessor instanceof ProvideOrderRedirectInterface) {
                throw new LocalizedException(
                    __('Payment method provider must implement ProvideOrderRedirectInterface')
                );
            }
        }
        $this->paymentMethodProcessors = $paymentMethodProcessors;
    }

    /**
     * Update OrderResponseObject with Mollie specific data
     *
     * @param int $orderId
     * @param OrderResponseInterface $orderResponse
     */
    public function execute(int $orderId, OrderResponseInterface $orderResponse): void
    {
        $orderObject = $this->orderRepository->get($orderId);

        foreach ($this->paymentMethodProcessors as $paymentMethodCode => $processor) {
            if ($orderObject->getPayment()->getMethod() === $paymentMethodCode) {
                $processor->execute($orderObject, $orderResponse);
            }
        }
    }
}
