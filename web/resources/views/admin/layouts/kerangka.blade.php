@use('App\Support\Aset')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('judul', 'Panel Admin') | Admin {{ $pengaturan['nama_singkat'] ?? config('app.name') }}</title>
    <link rel="stylesheet" href="{{ Aset::url('css/admin.css') }}">
    <script src="{{ Aset::url('js/admin.js') }}" defer></script>
</head>
<body class="bg-surface-container-low font-body-md text-body-md text-on-surface antialiased">
@yield('kerangka')
</body>
</html>
