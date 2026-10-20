<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; }
        h1 { font-size: 18px; margin-bottom: 6px; }
        p.subtitle { font-size: 10px; color: #666; margin-bottom: 14px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
        th { background: #f0f0f0; font-weight: bold; }
        tr:nth-child(even) { background: #f9f9f9; }
    </style>
</head>
<body>
    <h1>{{ $title }}</h1>
    <p class="subtitle">Generado el {{ now()->format('d/m/Y H:i') }}</p>
    <table>
        <thead>
            <tr>
                @foreach($headings as $h)
                    <th>{{ $h }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
                <tr>
                    @foreach($fields as $f)
                        <td>{{ data_get($item, $f) }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>