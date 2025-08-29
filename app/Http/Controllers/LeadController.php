<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LeadController extends Controller
{
    public function index()
    {
        $accessToken = session('zoho_access_token');

        if (!$accessToken) {
            return redirect()->route('zoho.auth')
                ->with('error', 'Access token missing, please reconnect Zoho.');
        }

        try {
            $response = Http::withToken($accessToken)
                ->get(env('ZOHO_API_URL') . '/crm/v2/Leads');

            if ($response->successful()) {
                $data = $response->json('data') ?? [];

                $leads = collect($data)->map(function ($lead) {
                    return [
                        'id'    => $lead['id'] ?? null,
                        'name'  => ($lead['Full_Name'] ?? ($lead['First_Name'] ?? '') . ' ' . ($lead['Last_Name'] ?? '')),
                        'email' => $lead['Email'] ?? '',
                        'phone' => $lead['Phone'] ?? '',
                    ];
                });

                return view('leads.index', compact('leads'));
            }

            return back()->with('error', 'Failed to fetch leads: ' . $response->body());
        } catch (\Exception $e) {
            return back()->with('error', 'Exception: ' . $e->getMessage());
        }
    }

    // 📌 فورم إضافة Lead
    public function create() {}

    // 📌 تنفيذ الحفظ في Zoho CRM
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'nullable|string|max:100',
            'last_name'  => 'required|string|max:100',
            'email'      => 'nullable|email',
            'phone'      => 'nullable|string|max:20',
        ]);

        $accessToken = session('zoho_access_token');

        if (!$accessToken) {
            return redirect()->route('zoho.auth')
                ->with('error', 'Access token is missing, please reconnect Zoho.');
        }

        $response = Http::withToken($accessToken)
            ->post(env('ZOHO_API_URL') . '/crm/v2/Leads', [
                'data' => [[
                    'Last_Name'  => $request->input('last_name'),
                    'First_Name' => $request->input('first_name'),
                    'Email'      => $request->input('email'),
                    'Phone'      => $request->input('phone'),
                ]]
            ]);

        if ($response->successful()) {
            return redirect()->route('leads.index')
                ->with('success', 'Lead created successfully in Zoho CRM.');
        }

        return back()->with('error', 'Failed to create lead in Zoho CRM. Please reconnect.');
    }

    public function edit($id)
    {
        // Logic to show the edit form for a lead
        $accessToken = session('zoho_access_token');

        if (!$accessToken) {
            return redirect()->route('zoho.auth')
                ->with('error', 'Access token missing, please reconnect Zoho.');
        }

        try {
            $response = Http::withToken($accessToken)
                ->get(env('ZOHO_API_URL') . '/crm/v2/Leads/' . $id);

            if ($response->successful()) {
                $leadData = $response->json('data');
                if (!empty($leadData)) {
                    $lead = $leadData[0]; // خد أول عنصر من الـ array
                    return view('leads.edit', compact('lead'));
                }

                return back()->with('error', 'No lead data found.');
            }

            return back()->with('error', 'Failed to fetch lead: ' . $response->body());
        } catch (\Exception $e) {
            return back()->with('error', 'Exception: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        // Logic to update a lead in Zoho CRM
        $request->validate([
            'first_name' => 'nullable|string|max:100',
            'last_name'  => 'required|string|max:100',
            'email'      => 'nullable|email',
            'phone'      => 'nullable|string|max:20',
        ]);

        $accessToken = session('zoho_access_token');

        if (!$accessToken) {
            return redirect()->route('zoho.auth')
                ->with('error', 'Access token is missing, please reconnect Zoho.');
        }

        $response = Http::withToken($accessToken)
            ->put(env('ZOHO_API_URL') . '/crm/v2/Leads/' . $id, [
                'data' => [[
                    'Last_Name'  => $request->input('last_name'),
                    'First_Name' => $request->input('first_name'),
                    'Email'      => $request->input('email'),
                    'Phone'      => $request->input('phone'),
                ]]
            ]);

        if ($response->successful()) {
            return redirect()->route('leads.index')
                ->with('success', 'Lead updated successfully in Zoho CRM.');
        }

        return back()->with('error', 'Failed to update lead in Zoho CRM. Please reconnect.');
    }

    public function destroy($id)
    {
        // Logic to delete a lead from Zoho CRM
        $accessToken = session('zoho_access_token');

        if (!$accessToken) {
            return redirect()->route('zoho.auth')
                ->with('error', 'Access token is missing, please reconnect Zoho.');
        }

        $response = Http::withToken($accessToken)
            ->delete(env('ZOHO_API_URL') . '/crm/v2/Leads/' . $id);

        if ($response->successful()) {
            return redirect()->route('leads.index')
                ->with('success', 'Lead deleted successfully from Zoho CRM.');
        }

        return back()->with('error', 'Failed to delete lead from Zoho CRM. Please reconnect.');
    }
}
