<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Session;
use zcrmsdk\crm\setup\restclient\ZCRMRestClient;

class ZohoController extends Controller
{
    public function redirectToZoho()
    {
        $zohoAccountsUrl = env('ZOHO_ACCOUNTS_URL', 'https://accounts.zoho.com');
        $url = $zohoAccountsUrl . '/oauth/v2/auth?' . http_build_query([
            'client_id' => env('ZOHO_CLIENT_ID'),
            'redirect_uri' => env('ZOHO_REDIRECT_URI'),
            'response_type' => 'code',
            'scope' => 'ZohoCRM.modules.all,ZohoCRM.settings.all',
            'access_type' => 'offline',
            'prompt' => 'consent'
        ]);

        return redirect($url);
    }


    public function handleZohoCallback(Request $request)
    {
        // Handle Zoho OAuth callback
        $code = $request->input('code');

        // Exchange code for access token
        $tokenUrl = env('ZOHO_ACCOUNTS_URL') . '/oauth/v2/token';
        $response = Http::asForm()->post($tokenUrl, [
            'grant_type' => 'authorization_code',
            'client_id' => env('ZOHO_CLIENT_ID'),
            'client_secret' => env('ZOHO_CLIENT_SECRET'),
            'redirect_uri' => env('ZOHO_REDIRECT_URI'),
            'code' => $code
        ]);

        $accessToken = $response->json('access_token');

        // Store access token in session or database
        session(['zoho_access_token' => $accessToken]);
        Session::put('zoho_access_token', $accessToken);
        Session::put('zoho_refresh_token', $response->json('refresh_token'));

        return redirect()->route('dashboard');
    }

    public function getZohoContacts()
    {
        $accessToken = session('zoho_access_token');

        if (!$accessToken) {
            return redirect()->route('zoho.auth')
                ->with('error', 'Access token is missing, please reconnect Zoho.');
        }

        $response = Http::withToken($accessToken)
            ->get(env('ZOHO_API_URL') . '/crm/v2/Contacts');

        if ($response->successful()) {
            $contacts = $response->json('data');
            return view('zoho.contacts', compact('contacts'));
        }

        // لو فيه مشكلة مع التوكين
        return back()->with('error', 'Failed to fetch Zoho contacts. Please reconnect.');
    }

    public function createZohoContact(Request $request)
    {
        $accessToken = session('zoho_access_token');

        if (!$accessToken) {
            return redirect()->route('zoho.auth')
                ->with('error', 'Access token is missing, please reconnect Zoho.');
        }

        $response = Http::withToken($accessToken)
            ->post(env('ZOHO_API_URL') . '/crm/v2/Contacts', [
                'data' => [
                    [
                        'Last_Name' => $request->input('last_name'),
                        'First_Name' => $request->input('first_name'),
                        'Email' => $request->input('email'),
                        'Phone' => $request->input('phone'),
                    ]
                ]
            ]);

        if ($response->successful()) {
            return redirect()->route('zoho.contacts')
                ->with('success', 'Contact created successfully in Zoho CRM.');
        }

        // لو فيه مشكلة مع التوكين
        return back()->with('error', 'Failed to create contact in Zoho CRM. Please reconnect.');
    }

    public function editZohoContact($id)
    {
        $accessToken = session('zoho_access_token');

        if (!$accessToken) {
            return redirect()->route('zoho.auth')
                ->with('error', 'Access token is missing, please reconnect Zoho.');
        }

        $response = Http::withToken($accessToken)
            ->get(env('ZOHO_API_URL') . '/crm/v2/Contacts/' . $id);

        if ($response->successful()) {
            $contact = $response->json('data')[0];
            return view('zoho.edit', compact('contact'));
        }

        // لو فيه مشكلة مع التوكين
        return back()->with('error', 'Failed to fetch contact details from Zoho CRM. Please reconnect.');
    }

    public function updateZohoContact(Request $request, $id)
    {
        $accessToken = session('zoho_access_token');

        if (!$accessToken) {
            return redirect()->route('zoho.auth')
                ->with('error', 'Access token is missing, please reconnect Zoho.');
        }

        $response = Http::withToken($accessToken)
            ->put(env('ZOHO_API_URL') . '/crm/v2/Contacts/' . $id, [
                'data' => [
                    [
                        'Last_Name' => $request->input('last_name'),
                        'First_Name' => $request->input('first_name'),
                        'Email' => $request->input('email'),
                        'Phone' => $request->input('phone'),
                    ]
                ]
            ]);

        if ($response->successful()) {
            return redirect()->route('zoho.contacts')
                ->with('success', 'Contact updated successfully in Zoho CRM.');
        }

        // لو فيه مشكلة مع التوكين
        return back()->with('error', 'Failed to update contact in Zoho CRM. Please reconnect.');
    }

    public function deleteZohoContact($id)
    {
        $accessToken = session('zoho_access_token');

        if (!$accessToken) {
            return redirect()->route('zoho.auth')
                ->with('error', 'Access token is missing, please reconnect Zoho.');
        }

        $response = Http::withToken($accessToken)
            ->delete(env('ZOHO_API_URL') . '/crm/v2/Contacts/' . $id);

        if ($response->successful()) {
            return redirect()->route('zoho.contacts')
                ->with('success', 'Contact deleted successfully from Zoho CRM.');
        }

        // لو فيه مشكلة مع التوكين
        return back()->with('error', 'Failed to delete contact from Zoho CRM. Please reconnect.');
    }
}
