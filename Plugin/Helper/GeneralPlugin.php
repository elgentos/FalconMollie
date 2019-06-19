<?php

namespace Elgentos\FalconMollie\Plugin\Helper;

use Mollie\Payment\Helper\General;

class GeneralPlugin
{
    const PAYMENT_MOLLIE_DEITY_REDIRECT_URL = 'payment/mollie/mollie_deity/redirect_url';
    const PAYMENT_MOLLIE_DEITY_WEBHOOK_URL = 'payment/mollie/mollie_deity/webhook_url';

    /**
     * @param General $subject
     * @param $result
     * @return mixed
     *
     * Return default Mollie webhook URL when nothing is set
     */
    public function afterGetWebhookUrl(General $subject, $result)
    {
        return $subject->getStoreConfig(self::PAYMENT_MOLLIE_DEITY_WEBHOOK_URL) ?: $result;
    }

    /**
     * @param General $subject
     * @param $result
     * @param $orderId
     * @param $paymentToken
     * @return string
     *
     * Return default Mollie redirect URL (M2 frontend) when nothing is set
     */
    public function afterGetRedirectUrl(General $subject, $result, $orderId, $paymentToken)
    {
        $redirectUrlFromConfig = $subject->getStoreConfig(self::PAYMENT_MOLLIE_DEITY_REDIRECT_URL);

        if (!$redirectUrlFromConfig) {
            return $result;
        }

        $parsedUrl = parse_url($result);

        // Merge the query parameters
        $queryParameters = array_merge(
            $parsedUrl['query'] ? $this->convertUrlQuery($parsedUrl['query']) : [],
            isset($redirectUrlFromConfig['query'] && $redirectUrlFromConfig['query']) ? $this->convertUrlQuery($redirectUrlFromConfig['query']) : []
        );
        $redirectUrlFromConfig['query'] = http_build_query($queryParameters);

        // Merge the two URL part arrays
        $resultingUrl = array_merge($parsedUrl, $redirectUrlFromConfig);

        // Return combined URL
        return http_build_url($resultingUrl);
    }

    /**
     * @param $query
     * @return array
     */
    private function convertUrlQuery($query) {
        $queryParts = explode('&', $query);

        $params = array();
        foreach ($queryParts as $param) {
            $item = explode('=', $param);
            $params[$item[0]] = $item[1];
        }

        return $params;
    }
}
