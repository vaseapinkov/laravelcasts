<?php

use App\Jobs\HandelPaddlePurchaseJob;
use Spatie\WebhookClient\Models\WebhookCall;

function getValidPaddleRequestData(): array
{
    return ['alert_id' => 412206051,
        'alert_name' => 'payment_succeeded',
        'balance_currency' => 'GBP',
        'balance_earnings' => 62.3,
        'balance_fee' => 393.48,
        'balance_gross' => 765.97,
        'balance_tax' => 641.9,
        'checkout_id' => '9-75c2d6b8bae3fa4-074a925ace',
        'country' => 'AU',
        'coupon' => 'Coupon 2',
        'currency' => 'GBP',
        'custom_data' => 'custom_data',
        'customer_name' => 'customer_name',
        'earnings' => 550.22,
        'email' => 'bednar.janice@example.com',
        'event_time' => '2023-10-06 21:00:57',
        'fee' => 0.65,
        'ip' => '206.15.62.182',
        'marketing_consent' => '',
        'order_id' => 5,
        'passthrough' => 'Example String',
        'payment_method' => 'card',
        'payment_tax' => 1,
        'product_id' => 7,
        'product_name' => 'Example String',
        'quantity' => 39,
        'receipt_url' => 'https://sandbox-my.paddle.com/receipt/5/ab80a9e2f4aafde-27fafcb50d',
        'sale_gross' => 486.13,
        'used_price_override' => 1,
        'p_signature' => 'bS22ewM80lLjFjbZqjIvyQfS / Hs8GQJk / dhvKNyI84pN7CG5a20Z1lgvJ6XsNFXBHYCA / H4N0U6XilllOPBaqHKPCjXZ3M5RBsY2moS4zHIlq9xhZRy6gPRVLPifyrVtGGH4IMGVEJYZXbC7WUVKUOdE37v3hxRR8IGeK3RYi61UgnwSc40gqNHojsRBuPBi + z3sMypNMpD1JQl68CfuvPq / sBCD / ja1CzO + t3 / YM2vv69sW3qN1KJRaghNNq4j0XR8Ugm1MORkUxkmLCgCg5iSixRHkMMfHxFoMVswRS / QHRwIGALd4gSTn4zckwst2YER895bZ6 / bfWfClyWEYRDfSNL1vISSDVGM9DcBu6UxFYOSF9Lye9kiRgNahKuFsh3 + c4AjdXR83CC00oLufOjXzRJ9aMguK / tMdeV4H1wwBL9yi8f9FGYkKmFAiUgn2q9V + Yn6B2tf7bSLNLxJgbefjw + ED9HRu3w9WxiuUZPYxvKV1e + rHbdym4rVs1PeLojo / QhlicGIJbvWcQv10MkSXBedYUpzQdPO + kSKbj5Y82bSnOYUc5 / HtJRdjwJCTQajY9W9dn8dStEzoKSTwpapOBQrsg8RXSuDWXbh6Dgdf65fe7O / qAG0pSfAc0L8Xtjb4PlgzoeiX9eZENRoGlYJIMO0AUtK / Hv3NRmMaMms =',
    ];
}

function getInvalidPaddleRequest(): array
{
    return [];
}

it('store a paddle purchase request', function () {
    Queue::fake();

    $this->assertDatabaseCount(WebhookCall::class, 0);

    $this->post('webhooks', getValidPaddleRequestData());

    $this->assertDatabaseCount(WebhookCall::class, 1);
});

it('does not store a invalid paddle purchase request', function () {
    $this->assertDatabaseCount(WebhookCall::class, 0);

    $this->post('webhooks', getInvalidPaddleRequest());

    $this->assertDatabaseCount(WebhookCall::class, 0);
});

it('dispatches a job for a valid paddle request', function () {
    Queue::fake();

    $this->post('webhooks', getValidPaddleRequestData());

    Queue::assertPushed(HandelPaddlePurchaseJob::class);
});

it('does not dispatches a job for a valid paddle request', function () {
    Queue::fake();

    $this->post('webhooks', getInvalidPaddleRequest());

    Queue::assertNothingPushed();
});
