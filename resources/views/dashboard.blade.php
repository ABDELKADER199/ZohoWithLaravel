@extends('layouts.app')

@section('content')
<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="#">Zoho CRM</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#zohoNavbar" aria-controls="zohoNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="zohoNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('zoho.contacts') }}">Contacts</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('leads.index') }}">Leads</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('deals.index') }}">Deals</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('accounts.index') }}">Accounts</a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link" href="{{ route('tasks.index') }}">Tasks</a>
                </li> --}}
            </ul>
            <span class="navbar-text">
                مرحباً بك 👋
            </span>
        </div>
    </div>
</nav>

<div class="container">
    <h2 class="mb-4 fw-bold text-center text-primary">📊 Zoho Dashboard</h2>
    <div class="row g-4 justify-content-center">
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h4 class="card-title text-secondary">إجمالي جهات الاتصال</h4>
                    <p class="fs-2 text-primary fw-bold">{{ $contactsCount }}</p>
                    <a href="{{ route('zoho.contacts') }}" class="btn btn-outline-primary w-100 mt-2">
                        📱 عرض قائمة الـ Contacts
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h4 class="card-title text-secondary">إجمالي العملاء المحتملين</h4>
                    <p class="fs-2 text-success fw-bold">{{ $leadsCount }}</p>
                    <a href="{{ route('leads.index') }}" class="btn btn-outline-success w-100 mt-2">
                        👥 عرض قائمة الـ Leads
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h4 class="card-title text-secondary">إجمالي الصفقات</h4>
                    <p class="fs-2 text-danger fw-bold">{{ $dealsCount }}</p>
                    <a href="{{ route('deals.index') }}" class="btn btn-outline-danger w-100 mt-2">
                        💼 عرض قائمة الـ Deals
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h4 class="card-title text-secondary">إجمالي الحسابات</h4>
                    <p class="fs-2 text-warning fw-bold">{{ $accountsCount }}</p>
                    <a href="{{ route('accounts.index') }}" class="btn btn-outline-warning w-100 mt-2">
                        🏢 عرض قائمة الـ Accounts
                    </a>
                </div>
            </div>
        </div>
        {{-- يمكنك إضافة قسم المهام لاحقاً بنفس التنسيق --}}
    </div>
</div>
@endsection
