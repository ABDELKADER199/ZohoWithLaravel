<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\ZohoController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\DealController;

Route::get('/', [dashboardController::class, 'index'])->name('dashboard');

Route::get('/zoho/auth', [ZohoController::class, 'redirectToZoho'])->name('zoho.auth');
Route::get('/zoho/callback', [ZohoController::class, 'handleZohoCallback'])->name('zoho.callback');
Route::get('/zoho/contacts', [ZohoController::class, 'getZohoContacts'])->name('zoho.contacts');
Route::post('/zoho/contacts', [ZohoController::class, 'createZohoContact'])->name('zoho.contacts.create');

Route::get('/zoho/{id}/edit', [ZohoController::class, 'editZohoContact'])->name('zoho.edit');
Route::put('/zoho/{id}', [ZohoController::class, 'updateZohoContact'])->name('zoho.update');
Route::delete('/zoho/{id}', [ZohoController::class, 'deleteZohoContact'])->name('zoho.delete');
Route::resource('leads', LeadController::class)->names([
    'index' => 'leads.index',
    'store' => 'leads.store',
    'show' => 'leads.show',
    'edit' => 'leads.edit',
    'update' => 'leads.update',
    'destroy' => 'leads.destroy',
]);
Route::resource('deals', DealController::class)->names([
    'index' => 'deals.index',
    'store' => 'deals.store',
    'show' => 'deals.show',
    'edit' => 'deals.edit',
    'update' => 'deals.update',
    'destroy' => 'deals.destroy',
]);
