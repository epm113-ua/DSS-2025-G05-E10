<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'NutriPlan') — NutriPlan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { background: #f0f7f2; min-height: 100vh; display: flex; flex-direction: column; }
        .auth-card { border: none; border-radius: 16px; box-shadow: 0 4px 24px rgba(0,0,0,.08); }
        .brand-color { color: #2e7d52; }
        .btn-primary { background: #2e7d52; border-color: #2e7d52; }
        .btn-primary:hover { background: #1e5e38; border-color: #1e5e38; }
        .form-control:focus { border-color: #2e7d52; box-shadow: 0 0 0 .2rem rgba(46,125,82,.25); }
    </style>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center" style="min-height:100vh">
        <div class="w-100" style="max-width:440px">
            <div class="text-center mb-4">
                <a href="{{ route('inicio') }}" class="text-decoration-none">
                    <h2 class="brand-color fw-bold"><i class="bi bi-flower1"></i> NutriPlan</h2>
                </a>
            </div>
            <div class="card auth-card p-4">
                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif
                @yield('content')
            </div>
            <p class="text-center text-muted small mt-3">
                &copy; {{ date('Y') }} NutriPlan. Todos los derechos reservados.
            </p>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
