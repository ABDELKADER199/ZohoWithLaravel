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
                    <a class="nav-link active" href="{{ route('zoho.contacts') }}">Contacts</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('leads.index') }}">Leads</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('deals.index') }}">Deals</a>
                </li>
            </ul>
            <span class="navbar-text">
                مرحباً بك 👋
            </span>
        </div>
    </div>
</nav>

<div class="container">
    <h2 class="mb-4 fw-bold text-center text-primary">📱 Zoho Contacts</h2>

    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
    @if(session('error'))   <div class="alert alert-danger">{{ session('error') }}</div>   @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white fw-bold">Create New Contact</div>
        <div class="card-body">
            <form action="{{ route('zoho.contacts.create') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">First Name</label>
                        <input type="text" name="first_name" class="form-control" value="{{ old('first_name') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Last Name <span class="text-danger">*</span></label>
                        <input type="text" name="last_name" class="form-control" value="{{ old('last_name') }}" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                    </div>
                </div>
                <div class="mt-3 text-end">
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-secondary text-white fw-bold">Contacts List</div>
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead class="table-light">
                <tr>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th style="width:160px">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($contacts as $c)
                    <tr>
                        <td>{{ $c['Full_Name'] ?? ($c['First_Name'] ?? '') . ' ' . ($c['Last_Name'] ?? '') }}</td>
                        <td>{{ $c['Email'] ?? '' }}</td>
                        <td>{{ $c['Phone'] ?? '' }}</td>
                        <td>
                            <a href="{{ route('zoho.edit', $c['id']) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            <form class="d-inline" action="{{ route('zoho.delete', $c['id']) }}" method="POST" onsubmit="return confirm('Delete this contact?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center">No contacts found.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
