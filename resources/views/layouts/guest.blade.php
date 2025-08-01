<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            body {
                font-family: 'Inter', sans-serif;
            }
            
            .main-gradient {
                background: linear-gradient(135deg, #0f172a 0%, #112057 25%, #7088b4 50%, #112057 75%, #0f172a 100%);
                position: relative;
                overflow: hidden;
            }
            
            .main-gradient::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: radial-gradient(circle at 30% 20%, rgba(59, 130, 246, 0.15) 0%, transparent 50%),
                           radial-gradient(circle at 70% 80%, rgba(60, 109, 223, 0.15) 0%, transparent 50%);
                z-index: 0;
            }
            
            .card-glass {
                background: rgba(4, 16, 64, 0.366);
                backdrop-filter: blur(20px);
                border: 1px solid rgba(148, 163, 184, 0.1);
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            }
            
            .welcome-gradient {
                background: linear-gradient(135deg, #1e40af 0%, #3730a3 50%, #581c87 100%);
                position: relative;
                overflow: hidden;
            }
            
            .welcome-gradient::before {
                content: '';
                position: absolute;
                top: -50%;
                left: -50%;
                width: 200%;
                height: 200%;
                background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
                animation: rotate 20s linear infinite;
                z-index: 0;
            }
            
            @keyframes rotate {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
            
            .input-glass {
                background: rgba(15, 23, 42, 0.3);
                border: 1px solid rgba(148, 163, 184, 0.2);
                backdrop-filter: blur(10px);
                transition: all 0.3s ease;
            }
            
            .input-glass:focus {
                background: rgba(15, 23, 42, 0.5);
                border-color: rgba(59, 130, 246, 0.5);
                box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
                transform: translateY(-1px);
            }
            
            .btn-signin {
                background: linear-gradient(135deg, #1e40af 0%, #3730a3 100%);
                position: relative;
                overflow: hidden;
            }
            
            .btn-signin::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
                transition: left 0.5s;
            }
            
            .btn-signin:hover::before {
                left: 100%;
            }
            
            .btn-signin:hover {
                background: linear-gradient(135deg, #1d4ed8 0%, #4338ca 100%);
                transform: translateY(-2px);
                box-shadow: 0 20px 40px -12px rgba(30, 64, 175, 0.4);
            }
            
            .btn-signup {
                background: rgba(255, 255, 255, 0.1);
                border: 2px solid rgba(255, 255, 255, 0.2);
                position: relative;
                overflow: hidden;
            }
            
            .btn-signup::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
                transition: left 0.5s;
            }
            
            .btn-signup:hover::before {
                left: 100%;
            }
            
            .btn-signup:hover {
                background: rgba(255, 255, 255, 0.2);
                transform: translateY(-2px);
            }
            
            .social-btn {
                background: rgba(15, 23, 42, 0.4);
                border: 1px solid rgba(148, 163, 184, 0.2);
                backdrop-filter: blur(10px);
                transition: all 0.3s ease;
            }
            
            .social-btn:hover {
                background: rgba(59, 130, 246, 0.2);
                border-color: rgba(59, 130, 246, 0.3);
                transform: translateY(-2px) scale(1.05);
                box-shadow: 0 10px 20px -5px rgba(59, 130, 246, 0.2);
            }
            
            .floating-shapes {
                position: absolute;
                width: 100%;
                height: 100%;
                overflow: hidden;
                z-index: 1;
            }
            
            .shape {
                position: absolute;
                opacity: 0.1;
                animation: float 6s ease-in-out infinite;
            }
            
            .shape:nth-child(1) {
                top: 20%;
                left: 10%;
                animation-delay: 0s;
            }
            
            .shape:nth-child(2) {
                top: 60%;
                right: 10%;
                animation-delay: 2s;
            }
            
            .shape:nth-child(3) {
                bottom: 20%;
                left: 20%;
                animation-delay: 4s;
            }
            
            @keyframes float {
                0%, 100% { transform: translateY(0px) rotate(0deg); }
                50% { transform: translateY(-20px) rotate(180deg); }
            }
            
            .content-wrapper {
                position: relative;
                z-index: 10;
            }
        </style>
    </head>
    <body class="font-sans antialiased main-gradient min-h-screen">
        <!-- Floating Shapes -->
        <div class="floating-shapes">
            <div class="shape w-32 h-32 bg-slate-100 rounded-full"></div>
            <div class="shape w-24 h-24 bg-slate-100 rounded-full"></div>
            <div class="shape w-28 h-28 bg-slate-300 rounded-full"></div>
        </div>

        <!-- Main Container -->
        <div class="min-h-screen flex items-center justify-center p-6 content-wrapper">
            <div class="card-glass rounded-3xl p-10 w-full max-w-md mx-auto relative">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>