<?php

declare(strict_types=1);

use Illuminate\Http\Client\Factory;
use Illuminate\Http\Client\Request;
use Softgeng\Paystack\Config;
use Softgeng\Paystack\PaystackClient;
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

it('routes resource methods to the expected Paystack endpoint', function (
    string $resourceClass,
    string $method,
    array $arguments,
    string $httpMethod,
    string $path,
    array $data,
    string $token = 'sk_test_secret'
): void {
    $http = new Factory();
    $http->fake(fn () => $http->response(['status' => true, 'message' => 'ok', 'data' => ['ok' => true]], 200));

    $client = new PaystackClient(new Config(
        secret_key: 'sk_test_secret',
        public_key: 'pk_test_public',
    ), $http);

    $resource = new $resourceClass($client);
    $response = $resource->{$method}(...$arguments);

    expect($response->status)->toBeTrue();

    $http->assertSent(fn (Request $request): bool => $request->method() === $httpMethod
        && $request->url() === 'https://api.paystack.co'.$path
        && $request->data() === $data
        && $request->hasHeader('Authorization', 'Bearer '.$token));
})->with([
    'apple pay register domain' => [ApplePay::class, 'registerDomain', [['domainName' => 'example.com']], 'POST', '/apple-pay/domain', ['domainName' => 'example.com']],
    'apple pay list domains' => [ApplePay::class, 'listDomains', [['currency' => 'NGN']], 'GET', '/apple-pay/domain?currency=NGN', ['currency' => 'NGN']],
    'apple pay unregister domain' => [ApplePay::class, 'unregisterDomain', [['domainName' => 'example.com']], 'DELETE', '/apple-pay/domain', ['domainName' => 'example.com']],

    'bulk charge initiate' => [BulkCharges::class, 'initiate', [['batch' => []]], 'POST', '/bulkcharge', ['batch' => []]],
    'bulk charge list batches' => [BulkCharges::class, 'listBatches', [['perPage' => 10]], 'GET', '/bulkcharge?perPage=10', ['perPage' => 10]],
    'bulk charge fetch batch' => [BulkCharges::class, 'fetchBatch', ['BULK_123', ['perPage' => 10]], 'GET', '/bulkcharge/BULK_123?perPage=10', ['perPage' => 10]],
    'bulk charge fetch charges in batch' => [BulkCharges::class, 'fetchChargesInBatch', ['BULK_123', ['page' => 1]], 'GET', '/bulkcharge/BULK_123/charges?page=1', ['page' => 1]],
    'bulk charge pause' => [BulkCharges::class, 'pause', ['BULK_123', ['reason' => 'pause']], 'GET', '/bulkcharge/pause/BULK_123?reason=pause', ['reason' => 'pause']],
    'bulk charge resume' => [BulkCharges::class, 'resume', ['BULK_123', ['reason' => 'resume']], 'GET', '/bulkcharge/resume/BULK_123?reason=resume', ['reason' => 'resume']],

    'capitec pay requery' => [CapitecPay::class, 'requery', ['ref_123', ['currency' => 'ZAR']], 'GET', '/capitec-pay/requery/ref_123?currency=ZAR', ['currency' => 'ZAR'], 'pk_test_public'],

    'charge create' => [Charges::class, 'create', [['email' => 'a@example.com']], 'POST', '/charge', ['email' => 'a@example.com']],
    'charge submit pin' => [Charges::class, 'submitPin', [['pin' => '1234']], 'POST', '/charge/submit_pin', ['pin' => '1234']],
    'charge submit otp' => [Charges::class, 'submitOtp', [['otp' => '123456']], 'POST', '/charge/submit_otp', ['otp' => '123456']],
    'charge submit phone' => [Charges::class, 'submitPhone', [['phone' => '08000000000']], 'POST', '/charge/submit_phone', ['phone' => '08000000000']],
    'charge submit birthday' => [Charges::class, 'submitBirthday', [['birthday' => '2000-01-01']], 'POST', '/charge/submit_birthday', ['birthday' => '2000-01-01']],
    'charge submit address' => [Charges::class, 'submitAddress', [['address' => 'Lagos']], 'POST', '/charge/submit_address', ['address' => 'Lagos']],
    'charge check pending' => [Charges::class, 'checkPending', ['ref_123', ['status' => 'pending']], 'GET', '/charge/ref_123?status=pending', ['status' => 'pending']],

    'customers create' => [Customers::class, 'create', [['email' => 'a@example.com']], 'POST', '/customer', ['email' => 'a@example.com']],
    'customers list' => [Customers::class, 'list', [['perPage' => 10]], 'GET', '/customer?perPage=10', ['perPage' => 10]],
    'customers fetch' => [Customers::class, 'fetch', ['CUS_123', ['expand' => true]], 'GET', '/customer/CUS_123?expand=1', ['expand' => true]],
    'customers update' => [Customers::class, 'update', ['CUS_123', ['first_name' => 'Ada']], 'PUT', '/customer/CUS_123', ['first_name' => 'Ada']],
    'customers validate' => [Customers::class, 'validate', ['CUS_123', ['country' => 'NG']], 'POST', '/customer/CUS_123/identification', ['country' => 'NG']],
    'customers set risk action' => [Customers::class, 'setRiskAction', [['customer' => 'CUS_123']], 'POST', '/customer/set_risk_action', ['customer' => 'CUS_123']],
    'customers initialize authorization' => [Customers::class, 'initializeAuthorization', [['email' => 'a@example.com']], 'POST', '/customer/authorization/initialize', ['email' => 'a@example.com']],
    'customers verify authorization' => [Customers::class, 'verifyAuthorization', ['ref_123', ['channel' => 'card']], 'GET', '/customer/authorization/verify/ref_123?channel=card', ['channel' => 'card']],
    'customers initialize direct debit' => [Customers::class, 'initializeDirectDebit', ['CUS_123', ['account' => '001']], 'POST', '/customer/CUS_123/initialize-direct-debit', ['account' => '001']],
    'customers direct debit activation charge' => [Customers::class, 'directDebitActivationCharge', ['CUS_123', ['amount' => 100]], 'PUT', '/customer/CUS_123/directdebit-activation-charge', ['amount' => 100]],
    'customers mandate authorizations' => [Customers::class, 'mandateAuthorizations', ['CUS_123', ['status' => 'active']], 'GET', '/customer/CUS_123/directdebit-mandate-authorizations?status=active', ['status' => 'active']],
    'customers deactivate authorization' => [Customers::class, 'deactivateAuthorization', [['authorization_code' => 'AUTH_123']], 'POST', '/customer/authorization/deactivate', ['authorization_code' => 'AUTH_123']],

    'dedicated account create' => [DedicatedVirtualAccounts::class, 'create', [['customer' => 'CUS_123']], 'POST', '/dedicated_account', ['customer' => 'CUS_123']],
    'dedicated account assign' => [DedicatedVirtualAccounts::class, 'assign', [['email' => 'a@example.com']], 'POST', '/dedicated_account/assign', ['email' => 'a@example.com']],
    'dedicated account list' => [DedicatedVirtualAccounts::class, 'list', [['active' => true]], 'GET', '/dedicated_account?active=1', ['active' => true]],
    'dedicated account fetch' => [DedicatedVirtualAccounts::class, 'fetch', ['123', ['currency' => 'NGN']], 'GET', '/dedicated_account/123?currency=NGN', ['currency' => 'NGN']],
    'dedicated account deactivate' => [DedicatedVirtualAccounts::class, 'deactivate', ['123', ['reason' => 'close']], 'DELETE', '/dedicated_account/123', ['reason' => 'close']],
    'dedicated account split' => [DedicatedVirtualAccounts::class, 'split', [['account_number' => '001']], 'POST', '/dedicated_account/split', ['account_number' => '001']],
    'dedicated account remove split' => [DedicatedVirtualAccounts::class, 'removeSplit', [['account_number' => '001']], 'DELETE', '/dedicated_account/split', ['account_number' => '001']],
    'dedicated account providers' => [DedicatedVirtualAccounts::class, 'providers', [['currency' => 'NGN']], 'GET', '/dedicated_account/available_providers?currency=NGN', ['currency' => 'NGN']],
    'dedicated account requery' => [DedicatedVirtualAccounts::class, 'requery', [['account_number' => '001']], 'GET', '/dedicated_account/requery?account_number=001', ['account_number' => '001']],

    'direct debit trigger activation charge' => [DirectDebits::class, 'triggerActivationCharge', [['authorization_id' => 'AUTH_123']], 'PUT', '/directdebit/activation-charge', ['authorization_id' => 'AUTH_123']],
    'direct debit mandate authorizations' => [DirectDebits::class, 'mandateAuthorizations', [['status' => 'active']], 'GET', '/directdebit/mandate-authorizations?status=active', ['status' => 'active']],

    'disputes list' => [Disputes::class, 'list', [['status' => 'pending']], 'GET', '/dispute?status=pending', ['status' => 'pending']],
    'disputes fetch' => [Disputes::class, 'fetch', ['123', ['include' => 'evidence']], 'GET', '/dispute/123?include=evidence', ['include' => 'evidence']],
    'disputes list for transaction' => [Disputes::class, 'listForTransaction', ['456', ['perPage' => 10]], 'GET', '/dispute/transaction/456?perPage=10', ['perPage' => 10]],
    'disputes update' => [Disputes::class, 'update', ['123', ['refund_amount' => 100]], 'PUT', '/dispute/123', ['refund_amount' => 100]],
    'disputes add evidence' => [Disputes::class, 'addEvidence', ['123', ['customer_email' => 'a@example.com']], 'POST', '/dispute/123/evidence', ['customer_email' => 'a@example.com']],
    'disputes upload url' => [Disputes::class, 'getUploadUrl', ['123', ['upload_filename' => 'file.png']], 'GET', '/dispute/123/upload_url?upload_filename=file.png', ['upload_filename' => 'file.png']],
    'disputes resolve' => [Disputes::class, 'resolve', ['123', ['resolution' => 'merchant-accepted']], 'PUT', '/dispute/123/resolve', ['resolution' => 'merchant-accepted']],
    'disputes export' => [Disputes::class, 'export', [['from' => '2026-01-01']], 'GET', '/dispute/export?from=2026-01-01', ['from' => '2026-01-01']],

    'integration fetch payment session timeout' => [Integration::class, 'fetchPaymentSessionTimeout', [['currency' => 'NGN']], 'GET', '/integration/payment_session_timeout?currency=NGN', ['currency' => 'NGN']],
    'integration update payment session timeout' => [Integration::class, 'updatePaymentSessionTimeout', [['timeout' => 30]], 'PUT', '/integration/payment_session_timeout', ['timeout' => 30]],

    'misc list banks' => [Miscellaneous::class, 'listBanks', [['country' => 'nigeria']], 'GET', '/bank?country=nigeria', ['country' => 'nigeria']],
    'misc list countries' => [Miscellaneous::class, 'listCountries', [['region' => 'west']], 'GET', '/country?region=west', ['region' => 'west']],
    'misc list states' => [Miscellaneous::class, 'listStates', [['country' => 'NG']], 'GET', '/address_verification/states?country=NG', ['country' => 'NG']],

    'orders create' => [Orders::class, 'create', [['product' => 'PROD_123']], 'POST', '/order', ['product' => 'PROD_123']],
    'orders list' => [Orders::class, 'list', [['perPage' => 10]], 'GET', '/order?perPage=10', ['perPage' => 10]],
    'orders fetch' => [Orders::class, 'fetch', ['123', ['expand' => true]], 'GET', '/order/123?expand=1', ['expand' => true]],
    'orders product orders' => [Orders::class, 'productOrders', ['PROD_123', ['page' => 1]], 'GET', '/order/product/PROD_123?page=1', ['page' => 1]],
    'orders validate' => [Orders::class, 'validate', ['ORD_123', ['email' => 'a@example.com']], 'GET', '/order/ORD_123/validate?email=a%40example.com', ['email' => 'a@example.com']],

    'payment pages create' => [PaymentPages::class, 'create', [['name' => 'Page']], 'POST', '/page', ['name' => 'Page']],
    'payment pages list' => [PaymentPages::class, 'list', [['active' => true]], 'GET', '/page?active=1', ['active' => true]],
    'payment pages fetch' => [PaymentPages::class, 'fetch', ['page-slug', ['currency' => 'NGN']], 'GET', '/page/page-slug?currency=NGN', ['currency' => 'NGN']],
    'payment pages update' => [PaymentPages::class, 'update', ['page-slug', ['name' => 'New']], 'PUT', '/page/page-slug', ['name' => 'New']],
    'payment pages check slug' => [PaymentPages::class, 'checkSlugAvailability', ['page-slug', ['currency' => 'NGN']], 'GET', '/page/check_slug_availability/page-slug?currency=NGN', ['currency' => 'NGN']],
    'payment pages add products' => [PaymentPages::class, 'addProducts', ['123', ['products' => ['PROD_123']]], 'POST', '/page/123/product', ['products' => ['PROD_123']]],

    'payment requests create' => [PaymentRequests::class, 'create', [['customer' => 'CUS_123']], 'POST', '/paymentrequest', ['customer' => 'CUS_123']],
    'payment requests list' => [PaymentRequests::class, 'list', [['pending' => true]], 'GET', '/paymentrequest?pending=1', ['pending' => true]],
    'payment requests fetch' => [PaymentRequests::class, 'fetch', ['PRQ_123', ['currency' => 'NGN']], 'GET', '/paymentrequest/PRQ_123?currency=NGN', ['currency' => 'NGN']],
    'payment requests verify' => [PaymentRequests::class, 'verify', ['PRQ_123', ['currency' => 'NGN']], 'GET', '/paymentrequest/verify/PRQ_123?currency=NGN', ['currency' => 'NGN']],
    'payment requests notify' => [PaymentRequests::class, 'sendNotification', ['PRQ_123', ['channel' => 'email']], 'POST', '/paymentrequest/notify/PRQ_123', ['channel' => 'email']],
    'payment requests total' => [PaymentRequests::class, 'total', [['currency' => 'NGN']], 'GET', '/paymentrequest/totals?currency=NGN', ['currency' => 'NGN']],
    'payment requests finalize' => [PaymentRequests::class, 'finalize', ['PRQ_123', ['send_notification' => true]], 'POST', '/paymentrequest/finalize/PRQ_123', ['send_notification' => true]],
    'payment requests update' => [PaymentRequests::class, 'update', ['PRQ_123', ['description' => 'Updated']], 'PUT', '/paymentrequest/PRQ_123', ['description' => 'Updated']],
    'payment requests archive' => [PaymentRequests::class, 'archive', ['PRQ_123', ['reason' => 'done']], 'POST', '/paymentrequest/archive/PRQ_123', ['reason' => 'done']],

    'plans create' => [Plans::class, 'create', [['name' => 'Plan']], 'POST', '/plan', ['name' => 'Plan']],
    'plans list' => [Plans::class, 'list', [['status' => 'active']], 'GET', '/plan?status=active', ['status' => 'active']],
    'plans fetch' => [Plans::class, 'fetch', ['PLN_123', ['currency' => 'NGN']], 'GET', '/plan/PLN_123?currency=NGN', ['currency' => 'NGN']],
    'plans update' => [Plans::class, 'update', ['PLN_123', ['name' => 'New']], 'PUT', '/plan/PLN_123', ['name' => 'New']],

    'preauth initialize' => [Preauthorizations::class, 'initialize', [['email' => 'a@example.com']], 'POST', '/preauthorization/initialize', ['email' => 'a@example.com']],
    'preauth capture' => [Preauthorizations::class, 'capture', [['reference' => 'ref_123']], 'POST', '/preauthorization/capture', ['reference' => 'ref_123']],
    'preauth reserve' => [Preauthorizations::class, 'reserve', [['authorization_code' => 'AUTH_123']], 'POST', '/preauthorization/reserve_authorization', ['authorization_code' => 'AUTH_123']],
    'preauth verify' => [Preauthorizations::class, 'verify', ['ref_123', ['currency' => 'NGN']], 'GET', '/preauthorization/verify/ref_123?currency=NGN', ['currency' => 'NGN']],
    'preauth release' => [Preauthorizations::class, 'release', [['reference' => 'ref_123']], 'POST', '/preauthorization/release', ['reference' => 'ref_123']],
    'preauth list' => [Preauthorizations::class, 'list', [['status' => 'reserved']], 'GET', '/preauthorization?status=reserved', ['status' => 'reserved']],

    'products create' => [Products::class, 'create', [['name' => 'Product']], 'POST', '/product', ['name' => 'Product']],
    'products list' => [Products::class, 'list', [['active' => true]], 'GET', '/product?active=1', ['active' => true]],
    'products fetch' => [Products::class, 'fetch', ['PROD_123', ['currency' => 'NGN']], 'GET', '/product/PROD_123?currency=NGN', ['currency' => 'NGN']],
    'products update' => [Products::class, 'update', ['PROD_123', ['name' => 'New']], 'PUT', '/product/PROD_123', ['name' => 'New']],

    'refunds create' => [Refunds::class, 'create', [['transaction' => '123']], 'POST', '/refund', ['transaction' => '123']],
    'refunds list' => [Refunds::class, 'list', [['currency' => 'NGN']], 'GET', '/refund?currency=NGN', ['currency' => 'NGN']],
    'refunds fetch' => [Refunds::class, 'fetch', ['RFN_123', ['currency' => 'NGN']], 'GET', '/refund/RFN_123?currency=NGN', ['currency' => 'NGN']],
    'refunds retry' => [Refunds::class, 'retry', ['RFN_123', ['reason' => 'retry']], 'POST', '/refund/RFN_123/retry', ['reason' => 'retry']],

    'settlements list' => [Settlements::class, 'list', [['currency' => 'NGN']], 'GET', '/settlement?currency=NGN', ['currency' => 'NGN']],
    'settlements transactions' => [Settlements::class, 'transactions', ['123', ['page' => 1]], 'GET', '/settlement/123/transactions?page=1', ['page' => 1]],

    'splits create' => [Splits::class, 'create', [['name' => 'Split']], 'POST', '/split', ['name' => 'Split']],
    'splits list' => [Splits::class, 'list', [['active' => true]], 'GET', '/split?active=1', ['active' => true]],
    'splits fetch' => [Splits::class, 'fetch', ['SPL_123', ['currency' => 'NGN']], 'GET', '/split/SPL_123?currency=NGN', ['currency' => 'NGN']],
    'splits update' => [Splits::class, 'update', ['SPL_123', ['name' => 'New']], 'PUT', '/split/SPL_123', ['name' => 'New']],
    'splits add subaccount' => [Splits::class, 'addSubaccount', ['SPL_123', ['subaccount' => 'ACCT_123']], 'POST', '/split/SPL_123/subaccount/add', ['subaccount' => 'ACCT_123']],
    'splits remove subaccount' => [Splits::class, 'removeSubaccount', ['SPL_123', ['subaccount' => 'ACCT_123']], 'POST', '/split/SPL_123/subaccount/remove', ['subaccount' => 'ACCT_123']],

    'storefronts create' => [Storefronts::class, 'create', [['name' => 'Store']], 'POST', '/storefront', ['name' => 'Store']],
    'storefronts list' => [Storefronts::class, 'list', [['active' => true]], 'GET', '/storefront?active=1', ['active' => true]],
    'storefronts fetch' => [Storefronts::class, 'fetch', ['123', ['currency' => 'NGN']], 'GET', '/storefront/123?currency=NGN', ['currency' => 'NGN']],
    'storefronts update' => [Storefronts::class, 'update', ['123', ['name' => 'New']], 'PUT', '/storefront/123', ['name' => 'New']],
    'storefronts delete' => [Storefronts::class, 'delete', ['123', ['reason' => 'closed']], 'DELETE', '/storefront/123', ['reason' => 'closed']],
    'storefronts verify slug' => [Storefronts::class, 'verifySlug', ['store-slug', ['currency' => 'NGN']], 'GET', '/storefront/verify/store-slug?currency=NGN', ['currency' => 'NGN']],
    'storefronts orders' => [Storefronts::class, 'orders', ['123', ['page' => 1]], 'GET', '/storefront/123/order?page=1', ['page' => 1]],
    'storefronts add products' => [Storefronts::class, 'addProducts', ['123', ['products' => ['PROD_123']]], 'POST', '/storefront/123/product', ['products' => ['PROD_123']]],
    'storefronts products' => [Storefronts::class, 'products', ['123', ['active' => true]], 'GET', '/storefront/123/product?active=1', ['active' => true]],
    'storefronts publish' => [Storefronts::class, 'publish', ['123', ['published' => true]], 'POST', '/storefront/123/publish', ['published' => true]],
    'storefronts duplicate' => [Storefronts::class, 'duplicate', ['123', ['name' => 'Copy']], 'POST', '/storefront/123/duplicate', ['name' => 'Copy']],

    'subaccounts create' => [Subaccounts::class, 'create', [['business_name' => 'Biz']], 'POST', '/subaccount', ['business_name' => 'Biz']],
    'subaccounts list' => [Subaccounts::class, 'list', [['active' => true]], 'GET', '/subaccount?active=1', ['active' => true]],
    'subaccounts fetch' => [Subaccounts::class, 'fetch', ['ACCT_123', ['currency' => 'NGN']], 'GET', '/subaccount/ACCT_123?currency=NGN', ['currency' => 'NGN']],
    'subaccounts update' => [Subaccounts::class, 'update', ['ACCT_123', ['business_name' => 'New']], 'PUT', '/subaccount/ACCT_123', ['business_name' => 'New']],

    'subscriptions create' => [Subscriptions::class, 'create', [['customer' => 'CUS_123']], 'POST', '/subscription', ['customer' => 'CUS_123']],
    'subscriptions list' => [Subscriptions::class, 'list', [['status' => 'active']], 'GET', '/subscription?status=active', ['status' => 'active']],
    'subscriptions fetch' => [Subscriptions::class, 'fetch', ['SUB_123', ['currency' => 'NGN']], 'GET', '/subscription/SUB_123?currency=NGN', ['currency' => 'NGN']],
    'subscriptions enable' => [Subscriptions::class, 'enable', [['code' => 'SUB_123']], 'POST', '/subscription/enable', ['code' => 'SUB_123']],
    'subscriptions disable' => [Subscriptions::class, 'disable', [['code' => 'SUB_123']], 'POST', '/subscription/disable', ['code' => 'SUB_123']],
    'subscriptions manage link' => [Subscriptions::class, 'manageLink', ['SUB_123', ['channel' => 'email']], 'GET', '/subscription/SUB_123/manage/link?channel=email', ['channel' => 'email']],
    'subscriptions send manage link' => [Subscriptions::class, 'sendManageLink', ['SUB_123', ['email' => 'a@example.com']], 'POST', '/subscription/SUB_123/manage/email', ['email' => 'a@example.com']],

    'terminals send event' => [Terminals::class, 'sendEvent', ['TERM_123', ['type' => 'invoice']], 'POST', '/terminal/TERM_123/event', ['type' => 'invoice']],
    'terminals fetch event status' => [Terminals::class, 'fetchEventStatus', ['TERM_123', 'EVT_123', ['currency' => 'NGN']], 'GET', '/terminal/TERM_123/event/EVT_123?currency=NGN', ['currency' => 'NGN']],
    'terminals fetch terminal status' => [Terminals::class, 'fetchTerminalStatus', ['TERM_123', ['currency' => 'NGN']], 'GET', '/terminal/TERM_123/presence?currency=NGN', ['currency' => 'NGN']],
    'terminals list' => [Terminals::class, 'list', [['online' => true]], 'GET', '/terminal?online=1', ['online' => true]],
    'terminals fetch' => [Terminals::class, 'fetch', ['TERM_123', ['currency' => 'NGN']], 'GET', '/terminal/TERM_123?currency=NGN', ['currency' => 'NGN']],
    'terminals update' => [Terminals::class, 'update', ['TERM_123', ['name' => 'Terminal']], 'PUT', '/terminal/TERM_123', ['name' => 'Terminal']],
    'terminals commission' => [Terminals::class, 'commission', ['TERM_123', ['serial_number' => 'SN']], 'POST', '/terminal/TERM_123/commission', ['serial_number' => 'SN']],
    'terminals decommission' => [Terminals::class, 'decommission', ['TERM_123', ['reason' => 'retired']], 'POST', '/terminal/TERM_123/decommission', ['reason' => 'retired']],

    'transactions initialize' => [Transactions::class, 'initialize', [['email' => 'a@example.com']], 'POST', '/transaction/initialize', ['email' => 'a@example.com']],
    'transactions verify' => [Transactions::class, 'verify', ['ref_123', ['currency' => 'NGN']], 'GET', '/transaction/verify/ref_123?currency=NGN', ['currency' => 'NGN']],
    'transactions list' => [Transactions::class, 'list', [['status' => 'success']], 'GET', '/transaction?status=success', ['status' => 'success']],
    'transactions fetch' => [Transactions::class, 'fetch', ['123', ['currency' => 'NGN']], 'GET', '/transaction/123?currency=NGN', ['currency' => 'NGN']],
    'transactions charge authorization' => [Transactions::class, 'chargeAuthorization', [['authorization_code' => 'AUTH_123']], 'POST', '/transaction/charge_authorization', ['authorization_code' => 'AUTH_123']],
    'transactions timeline' => [Transactions::class, 'viewTimeline', ['ref_123', ['currency' => 'NGN']], 'GET', '/transaction/timeline/ref_123?currency=NGN', ['currency' => 'NGN']],
    'transactions totals' => [Transactions::class, 'transactionTotals', [['currency' => 'NGN']], 'GET', '/transaction/totals?currency=NGN', ['currency' => 'NGN']],
    'transactions export' => [Transactions::class, 'export', [['from' => '2026-01-01']], 'GET', '/transaction/export?from=2026-01-01', ['from' => '2026-01-01']],
    'transactions partial debit' => [Transactions::class, 'partialDebit', [['authorization_code' => 'AUTH_123']], 'POST', '/transaction/partial_debit', ['authorization_code' => 'AUTH_123']],

    'transfer control balance' => [TransferControl::class, 'balance', [['currency' => 'NGN']], 'GET', '/balance?currency=NGN', ['currency' => 'NGN']],
    'transfer control ledger' => [TransferControl::class, 'ledger', [['currency' => 'NGN']], 'GET', '/balance/ledger?currency=NGN', ['currency' => 'NGN']],
    'transfer control resend otp' => [TransferControl::class, 'resendOtp', [['transfer_code' => 'TRF_123']], 'POST', '/transfer/resend_otp', ['transfer_code' => 'TRF_123']],
    'transfer control disable otp' => [TransferControl::class, 'disableOtp', [['reason' => 'disable']], 'POST', '/transfer/disable_otp', ['reason' => 'disable']],
    'transfer control finalize disable otp' => [TransferControl::class, 'finalizeDisableOtp', [['otp' => '123456']], 'POST', '/transfer/disable_otp_finalize', ['otp' => '123456']],
    'transfer control enable otp' => [TransferControl::class, 'enableOtp', [['reason' => 'enable']], 'POST', '/transfer/enable_otp', ['reason' => 'enable']],

    'transfer recipients create' => [TransferRecipients::class, 'create', [['type' => 'nuban']], 'POST', '/transferrecipient', ['type' => 'nuban']],
    'transfer recipients bulk create' => [TransferRecipients::class, 'bulkCreate', [['batch' => []]], 'POST', '/transferrecipient/bulk', ['batch' => []]],
    'transfer recipients list' => [TransferRecipients::class, 'list', [['active' => true]], 'GET', '/transferrecipient?active=1', ['active' => true]],
    'transfer recipients fetch' => [TransferRecipients::class, 'fetch', ['RCP_123', ['currency' => 'NGN']], 'GET', '/transferrecipient/RCP_123?currency=NGN', ['currency' => 'NGN']],
    'transfer recipients update' => [TransferRecipients::class, 'update', ['RCP_123', ['name' => 'New']], 'PUT', '/transferrecipient/RCP_123', ['name' => 'New']],
    'transfer recipients delete' => [TransferRecipients::class, 'delete', ['RCP_123', ['reason' => 'old']], 'DELETE', '/transferrecipient/RCP_123', ['reason' => 'old']],

    'transfers initiate' => [Transfers::class, 'initiate', [['source' => 'balance']], 'POST', '/transfer', ['source' => 'balance']],
    'transfers finalize' => [Transfers::class, 'finalize', [['transfer_code' => 'TRF_123']], 'POST', '/transfer/finalize_transfer', ['transfer_code' => 'TRF_123']],
    'transfers bulk' => [Transfers::class, 'bulk', [['batch' => []]], 'POST', '/transfer/bulk', ['batch' => []]],
    'transfers list' => [Transfers::class, 'list', [['status' => 'success']], 'GET', '/transfer?status=success', ['status' => 'success']],
    'transfers fetch' => [Transfers::class, 'fetch', ['TRF_123', ['currency' => 'NGN']], 'GET', '/transfer/TRF_123?currency=NGN', ['currency' => 'NGN']],
    'transfers verify' => [Transfers::class, 'verify', ['ref_123', ['currency' => 'NGN']], 'GET', '/transfer/verify/ref_123?currency=NGN', ['currency' => 'NGN']],

    'verification resolve account number' => [Verification::class, 'resolveAccountNumber', [['account_number' => '0000000000']], 'GET', '/bank/resolve?account_number=0000000000', ['account_number' => '0000000000']],
    'verification validate account' => [Verification::class, 'validateAccount', [['account_name' => 'Ada']], 'POST', '/bank/validate', ['account_name' => 'Ada']],
    'verification resolve card bin' => [Verification::class, 'resolveCardBin', ['408408', ['country' => 'NG']], 'GET', '/decision/bin/408408?country=NG', ['country' => 'NG']],

    'virtual terminals create' => [VirtualTerminals::class, 'create', [['name' => 'Terminal']], 'POST', '/virtual_terminal', ['name' => 'Terminal']],
    'virtual terminals list' => [VirtualTerminals::class, 'list', [['active' => true]], 'GET', '/virtual_terminal?active=1', ['active' => true]],
    'virtual terminals fetch' => [VirtualTerminals::class, 'fetch', ['VT_123', ['currency' => 'NGN']], 'GET', '/virtual_terminal/VT_123?currency=NGN', ['currency' => 'NGN']],
    'virtual terminals update' => [VirtualTerminals::class, 'update', ['VT_123', ['name' => 'New']], 'PUT', '/virtual_terminal/VT_123', ['name' => 'New']],
    'virtual terminals deactivate' => [VirtualTerminals::class, 'deactivate', ['VT_123', ['reason' => 'closed']], 'PUT', '/virtual_terminal/VT_123/deactivate', ['reason' => 'closed']],
    'virtual terminals assign destination' => [VirtualTerminals::class, 'assignDestination', ['VT_123', ['destination' => 'ACCT_123']], 'POST', '/virtual_terminal/VT_123/destination/assign', ['destination' => 'ACCT_123']],
    'virtual terminals unassign destination' => [VirtualTerminals::class, 'unassignDestination', ['VT_123', ['destination' => 'ACCT_123']], 'POST', '/virtual_terminal/VT_123/destination/unassign', ['destination' => 'ACCT_123']],
    'virtual terminals add split code' => [VirtualTerminals::class, 'addSplitCode', ['VT_123', ['split_code' => 'SPL_123']], 'PUT', '/virtual_terminal/VT_123/split_code', ['split_code' => 'SPL_123']],
    'virtual terminals remove split code' => [VirtualTerminals::class, 'removeSplitCode', ['VT_123', ['split_code' => 'SPL_123']], 'DELETE', '/virtual_terminal/VT_123/split_code', ['split_code' => 'SPL_123']],
]);
