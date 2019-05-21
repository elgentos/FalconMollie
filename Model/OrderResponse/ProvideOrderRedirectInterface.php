<?php
declare(strict_types=1);

namespace Elgentos\FalconMollie\Model\OrderResponse;

use Deity\QuoteApi\Api\Data\OrderResponseInterface;
use Magento\Sales\Api\Data\OrderInterface;

/**
 * Interface ProvideOrderRedirectInterface
 *
 * @package Elgentos\FalconMollie\Model\OrderResponse
 */
interface ProvideOrderRedirectInterface
{

    /**
     * Process order payment info
     *
     * @param OrderInterface $order
     * @param OrderResponseInterface $orderResponse
     */
    public function execute(OrderInterface $order, OrderResponseInterface $orderResponse): void;
}
