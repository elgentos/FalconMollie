<?php
declare(strict_types=1);

namespace Elgentos\FalconMollie\Model\Data;

use Elgentos\FalconMollie\Api\Data\MollieResponseInterface;

/**
 * Class MollieResponse
 *
 * @package Elgentos\FalconMollie\Model\Data
 */
class MollieResponse implements MollieResponseInterface
{
    /**
     * @var string
     */
    private $redirectUrl;

    /**
     * CreditCardResponse constructor.
     * @param string $redirectUrl
     */
    public function __construct(string $redirectUrl)
    {
        $this->redirectUrl = $redirectUrl;
    }

    /**
     * Get issues url
     *
     * @return string
     */
    public function getRedirectUrl(): string
    {
        return $this->redirectUrl;
    }

}
