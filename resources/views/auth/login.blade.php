<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SkyVera Cashflow</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        .login-card {
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.01);
            width: 100%;
            max-width: 420px;
            padding: 40px;
            border: 1px solid #f1f5f9;
        }

        .brand-icon {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            width: 56px; height: 56px;
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            color: white; font-size: 1.5rem;
            box-shadow: 0 4px 14px rgba(59, 130, 246, 0.4);
            margin: 0 auto 20px;
        }

        .form-control {
            border-radius: 12px;
            padding: 12px 16px;
            border: 1.5px solid #e2e8f0;
            font-size: 0.95rem;
        }

        .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            border: none;
            color: white;
            border-radius: 12px;
            padding: 12px;
            font-weight: 600;
            transition: all 0.2s;
            width: 100%;
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(59, 130, 246, 0.3);
            color: white;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="text-center mb-4">
            <div class="brand-icon">
                <i class="bi bi-wallet2"></i>
            </div>
            <h4 class="fw-bold" style="color: #0f172a; letter-spacing: -0.5px; margin-bottom: 4px;">SkyVera</h4>
            <div style="font-size: 0.85rem; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 1px;">Cashflow System</div>
        </div>

        @if($errors->any())
            <div class="alert alert-danger" style="border-radius: 12px; font-size: 0.85rem; border: none; background-color: #fef2f2; color: #ef4444;">
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-semibold" style="font-size: 0.85rem; color: #475569;">Alamat Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus placeholder="admin@skyvera.com">
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold" style="font-size: 0.85rem; color: #475569;">Kata Sandi</label>
                <input type="password" name="password" class="form-control" required placeholder="••••••••">
            </div>
            <div class="mb-4 form-check">
                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                <label class="form-check-label" for="remember" style="font-size: 0.85rem; color: #64748b;">Ingat Saya</label>
            </div>
            <button type="submit" class="btn btn-primary-custom">
                Masuk ke Dashboard
            </button>
        </form>
        <div class="text-center mt-4" style="font-size: 0.75rem; color: #94a3b8;">
            &copy; {{ date('Y') }} SkyVera Cashflow. All rights reserved.
        </div>
    </div>
</body>
</html>

