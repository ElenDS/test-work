<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\DTO\DealDTO;
use App\Services\ZohoRequestService\RequestSender;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\View\View;

class DealController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function showDealForm(RequestSender $requestSender): view
    {
        $response = $requestSender->getAccounts();
        if(!isset($response['data'])) {
            $accounts = ['no accounts'];
        } else {
            $accounts = array_reduce($response['data'], function ($resArray, $account) {
                $resArray[] = $account['Account_Name'];
                return $resArray;
            }, []);
        }

        return view('deals', ['accounts' => $accounts]);
    }

    public function createDeal(Request $request, RequestSender $requestSender)
    {
        $deal = new DealDTO();
        $deal->setDealName($request->name);
        $deal->setDealStage($request->stage);
        $deal->setClosingDate($request->closingDate);
        $deal->setAccountName($request->accountName);

        $response = $requestSender->createDeal($deal);

        if ($response->successful()) {
            return response([
                'success' => true,
                'message' => 'Deal successfully added'
            ]);
        } else {
            return response([
                'success' => false,
                'message' => $response['message']
            ]);
        }
    }

}
