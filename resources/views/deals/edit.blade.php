@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Deal</h1>
    <form action="{{ route('deals.update', $deal['id']) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Deal Name</label>
            <input type="text" class="form-control" id="name" name="deal_name" value="{{ old('deal_name', $deal['Deal_Name'] ?? '') }}" required>
        </div>
        <div class="mb-3">
            <label for="amount" class="form-label">Amount</label>
            <input type="number" class="form-control" id="amount" name="amount" value="{{ old('amount', $deal['Amount'] ?? '') }}" required>
        </div>
        <div class="mb-3">
            <label for="stage" class="form-label">Stage</label>
            <input type="text" class="form-control" id="stage" name="stage" value="{{ old('stage', $deal['Stage'] ?? '') }}">
        </div>
        <div class="mb-3">
            <label for="closing_date" class="form-label">Closing Date</label>
            <input type="date" class="form-control" id="closing_date" name="closing_date" value="{{ old('closing_date', isset($deal['Closing_Date']) ? \Carbon\Carbon::parse($deal['Closing_Date'])->format('Y-m-d') : '') }}">
        </div>
        <button type="submit" class="btn btn-primary">Update Deal</button>
    </form>
</div>
@endsection
