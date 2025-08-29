<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DealController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // جلب كل ال Deals from Zoho
        $accessToken = session('zoho_access_token');

        if (!$accessToken) {
            return redirect()->route('zoho.auth')->with('error', 'Access token missing, please reconnect Zoho.');
        }

        $response = Http::withToken($accessToken)
            ->get(env('ZOHO_API_URL') . '/crm/v2/Deals');

        if ($response->successful()) {
            $deals = $response->json()['data'];
            $deals = collect($deals)->map(function ($deal) {
                return [
                    'id' => $deal['id'] ?? null,
                    'deal_name' => $deal['Deal_Name'] ?? 'N/A',
                    'amount' => $deal['Amount'] ?? '0',
                    'stage' => $deal['Stage'] ?? 'N/A',
                    'closing_date' => $deal['Closing_Date'] ?? '',
                    // أضف أي حقول أخرى تريد عرضها
                ];
            });

            return view('deals.index', compact('deals'));
        }



        return back()->with('error', 'Failed to fetch deals from Zoho.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // create a new deal
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // التحقق من البيانات مباشرة بدون إعادة تعيين $request
    $request->validate([
        'deal_name' => 'required|string|max:255',
        'amount' => 'required|numeric',
        'stage' => 'required|string|max:255',
        'closing_date' => 'required|date',
    ]);

    $accessToken = session('zoho_access_token');

    if (!$accessToken) {
        return redirect()->route('zoho.auth')
            ->with('error', 'Access token is missing, please reconnect Zoho.');
    }

    $response = Http::withToken($accessToken)
        ->post(env('ZOHO_API_URL') . '/crm/v2/Deals', [
            'data' => [[
                'Deal_Name'    => $request->input('deal_name'),
                'Amount'       => $request->input('amount'),
                'Stage'        => $request->input('stage'),
                'Closing_Date' => $request->input('closing_date'),
            ]]
        ]);

    if ($response->successful()) {
        return redirect()->route('deals.index')
            ->with('success', 'Deal created successfully in Zoho CRM.');
    }

    return back()->with('error', 'Failed to create deal in Zoho CRM. Please reconnect.');
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
        // edit a deal
        $accessToken = session('zoho_access_token');

        if (!$accessToken) {
            return redirect()->route('zoho.auth')
                ->with('error', 'Access token missing, please reconnect Zoho.');
        }

        try {
            $response = Http::withToken($accessToken)
                ->get(env('ZOHO_API_URL') . '/crm/v2/Deals/' . $id);

            if ($response->successful()) {
                $dealData = $response->json('data');
                $deal = is_array($dealData) && count($dealData) ? $dealData[0] : [];
                return view('deals.edit', compact('deal'));
            }

            return back()->with('error', 'Failed to fetch deal: ' . $response->body());
        } catch (\Exception $e) {
            return back()->with('error', 'Exception: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // تحديث صفقة
        $accessToken = session('zoho_access_token');

        if (!$accessToken) {
            return redirect()->route('zoho.auth')
                ->with('error', 'Access token missing, please reconnect Zoho.');
        }

        $request->validate([
            'deal_name' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'stage' => 'required|string|max:255',
            'closing_date' => 'required|date',
        ]);

        $response = Http::withToken($accessToken)
            ->put(env('ZOHO_API_URL') . '/crm/v2/Deals/' . $id, [
                'data' => [[
                    'Deal_Name'    => $request->input('deal_name'),
                    'Amount'       => $request->input('amount'),
                    'Stage'        => $request->input('stage'),
                    'Closing_Date' => $request->input('closing_date'),
                ]]
            ]);

        if ($response->successful()) {
            return redirect()->route('deals.index')
                ->with('success', 'Deal updated successfully in Zoho CRM.');
        }

        return back()->with('error', 'Failed to update deal in Zoho CRM. Please reconnect.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // delete a deal
        $accessToken = session('zoho_access_token');

        if (!$accessToken) {
            return redirect()->route('zoho.auth')
                ->with('error', 'Access token missing, please reconnect Zoho.');
        }

        $response = Http::withToken($accessToken)
            ->delete(env('ZOHO_API_URL') . '/crm/v2/Deals/' . $id);

        if ($response->successful()) {
            return redirect()->route('deals.index')
                ->with('success', 'Deal deleted successfully in Zoho CRM.');
        }

        return back()->with('error', 'Failed to delete deal in Zoho CRM. Please reconnect.');
    }
}
