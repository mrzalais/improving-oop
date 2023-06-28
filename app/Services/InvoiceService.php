<?php

declare(strict_types = 1);

namespace App\Services;

use App\Models\Email;
use Symfony\Component\Mime\Address;

class InvoiceService
{
    public function __construct(
        protected SalesTaxService $salesTaxService,
        protected PaymentGatewayService $gatewayService,
        protected EmailService $emailService
    ) {
    }

    public function process(array $customer, float $amount): bool
    {
        // 1. calculate sales tax
        $tax = $this->salesTaxService->calculate($amount, $customer);

        // 2. process invoice
        if (! $this->gatewayService->charge($customer, $amount, $tax)) {
            return false;
        }

        // 3. send receipt

        $firstName = ' Some customer';

        $text = <<<Body
Receipt for $firstName,
Thank you for purchasing
Body;

        $html = <<<HTMLBody
<h1 style="text-align: center; color: blue;">Thank you</h1>
Here is your receipt
HTMLBody;


        (new Email())->queue(
            new Address('someCustomer@email.com'),
            new Address('support@example.com', 'Support'),
            'receipt',
            $html,
            $text
        );

        echo 'Invoice has been processed<br />';

        return true;
    }
}
