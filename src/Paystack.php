<?php

declare(strict_types=1);

namespace Softgeng\Paystack;

use Softgeng\Paystack\Resources\ApplePay;
use Softgeng\Paystack\Resources\BulkCharges;
use Softgeng\Paystack\Resources\CapitecPay;
use Softgeng\Paystack\Resources\Charges;
use Softgeng\Paystack\Resources\Customers;
use Softgeng\Paystack\Resources\DedicatedVirtualAccounts;
use Softgeng\Paystack\Resources\DirectDebits;
use Softgeng\Paystack\Resources\Disputes;
use Softgeng\Paystack\Resources\Integration;
use Softgeng\Paystack\Resources\Miscellaneous;
use Softgeng\Paystack\Resources\Orders;
use Softgeng\Paystack\Resources\PaymentPages;
use Softgeng\Paystack\Resources\PaymentRequests;
use Softgeng\Paystack\Resources\Plans;
use Softgeng\Paystack\Resources\Preauthorizations;
use Softgeng\Paystack\Resources\Products;
use Softgeng\Paystack\Resources\Refunds;
use Softgeng\Paystack\Resources\Settlements;
use Softgeng\Paystack\Resources\Splits;
use Softgeng\Paystack\Resources\Storefronts;
use Softgeng\Paystack\Resources\Subaccounts;
use Softgeng\Paystack\Resources\Subscriptions;
use Softgeng\Paystack\Resources\Terminals;
use Softgeng\Paystack\Resources\Transactions;
use Softgeng\Paystack\Resources\TransferControl;
use Softgeng\Paystack\Resources\TransferRecipients;
use Softgeng\Paystack\Resources\Transfers;
use Softgeng\Paystack\Resources\Verification;
use Softgeng\Paystack\Resources\VirtualTerminals;

final class Paystack
{
    private ?Transactions $transactions = null;

    private ?Customers $customers = null;

    private ?DedicatedVirtualAccounts $dedicatedVirtualAccounts = null;

    private ?Plans $plans = null;

    private ?Subscriptions $subscriptions = null;

    private ?TransferRecipients $transferRecipients = null;

    private ?Transfers $transfers = null;

    private ?TransferControl $transferControl = null;

    private ?Charges $charges = null;

    private ?BulkCharges $bulkCharges = null;

    private ?PaymentRequests $paymentRequests = null;

    private ?PaymentPages $paymentPages = null;

    private ?Products $products = null;

    private ?Storefronts $storefronts = null;

    private ?Orders $orders = null;

    private ?Subaccounts $subaccounts = null;

    private ?Splits $splits = null;

    private ?Refunds $refunds = null;

    private ?Disputes $disputes = null;

    private ?Settlements $settlements = null;

    private ?Verification $verification = null;

    private ?Miscellaneous $miscellaneous = null;

    private ?ApplePay $applePay = null;

    private ?Integration $integration = null;

    private ?Terminals $terminals = null;

    private ?VirtualTerminals $virtualTerminals = null;

    private ?Preauthorizations $preauthorizations = null;

    private ?DirectDebits $directDebits = null;

    private ?CapitecPay $capitecPay = null;

    public function __construct(
        private readonly Config $config,
        private readonly ?PaystackClient $providedClient = null
    ) {}

    public static function make(
        string $secretKey,
        ?string $publicKey = null
    ): self {
        return new self(
            new Config(secret_key: $secretKey, public_key: $publicKey)
        );
    }

    public function transactions(): Transactions
    {
        return $this->transactions ??= new Transactions($this->client());
    }

    public function customers(): Customers
    {
        return $this->customers ??= new Customers($this->client());
    }

    public function dedicatedVirtualAccounts(): DedicatedVirtualAccounts
    {
        return $this->dedicatedVirtualAccounts ??= new DedicatedVirtualAccounts(
            $this->client()
        );
    }

    public function plans(): Plans
    {
        return $this->plans ??= new Plans($this->client());
    }

    public function subscriptions(): Subscriptions
    {
        return $this->subscriptions ??= new Subscriptions($this->client());
    }

    public function transferRecipients(): TransferRecipients
    {
        return $this->transferRecipients ??= new TransferRecipients(
            $this->client()
        );
    }

    public function transfers(): Transfers
    {
        return $this->transfers ??= new Transfers($this->client());
    }

    public function transferControl(): TransferControl
    {
        return $this->transferControl ??= new TransferControl(
            $this->client()
        );
    }

    public function charges(): Charges
    {
        return $this->charges ??= new Charges($this->client());
    }

    public function bulkCharges(): BulkCharges
    {
        return $this->bulkCharges ??= new BulkCharges($this->client());
    }

    public function paymentRequests(): PaymentRequests
    {
        return $this->paymentRequests ??= new PaymentRequests(
            $this->client()
        );
    }

    public function paymentPages(): PaymentPages
    {
        return $this->paymentPages ??= new PaymentPages($this->client());
    }

    public function products(): Products
    {
        return $this->products ??= new Products($this->client());
    }

    public function storefronts(): Storefronts
    {
        return $this->storefronts ??= new Storefronts($this->client());
    }

    public function orders(): Orders
    {
        return $this->orders ??= new Orders($this->client());
    }

    public function subaccounts(): Subaccounts
    {
        return $this->subaccounts ??= new Subaccounts($this->client());
    }

    public function splits(): Splits
    {
        return $this->splits ??= new Splits($this->client());
    }

    public function refunds(): Refunds
    {
        return $this->refunds ??= new Refunds($this->client());
    }

    public function disputes(): Disputes
    {
        return $this->disputes ??= new Disputes($this->client());
    }

    public function settlements(): Settlements
    {
        return $this->settlements ??= new Settlements($this->client());
    }

    public function verification(): Verification
    {
        return $this->verification ??= new Verification($this->client());
    }

    public function miscellaneous(): Miscellaneous
    {
        return $this->miscellaneous ??= new Miscellaneous($this->client());
    }

    public function applePay(): ApplePay
    {
        return $this->applePay ??= new ApplePay($this->client());
    }

    public function integration(): Integration
    {
        return $this->integration ??= new Integration($this->client());
    }

    public function terminals(): Terminals
    {
        return $this->terminals ??= new Terminals($this->client());
    }

    public function virtualTerminals(): VirtualTerminals
    {
        return $this->virtualTerminals ??= new VirtualTerminals(
            $this->client()
        );
    }

    public function preauthorizations(): Preauthorizations
    {
        return $this->preauthorizations ??= new Preauthorizations(
            $this->client()
        );
    }

    public function directDebits(): DirectDebits
    {
        return $this->directDebits ??= new DirectDebits($this->client());
    }

    public function capitecPay(): CapitecPay
    {
        return $this->capitecPay ??= new CapitecPay($this->client());
    }

    private function client(): PaystackClient
    {
        return $this->providedClient ?? new PaystackClient($this->config);
    }
}
