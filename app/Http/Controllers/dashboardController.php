<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class dashboardController extends Controller
{
    //
    public function index()
    {
        $accessToken = session('zoho_access_token');

        if (!$accessToken) {
            return redirect()->route('zoho.auth')
                ->with('error', 'Access token is missing, please reconnect Zoho.');
        }

        // Get Contacts Count

        $zohoApiUrl = env('ZOHO_API_URL', 'https://www.zohoapis.com');
        $contactsResponse = Http::withToken($accessToken)
            ->get($zohoApiUrl . '/crm/v2/Contacts');

        $contactsCount = 0;

        if ($contactsResponse->successful()) {
            $contacts = $contactsResponse->json('data');
            $contactsCount = count($contacts);
        }

        // Get Leads Count

        $leadsResponse = Http::withToken($accessToken)
            ->get(env('ZOHO_API_URL') . '/crm/v2/Leads');

        $leadsCount = 0;

        if ($leadsResponse->successful()) {
            $leads = $leadsResponse->json('data');
            $leadsCount = count($leads);
        }

        // Get Deals Count

        $dealsResponse = Http::withToken($accessToken)
            ->get(env('ZOHO_API_URL') . '/crm/v2/Deals');

        $dealsCount = 0;

        if ($dealsResponse->successful()) {
            $deals = $dealsResponse->json('data');
            $dealsCount = count($deals);
        }

        // Get Tasks Count

        $tasksResponse = Http::withToken($accessToken)
            ->get(env('ZOHO_API_URL') . '/crm/v2/Tasks');

        $tasksCount = 0;

        if ($tasksResponse->successful()) {
            $tasks = $tasksResponse->json('data');
            $tasksCount = count($tasks);
        }

        // Get Accounts Count
        $accountsResponse = Http::withToken($accessToken)
            ->get(env('ZOHO_API_URL') . '/crm/v2/Accounts');

        $accountsCount = 0;

        if ($accountsResponse->successful()) {
            $accounts = $accountsResponse->json('data');
            $accountsCount = count($accounts);
        }

        return view('dashboard', compact('contactsCount', 'leadsCount', 'dealsCount', 'tasksCount', 'accountsCount'));
    }


}
