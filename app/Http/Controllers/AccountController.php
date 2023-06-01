<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\DTO\AccountDTO;
use App\Services\ZohoRequestService\RequestSender;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\View\View;

class AccountController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function showAccountForm(RequestSender $requestSender): view
    {
        return view('accounts');
    }

    public function createAccount(Request $request, RequestSender $requestSender)
    {
        $account = new AccountDTO();
        $account->setAccountName($request->name);
        $account->setWebsite($request->website);
        $account->setPhone($request->phone);

        $response = $requestSender->createAccount($account);

        if ($response->successful()) {
            return response([
                'success' => true,
                'message' => 'Account successfully added'
            ]);
        } else {
            return response([
                'success' => false,
                'message' => $response['message']
            ]);
        }
    }

}
