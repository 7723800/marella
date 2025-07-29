<?php

namespace App\Http\Controllers;

use App\Models\Order;
use GuzzleHttp\Client;
use App\Mail\OrderFormed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Inani\LaravelNovaConfiguration\Helpers\Configuration;

class KaspiQrController extends Controller
{
    /**
     * @var GuzzleHttp\Client
     */
    protected $client;

    /**
     * @var string
     */
    private $deviceToken;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->deviceToken = env("KASPI_DEVICE_TOKEN");
        $this->client = new Client(
            [
                "headers" => [
                    "Api-Key" => env("KASPI_API_KEY"),
                    "Content-Type" => "application/json"
                ],
                "verify" => true,
                "timeout" => 8.0,
                "cert" => storage_path() . "/app/certs/donato.pem"
            ]
        );
    }

    /**
     * Create kaspi qr transaction
     *
     * @param string $orderNumber
     * @param int $amount
     * @return object
     */
    public function createLink(string $orderNumber, int $amount): object
    {
        $response = $this->client->post("https://qrapi-key.kaspi.kz/r1/v01/qr/create-link", [
            "json" => [
                "DeviceToken" => $this->deviceToken,
                "Amount" => $amount,
                "ExternalId" => $orderNumber
            ]
        ]);

        $body = json_decode($response->getBody()->getContents());
        $data = (object) [
            "paymentId" => (string) $body->Data->PaymentId,
            "formUrl" => $body->Data->PaymentLink
        ];

        return $data;
    }

    /**
     * Create kaspi qr transaction
     *
     * @param string $paymentId
     * @return object
     */
    public function status(string $paymentId): object
    {
        $response = $this->client->get("https://qrapi-key.kaspi.kz/r1/v01/payment/status/{$paymentId}");
        $body = json_decode($response->getBody()->getContents());
        return $body;
    }

    /**
     * Check payment processed or not
     *
     * @param ?string $paymentId
     * @return bool
     */
    public function processed(?string $paymentId): bool
    {
        if (is_null($paymentId)) {
            return false;
        }
        $data = $this->status($paymentId);
        return $data->Data->Status == "Processed";
    }

    /**
     * Confirm order
     *
     * @param string $id
     * @return void
     */
    public function confirm(string $id): void
    {
        $email = Configuration::get('MANAGER_EMAIL');
        $order = Order::where("id", $id)->first();
        Mail::to($email)->send(new OrderFormed($order));
    }

    /**
     * Test kaspi qr
     *
     * @param int $qrPaymentId
     * @param int $amount
     * @return void
     */
    public function paymentReturn(int $qrPaymentId, int $amount): void
    {
        $response = $this->client->post("https://qrapi-cert-ip.kaspi.kz/r3/v01/payment/return", [
            "json" => [
                "OrganizationBin" => "881215450016",
                "DeviceToken" => $this->deviceToken,
                "Amount" => $amount,
                "QrPaymentId" => $qrPaymentId
            ]
        ]);

        Log::debug($response->getBody()->getContents());
    }
}
