<?php

namespace App\Http\Controllers;

use Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Https;

class AccountsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all accounts from Zoho
        $accessToken = session('zoho_access_token');
        if(!$accessToken) {
            return redirect()->route('zoho.auth')->with('error', 'Access token missing, please reconnect Zoho.');
        }

        $response = Http::withToken($accessToken)
        ->get(env('ZOHO_API_URL') . '/crm/v2/Accounts');

        if ($response->successful()) {
            $accounts = $response->json()['data'];
            $accounts = collect($accounts)->map(function ($account) {
                return [
                    'id' => $account['id'] ?? null,
                    'account_name' => $account['Account_Name'] ?? 'N/A',
                    'email' => $account['Email'] ?? 'N/A',
                    'phone' => $account['Phone'] ?? 'N/A',
                    'website' => $account['Website'] ?? 'N/A',
                ];
            });
            return view('Accounts.index', compact('accounts'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
