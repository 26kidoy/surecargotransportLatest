<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Set up MFA | SureCargo Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style nonce="{{ $csp_nonce }}">
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
             background: linear-gradient(135deg, white, #fd0325 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            padding: 2rem;
        }


        @keyframes floatSlow {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(4%, 6%) scale(1.08); }
        }

        @keyframes floatReverse {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(-5%, -4%) scale(1.12); }
        }

        /* Main card */
        .setup-card {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(2px);
            border-radius: 56px;
            box-shadow: 0 35px 65px -20px rgba(0, 0, 0, 0.22), 0 0 0 1px rgba(13,110,253,0.08);
            transition: all 0.4s ease;
            animation: cardRise 0.7s cubic-bezier(0.2, 0.9, 0.4, 1.2) forwards;
            position: relative;
            z-index: 10;
        }

        @keyframes cardRise {
            from { opacity: 0; transform: translateY(40px) scale(0.98); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        .setup-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 45px 75px -18px rgba(0, 0, 0, 0.28);
        }

        /* Global font sizing – minimum 1.5rem */
        .setup-card,
        .setup-card .form-label,
        .setup-card .form-control,
        .setup-card .btn,
        .setup-card .alert,
        .setup-card p,
        .setup-card .text-secondary,
        .setup-card .recovery-box,
        .setup-card small:not(.text-muted) {
            font-size: 1.5rem;
            font-weight: 550;
            letter-spacing: -0.01em;
        }

        /* Headings */
        h2.fw-bold {
            font-size: 3rem !important;
            font-weight: 800 !important;
        }

        /* Smaller helper texts */
        .setup-card .small,
        .setup-card .text-muted {
            font-size: 1.25rem !important;
            font-weight: 500;
        }

        /* Gradient text */
        .gradient-text {
            background: linear-gradient(125deg, #0d6efd, #198754);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            font-weight: 800;
        }

        /* Form controls */
        .form-control {
            background: #ffffff;
            border: 2px solid #e2e8f0;
            border-radius: 48px;
            padding: 1rem 1.8rem;
            font-size: 1.5rem;
            color: #0f172a;
            transition: all 0.25s ease;
            text-align: center;
        }

        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 5px rgba(13,110,253,0.2);
            transform: scale(1.01);
            outline: none;
        }

        /* Buttons */
        .btn-primary-custom {
            background: linear-gradient(105deg, #0d6efd, #0b5ed7, #198754);
            background-size: 180% auto;
            border: none;
            padding: 1rem 1.8rem;
            border-radius: 80px;
            font-weight: 700;
            font-size: 1.6rem;
            transition: all 0.35s ease;
            box-shadow: 0 12px 28px -10px rgba(13,110,253,0.4);
            color: white;
        }

        .btn-primary-custom:hover {
            background: linear-gradient(105deg, #0b5ed7, #198754, #0d6efd);
            transform: translateY(-3px);
            box-shadow: 0 18px 32px -12px rgba(13,110,253,0.55);
        }

        .btn-outline-secondary {
            border-radius: 80px;
            padding: 0.8rem 1.5rem;
            font-size: 1.5rem;
            font-weight: 600;
            border-width: 2px;
        }

        /* Alerts */
        .alert {
            border-radius: 48px;
            border: none;
            font-weight: 600;
            padding: 1rem 1.75rem;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
            border-left: 8px solid #22c55e;
        }

        .alert-warning {
            background: #fffbeb;
            color: #92400e;
            border-left: 8px solid #f59e0b;
            border-radius: 32px;
        }

        /* Recovery codes box */
        .recovery-box {
            background: #f8fafc;
            border-radius: 32px;
            border: 1px solid #e2e8f0;
            font-size: 1.4rem;
            transition: all 0.2s;
        }

        .recovery-box code {
            font-size: 1.35rem;
            background: #eef2ff;
            padding: 0.3rem 0.6rem;
            border-radius: 20px;
            font-weight: 600;
            color: #0d6efd;
        }

        .qr-container {
            background: white;
            padding: 1rem;
            display: inline-block;
            border-radius: 28px;
            box-shadow: 0 15px 30px -12px rgba(0,0,0,0.1);
        }

        .qr-container img {
            max-width: 220px;
            height: auto;
            border-radius: 20px;
        }

        hr {
            margin: 2rem 0;
            opacity: 0.4;
        }

        @media (max-width: 768px) {
            body { padding: 1rem; }
            .setup-card,
            .setup-card .form-label,
            .setup-card .form-control,
            .setup-card .btn,
            .setup-card .alert {
                font-size: 1.35rem;
            }
            h2.fw-bold { font-size: 2.4rem !important; }
            .btn-primary-custom { font-size: 1.4rem; }
            .qr-container img { max-width: 160px; }
            .recovery-box code { font-size: 1.2rem; }
        }
    </style>
</head>
<body>
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-7">
                <div class="setup-card p-4 p-md-5 p-xl-5">
                    <div class="text-center mb-5">
                        <i class="fas fa-qrcode fa-4x gradient-text"></i>
                        <h2 class="fw-bold gradient-text mt-3">Secure Your Admin Account</h2>
                        <p class="text-secondary mt-2">Scan the QR code with Google Authenticator or any TOTP app</p>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success mb-4">
                            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        </div>
                    @endif

                    <div class="text-center mb-5">
                        <div class="qr-container">
                            {!! $qrCode !!}
                        </div>
                        <p class="mt-3 text-muted small-text">Or manually enter the secret key:</p>
                        <code class="bg-light px-3 py-2 rounded d-inline-block" style="font-size:1.4rem; font-weight:600;">{{ $secret }}</code>
                    </div>

                    <div class="alert alert-warning mb-4">
                        <i class="fas fa-exclamation-triangle me-2 fa-lg"></i>
                        <strong>Store these recovery codes safely!</strong> They will not be shown again.
                    </div>

                    <div class="recovery-box p-4 mb-4">
                        <h6 class="fw-bold mb-3" style="font-size:1.6rem;"><i class="fas fa-key me-2"></i> One‑time recovery codes</h6>
                        <div class="row">
                            @foreach($recoveryCodes as $code)
                                <div class="col-6 mb-3"><code>{{ $code }}</code></div>
                            @endforeach
                        </div>
                        <button class="btn btn-outline-secondary mt-2" id="copyCodesBtn">
                            <i class="far fa-copy me-2"></i> Copy codes
                        </button>
                    </div>

                    <form method="POST" action="{{ route('admin.mfa.enable') }}" id="mfaEnableForm">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label fw-bold">Enter code from authenticator app to verify</label>
                            <input type="text" name="verify_code" class="form-control text-center" placeholder="000000" maxlength="6" required pattern="[0-9]{6}" inputmode="numeric">
                        </div>
                        <button type="submit" class="btn btn-primary-custom text-white w-100">
                            <i class="fas fa-check-circle me-2"></i> Enable MFA & Continue
                        </button>
                    </form>

                    <div class="text-center mt-5">
                        <small class="text-secondary small-text">
                            <i class="fas fa-exclamation-triangle me-1"></i> If you lose your device, recovery codes are the only way to regain access.
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

   <script nonce="{{ $csp_nonce }}">
        document.getElementById('copyCodesBtn')?.addEventListener('click', function() {
            let codes = [];
            document.querySelectorAll('.recovery-box code').forEach(el => codes.push(el.innerText));
            navigator.clipboard.writeText(codes.join('\n')).then(() => {
                // Optional: show a temporary toast/alert
                alert('Recovery codes copied to clipboard!');
            }).catch(() => {
                alert('Unable to copy. Please copy them manually.');
            });
        });
    </script>
</body>
</html>
