<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Zoho Deals</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body{font-family:system-ui,Arial;padding:20px}
        table{width:100%;border-collapse:collapse;margin-top:16px}
        th,td{border:1px solid #ddd;padding:8px}
        th{background:#f4f4f4;text-align:left}
        .row{display:grid;grid-template-columns:repeat(2,1fr);gap:16px}
        .alert{padding:10px;margin-bottom:10px;border-radius:6px}
        .success{background:#e8f7ee;border:1px solid #b7e2c3}
        .error{background:#fdecea;border:1px solid #f5c2c0}
        form.inline{display:inline}
        input,button{padding:8px;border:1px solid #ccc;border-radius:6px}
        button{cursor:pointer}
        .card{border:1px solid #eee;border-radius:10px;padding:16px}
        .actions a, .actions button{margin-right:6px}
        .close-btn{background:transparent;border:none;float:right;font-size:16px;cursor:pointer;line-height:1}
    </style>
</head>
<body>
    <h1>Zoho Deals</h1>

    @if(session('success')) <div class="alert success">
        {{ session('success') }}
        <button class="close-btn" onclick="this.parentElement.style.display='none'">×</button>
    </div> @endif
    @if(session('error'))   <div class="alert error">
        {{ session('error') }}
        <button class="close-btn" onclick="this.parentElement.style.display='none'">×</button>
    </div>   @endif
    @if ($errors->any())
        <div class="alert error">
            <ul style="margin:0;padding-left:16px">
                @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <h3>Create new deal</h3>
        <form action="{{ route('deals.store') }}" method="POST">
            @csrf
            <div class="row">
                <div>
                    <label>Deal Name <span style="color:#c00">*</span></label><br>
                    <input type="text" name="deal_name" value="{{ old('deal_name') }}" required>
                </div>
                <div>
                    <label>Amount</label><br>
                    <input type="text" name="amount" value="{{ old('amount') }}">
                </div>
                <div>
                    <label>Stage</label><br>
                    <input type="text" name="stage" value="{{ old('stage') }}">
                </div>
                <div>
                    <label>Closing Date</label><br>
                    <input type="date" name="closing_date" value="{{ old('closing_date') }}">
                </div>
            </div>
            <div style="margin-top:12px">
                <button type="submit">Create</button>
            </div>
        </form>
    </div>

    <h3 style="margin-top:24px">Deals</h3>
    <table>
        <thead>
        <tr>
            <th>Deal Name</th>
            <th>Amount</th>
            <th>Stage</th>
            <th>Closing Date</th>
            <th style="width:160px;text-align:center">Actions</th>
        </tr>
        </thead>
        <tbody>
        @forelse($deals as $deal)
            <tr>
                <td>{{ $deal['deal_name'] }}</td>
                <td>{{ $deal['amount'] }}</td>
                <td>{{ $deal['stage'] }}</td>
                <td>{{ $deal['closing_date'] }}</td>
                <td class="actions" style="text-align: center">
                    <a href="{{ route('deals.edit', $deal['id']) }}">Edit</a>
                    <form class="inline" action="{{ route('deals.destroy', $deal['id']) }}" method="POST" onsubmit="return confirm('Delete this deal?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5">No deals found.</td></tr>
        @endforelse
        </tbody>
    </table>
</body>
</html>
