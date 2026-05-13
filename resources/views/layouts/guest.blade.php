<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Kiana Furniture') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        *{
            font-family: 'Poppins', sans-serif;
        }

        body{
            margin:0;
            min-height:100vh;
            overflow-x:hidden;
            background:
                linear-gradient(rgba(255,248,240,0.88), rgba(255,248,240,0.88)),
                url('https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?q=80&w=1400&auto=format&fit=crop');
            background-size:cover;
            background-position:center;
            display:flex;
            justify-content:center;
            align-items:center;
            position:relative;
        }

        /* blur overlay */
        body::before{
            content:'';
            position:absolute;
            inset:0;
            backdrop-filter:blur(3px);
        }

        /* decorative shapes */
        .shape-1{
            position:absolute;
            top:-120px;
            left:-120px;
            width:420px;
            height:420px;
            background:#d9b38c25;
            border-radius:50%;
            z-index:1;
        }

        .shape-2{
            position:absolute;
            bottom:-100px;
            right:-100px;
            width:320px;
            height:320px;
            background:#c08b5c20;
            border-radius:50%;
            z-index:1;
        }

        .dots{
            position:absolute;
            top:120px;
            right:90px;
            display:grid;
            grid-template-columns:repeat(6,10px);
            gap:10px;
            z-index:1;
        }

        .dots span{
            width:5px;
            height:5px;
            background:#c08b5c;
            border-radius:50%;
            opacity:.7;
        }

        .auth-wrapper{
            position:relative;
            z-index:5;
            width:100%;
            max-width:430px;
            padding:20px;
        }

        .logo-area{
            text-align:center;
            margin-bottom:18px;
        }

        .logo-box{
            width:72px;
            height:72px;
            margin:auto;
            border-radius:22px;
            background:linear-gradient(135deg,#d6a36d,#9b6b3d);
            display:flex;
            align-items:center;
            justify-content:center;
            box-shadow:0 10px 30px rgba(0,0,0,.12);
        }

        .logo-box i{
            color:white;
            font-size:30px;
        }

        .brand-title{
            font-size:46px;
            font-weight:800;
            color:#2f1d14;
            margin-top:14px;
            line-height:1;
        }

        .brand-sub{
            color:#b37a45;
            font-size:15px;
            font-weight:600;
            letter-spacing:1px;
        }

        .auth-card{
            background:rgba(255,255,255,0.82);
            backdrop-filter:blur(16px);
            border-radius:30px;
            padding:34px;
            box-shadow:
                0 10px 40px rgba(0,0,0,.08),
                inset 0 1px 1px rgba(255,255,255,.5);
            border:1px solid rgba(255,255,255,.6);
        }

        .auth-card h1{
            font-size:42px;
            font-weight:800;
            color:#1f2937;
            text-align:center;
            margin-bottom:10px;
        }

        .auth-card p{
            text-align:center;
            color:#6b7280;
            margin-bottom:28px;
        }

        .input-group{
            margin-bottom:18px;
        }

        .input-group label{
            display:block;
            margin-bottom:8px;
            font-weight:600;
            color:#374151;
            font-size:14px;
        }

        .input-wrapper{
            position:relative;
        }

        .input-wrapper i{
            position:absolute;
            left:16px;
            top:50%;
            transform:translateY(-50%);
            color:#b08968;
            font-size:16px;
        }

        .input-wrapper input{
            width:100%;
            height:54px;
            border-radius:16px;
            border:1px solid #e5e7eb;
            background:white;
            padding:0 18px 0 48px;
            font-size:15px;
            outline:none;
            transition:.3s;
        }

        .input-wrapper input:focus{
            border-color:#c08b5c;
            box-shadow:0 0 0 4px rgba(192,139,92,.15);
        }

        .auth-btn{
            width:100%;
            height:54px;
            border:none;
            border-radius:16px;
            background:linear-gradient(135deg,#c08b5c,#9b6b3d);
            color:white;
            font-size:16px;
            font-weight:700;
            cursor:pointer;
            transition:.3s;
            box-shadow:0 10px 25px rgba(192,139,92,.25);
        }

        .auth-btn:hover{
            transform:translateY(-2px);
        }

        .bottom-link{
            margin-top:22px;
            text-align:center;
            color:#6b7280;
            font-size:14px;
        }

        .bottom-link a{
            color:#9b6b3d;
            font-weight:700;
            text-decoration:none;
        }

        @media(max-width:640px){

            .auth-wrapper{
                max-width:100%;
                padding:18px;
            }

            .auth-card{
                padding:28px 22px;
                border-radius:24px;
            }

            .auth-card h1{
                font-size:34px;
            }

            .brand-title{
                font-size:38px;
            }
        }
    </style>
</head>

<body>

    <!-- decorations -->
    <div class="shape-1"></div>
    <div class="shape-2"></div>

    <div class="dots">
        @for($i=0;$i<36;$i++)
            <span></span>
        @endfor
    </div>

    <div class="auth-wrapper">

        <!-- Logo -->
        <div class="logo-area">
            <div class="logo-box">
                <i class="fas fa-couch"></i>
            </div>

            <div class="brand-title">
                Kiana
            </div>

            <div class="brand-sub">
                Furniture
            </div>
        </div>

        <!-- Card -->
        <div class="auth-card">
            @yield('content')
        </div>

    </div>

</body>
</html>