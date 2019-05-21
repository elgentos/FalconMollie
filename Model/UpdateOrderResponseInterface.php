<?php
declare(strict_types=1);

namespace Elgentos\FalconMollie\Model;

use Deity\QuoteApi\Api\Data\OrderResponseInterface;

/**
 * Interface UpdateOrderResponseInterface
 *
 * @package Elgentos\FalconMollie\Model
 */
interface UpdateOrderResponseInterface
{

    /**
     * Update OrderResponseObject with Mollie specific data
     *
     * @param int $orderId
     * @param OrderResponseInterface $orderResponse
     */
    public function execute(int $orderId, OrderResponseInterface $orderResponse): void;
}
