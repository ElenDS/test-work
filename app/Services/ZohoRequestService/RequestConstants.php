<?php

declare(strict_types=1);

namespace App\Services\ZohoRequestService;
class RequestConstants
{
    public const REFRESH_LINK = 'https://accounts.zoho.eu/oauth/v2/token';
    public const DEAL_LINK = 'https://www.zohoapis.eu/crm/v3/Deals';
    public  const DEAL_LAYOUT_ID = '575323000000032043';
    public const ACCOUNT_LINK = 'https://www.zohoapis.eu/crm/v3/Accounts';
    public const ACCOUNT_LAYOUT_ID = '575323000000032035';
}
