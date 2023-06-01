<?php

declare(strict_types=1);

namespace App\Services\ZohoRequestService;

use App\DTO\AccountDTO;
use App\DTO\DealDTO;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class RequestSender
{

    public function __construct()
    {
        if (!Cache::get('token')) {
            $this->refreshToken();
        }
    }

    public function refreshToken(): void
    {
        $url = RequestConstants::REFRESH_LINK
            . '?refresh_token=' . config('zoho.refresh_token')
            . '&client_id=' . config('zoho.client_id')
            . '&client_secret=' . config('zoho.client_secret')
            . '&grant_type=refresh_token';
        $response = Http::post($url);

        Cache::put('token', $response['access_token'], 3600);

        $this->accessToken = $response['access_token'];
    }

    public function createDeal(DealDTO $deal)
    {
        $data = $this->createDealData($deal);
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Zoho-oauthtoken ' . Cache::get('token')
        ])->post(RequestConstants::DEAL_LINK, $data);

        return $response;
    }

    public function createDealData(DealDTO $deal): array
    {
        return [
            "data" => [
                [
                    "Layout" => [
                        "id" => RequestConstants::DEAL_LAYOUT_ID
                    ],
                    "Deal_Name" => $deal->getDealName(),
                    "Stage" => $deal->getDealStage(),
                    "Closing_Date" => $deal->getClosingDate(),
                    "Account_Name" => $deal->getAccountName()
                ]
            ]
        ];
    }

    public function getAccounts()
    {
        return Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Zoho-oauthtoken ' . Cache::get('token')
        ])->get(RequestConstants::ACCOUNT_LINK . '?fields=Account_Name');
    }

    public function createAccount(AccountDTO $account)
    {
        $data = $this->createAccountData($account);
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Zoho-oauthtoken ' . Cache::get('token')
        ])->post(RequestConstants::ACCOUNT_LINK, $data);

        return $response;
    }

    public function createAccountData(AccountDTO $account): array
    {
        return [
            "data" => [
                [
                    "Layout" => [
                        "id" => RequestConstants::ACCOUNT_LAYOUT_ID
                    ],
                    "Account_Name" => $account->getAccountName(),
                    "Website" => $account->getWebsite(),
                    "Phone" => $account->getPhone()
                ]
            ]
        ];
    }

}
