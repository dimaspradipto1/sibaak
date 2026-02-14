<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login SIBAAK</title>
    <link rel="icon" href="{{ asset('assets/images/logouis.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            color: white;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-image: url('assets/images/gedunguis.JPG');
            /* Keep original background */
            background-size: cover;
            background-position: center;
            position: relative;
        }

        /* Darker overlay */
        body::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            /* Dark overlay */
        }

        .login-box {
            background: rgba(0, 0, 0, 0.5);
            /* Darker background for the form */
            padding: 40px;
            border-radius: 10px;
            width: 100%;
            max-width: 450px;
            text-align: center;
            position: relative;
            z-index: 1;
            /* Ensure form appears above overlay */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
        }

        .logo-container {
            position: absolute;
            top: 20px;
            left: 100px;
            z-index: 2;
            /* Ensure logo is on top */
        }

        .logo {
            width: 100px;
            /* Reduced logo size */
        }

        p.text-left {
            text-align: left;
            color: #FFF742;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 25px;
        }

        .input-field {
            width: 100%;
            padding: 14px;
            margin-bottom: 20px;
            background: #333;
            border: 1px solid #666;
            border-radius: 4px;
            color: white;
            font-size: 14px;
        }

        .password-container {
            position: relative;
            width: 100%;
        }

        .password-container .toggle-password {
            position: absolute;
            right: 14px;
            top: 14px;
            cursor: pointer;
            color: #ccc;
            z-index: 10;
        }

        .password-container .input-field {
            padding-right: 40px;
        }

        .submit-btn {
            width: 100%;
            padding: 14px;
            background: #087C39;
            /* Green color for the button */
            border: none;
            border-radius: 4px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .submit-btn:hover {
            background: #FFF742;
            /* Yellow color on hover */
        }

        .alternative-actions p,
        .remember-me,
        .new-to-baak p {
            text-align: left;
            margin-bottom: 10px;
        }

        .alternative-actions p a,
        .new-to-baak a {
            color: #007bff;
            text-decoration: none;
        }

        .alternative-actions p a:hover,
        .new-to-baak a:hover {
            text-decoration: underline;
        }

        .remember-me {
            color: #888;
        }

        .new-to-baak p {
            color: #888;
            margin-top: 20px;
        }

        footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            height: 94px;
            padding: 20px 0;
            background: linear-gradient(45deg, #087C39, #FFF742);
            /* Green to yellow gradient */
            text-align: center;
            font-size: 12px;
            color: white;
            z-index: 10;
            /* Ensure footer is on top of other content */
        }

        footer a {
            color: #087C39;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }

        /* Mengatur posisi logo untuk tampilan mobile */
        @media (max-width: 768px) {
            .logo-container {
                position: absolute;
                top: 10%;
                left: 50%;
                transform: translateX(-50%);
                z-index: 2;
            }

            .logo {
                width: 80px;
                /* Ukuran logo lebih kecil pada mobile */
            }


        }
    </style>
</head>

<body>
    <div class="logo-container">
        <img src="{{ asset('assets/images/logouis.png') }}" alt="Logo" class="logo">
        <!-- Replace with actual logo path -->
    </div>

    <div class="login-box">
        <form class="login-form" action="{{ route('loginproses') }}" method="post">
            @csrf

            <p class="text-left">MYBAAK</p>
            <input type="email" name="email" placeholder="Email atau nomor ponsel" class="input-field" required>
            <div class="password-container">
                <input type="password" name="password" id="password" placeholder="Sandi" class="input-field" required>
                <i class="fa-solid fa-eye toggle-password" id="togglePassword"></i>
            </div>
            <button type="submit" class="submit-btn">Masuk</button>
            {{-- <div class="alternative-actions">
                <p><a href="#">Gunakan Kode Masuk</a></p>
                <p><a href="#">Lupa sandi?</a></p>
            </div> --}}
        </form>
        <div class="new-to-baak">
            <p>Baru di MYBAAK? <a href="{{ route('register') }}">Daftar sekarang.</a></p>
        </div>
    </div>

    <footer>
        <div class="footer-content">
            <div style="font-size: 16px;">
                <p>Jalan Teuku Umar - Lubuk Baja, Lubuk Baja Kota, Lubuk Baja, Kota Batam, Kepulauan Riau 29432</p>
            </div>
            <div class="cookie-preference">
                {{-- <p><a href="#">Preferensi Cookie</a> | <a href="#">Informasi Perusahaan</a></p> --}}
            </div>
            <div class="language">
                {{-- <p><a href="#">Bahasa Indonesia</a></p> --}}
            </div>
        </div>
    </footer>

    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function(e) {
            // toggle the type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            // toggle the eye icon class
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    </script>
</body>

</html>
