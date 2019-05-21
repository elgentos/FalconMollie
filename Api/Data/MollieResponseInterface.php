<?php
declare(strict_types=1);

namespace Elgentos\FalconMollie\Api\Data;

/**
 * Interface MollieResponseInterface
 *
 * @package Elgentos\FalconMollie\Api\Data
 */
interface MollieResponseInterface
{
    const REDIRECT_URL = 'redirectUrl';

    /**
     * Get issues url
     *
     * @return string
     */
    public function getRedirectUrl(): string ;

}
