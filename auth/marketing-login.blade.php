<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Marketing Login - CloseSense</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #6366f1;
            --secondary-color: #8b5cf6;
        }

        body {
            font-family: 'Inter', 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .brand-logo {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--primary-color);
            text-align: center;
            margin-bottom: 10px;
        }

        .login-subtitle {
            color: #6b7280;
            text-align: center;
            margin-bottom: 30px;
            font-size: 1.1rem;
        }

        .form-control {
            border-radius: 12px;
            padding: 12px 16px;
            border: 2px solid #e5e7eb;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        .btn-login {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            border-radius: 12px;
            padding: 12px;
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(99, 102, 241, 0.3);
        }

        .demo-credentials {
            background: #f8fafc;
            border-radius: 12px;
            padding: 20px;
            margin-top: 25px;
            border-left: 4px solid var(--primary-color);
        }

        .role-badge {
            background: var(--primary-color);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="login-container">
                    <!-- Header -->
                    <div class="text-center mb-4">
                        <div class="brand-logo">🎯 CloseSense</div>
                        <div class="login-subtitle">Marketing Team Portal</div>
                        <span class="role-badge">Role: Marketing Executive</span>
                    </div>

                    <!-- Login Form -->
                    <form method="POST" action="{{ route('marketing.login.submit') }}">
                        @csrf
                        
                        @if($errors->any())
                            <div class="alert alert-danger">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        @if(session('login_error'))
                            <div class="alert alert-danger">
                                {{ session('login_error') }}
                            </div>
                        @endif

                        <div class="mb-3">
                            <label class="form-label">Email Marketing</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                <input type="email" class="form-control" name="email" 
                                       value="{{ old('email') }}" 
                                       placeholder="marketing@studio.com" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input type="password" class="form-control" name="password" 
                                       placeholder="Enter your password" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-login w-100 mb-3">
                            <i class="fas fa-sign-in-alt me-2"></i>Login to Marketing Dashboard
                        </button>

                        <div class="text-center">
                            <a href="/" class="text-decoration-none">
                                <i class="fas fa-arrow-left me-1"></i>Back to Home
                            </a>
                        </div>
                    </form>

                    <!-- Demo Credentials -->
                    <div class="demo-credentials">
                        <h6 class="fw-bold mb-3">📋 Demo Marketing Accounts:</h6>
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-2">
                                    <small><strong>Email:</strong> marketing@closesense.com</small><br>
                                    <small><strong>Password:</strong> marketing123</small>
                                </div>
                                <div class="mb-2">
                                    <small><strong>Email:</strong> promo@studio.com</small><br>
                                    <small><strong>Password:</strong> promo123</small>
                                </div>
                                <div>
                                    <small><strong>Email:</strong> campaign@films.com</small><br>
                                    <small><strong>Password:</strong> campaign123</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>