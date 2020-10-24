# Elgentos Falcon Mollie implementation

This Magento 2 module facilitates the implementation of the [Mollie](http://mollie.nl) [iDeal](https://www.ideal.nl/) & Bancontact payment method into [Deity Falcon](https://falcon.deity.io/).

## Implementation

First you should configure the [Magento 2 Mollie extension](https://github.com/mollie/magento2) and set the Redirect URL under `Payment Methods > Mollie > Deity`.

Then, you should implement a bit of code in Falcon;

## Falcon implementation

Extend the `Magento2Api` class in Falcon and override the `placeOrder` function. After the part about `adyenCc`, paste this;

```javascript
    if (orderData.extensionAttributes && orderData.extensionAttributes.mollieData) {
      return this.handleMollieData(orderData.extensionAttributes.mollieData);
    }
```

Then, below the `placeOrder` function, add the new `handleMollieData` function;

```javascript
  /**
   * Handling Mollie payment
   * @param {object} data mollieRedirect data
   * @return {object} Redirect response data
   */
  handleMollieData(data) {
    const { redirectUrl } = data;

    return {
      url: redirectUrl,
      method: 'GET',
      fields: []
    };
  }
```

## Flow

After choosing the Mollie iDeal payment method in the Falcon checkout, the API will return the external URL from Mollie. Falcon will then redirect the user to Mollie's payment platform. After payment of the order, the user will be redirected to the configured `Redirect URL`. At the same time, Mollie will send a webhook request to the webhook URL, letting Magento know the payment has been processed.
