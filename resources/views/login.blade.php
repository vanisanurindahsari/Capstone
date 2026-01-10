<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .right-side {
            background: #2e7d32; /* hijau */
            border-bottom-left-radius: 120px;
            position: relative;
            overflow: hidden; /* 🔥 penting biar rapi */
        }

        .logo-wrapper {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 180px;
            height: 180px;
            border-radius: 50%;
            overflow: hidden; 
        }

        .logo-img {
            width: 100%;
            height: 100%;
            object-fit: cover;        
            transform: scale(1.3);    
        }
    </style>
</head>

<body>
    <div class="container-fluid vh-100">
        <div class="row h-100">

            <!-- LEFT SIDE -->
            <div class="col-md-6 d-flex justify-content-center align-items-center left-side p-5">
                <div style="width: 100%; max-width: 400px;">
                    <h2 class="mb-2 text-center">Welcome Back!</h2>
                    <p class="text-center mb-4">Sign in to your account to continue</p>

                    <form action="{{ route('login') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" id="email" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" id="password" required>
                        </div>

                        <button type="submit" class="btn btn-success w-100">Login</button>
                    </form>
                </div>
            </div>

            <!-- RIGHT SIDE WITH LOGO -->
            <div class="col-md-6 right-side d-none d-md-block">
                <div class="logo-wrapper">
                    <img src="{{ Vite::asset('resources/img/logo.jpg') }}" 
                         alt="Logo"
                         class="logo-img">
                </div>
            </div>

        </div>
    </div>
</body>
</html>
