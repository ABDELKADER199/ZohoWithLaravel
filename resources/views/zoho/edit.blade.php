<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Edit Contact</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body{font-family:system-ui,Arial;padding:20px}
        .alert{padding:10px;margin-bottom:10px;border-radius:6px}
        .error{background:#fdecea;border:1px solid #f5c2c0}
        input,button{padding:8px;border:1px solid #ccc;border-radius:6px}
        button{cursor:pointer}
        .row{display:grid;grid-template-columns:repeat(2,1fr);gap:16px}
        .card{border:1px solid #eee;border-radius:10px;padding:16px}
    </style>
</head>
<body>
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
                </ul>
                <span class="navbar-text">
                    مرحباً بك 👋
                </span>
            </div>
        </div>
    </nav>

    <div class="container">
        <h2 class="mb-4 fw-bold text-center text-primary">✏️ Edit Contact</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow-sm mx-auto" style="max-width:600px">
            <div class="card-header bg-primary text-white fw-bold">Contact Info</div>
            <div class="card-body">
                <form action="{{ route('zoho.update', $contact['id']) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">First Name</label>
                            <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $contact['First_Name'] ?? '') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Last Name <span class="text-danger">*</span></label>
                            <input type="text" name="last_name" class="form-control" required value="{{ old('last_name', $contact['Last_Name'] ?? '') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $contact['Email'] ?? '') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone', $contact['Phone'] ?? '') }}">
                        </div>
                    </div>
                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a href="{{ route('zoho.contacts') }}" class="btn btn-outline-secondary ms-2">Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endsection

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
</body>
</html>
