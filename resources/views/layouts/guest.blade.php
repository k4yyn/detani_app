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
                background: linear-gradient(135deg, #0f172a 0%, #1e293b 25%, #2d3748 50%, #1e293b 75%, #0f172a 100%);
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
                background: radial-gradient(circle at 30% 20%, rgba(52, 211, 153, 0.08) 0%, transparent 60%),
                           radial-gradient(circle at 70% 80%, rgba(16, 185, 129, 0.06) 0%, transparent 60%);
                z-index: 0;
            }
            
            .card-glass {
                background: rgba(15, 23, 42, 0.7);
                backdrop-filter: blur(20px);
                border: 1px solid rgba(148, 163, 184, 0.2);
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.3);
            }
            
            .welcome-gradient {
                background: linear-gradient(135deg, #16a34a 0%, #15803d 50%, #166534 100%);
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
                background: rgba(30, 41, 59, 0.4);
                border: 1px solid rgba(148, 163, 184, 0.3);
                backdrop-filter: blur(10px);
                transition: all 0.3s ease;
            }
            
            .input-glass:focus {
                background: rgba(30, 41, 59, 0.6);
                border-color: rgba(52, 211, 153, 0.5);
                box-shadow: 0 0 0 3px rgba(52, 211, 153, 0.1);
                transform: translateY(-1px);
            }
            
            .btn-signin {
                background: linear-gradient(135deg, #10b981 0%, #059669 100%);
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
                background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.15), transparent);
                transition: left 0.5s;
            }
            
            .btn-signin:hover::before {
                left: 100%;
            }
            
            .btn-signin:hover {
                background: linear-gradient(135deg, #34d399 0%, #10b981 100%);
                transform: translateY(-2px);
                box-shadow: 0 15px 30px -10px rgba(16, 185, 129, 0.3);
            }
            
            .btn-signup {
                background: rgba(34, 197, 94, 0.1);
                border: 2px solid rgba(34, 197, 94, 0.2);
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
                background: linear-gradient(90deg, transparent, rgba(34, 197, 94, 0.1), transparent);
                transition: left 0.5s;
            }
            
            .btn-signup:hover::before {
                left: 100%;
            }
            
            .btn-signup:hover {
                background: rgba(34, 197, 94, 0.2);
                transform: translateY(-2px);
            }
            
            .social-btn {
                background: rgba(15, 42, 23, 0.4);
                border: 1px solid rgba(34, 197, 94, 0.2);
                backdrop-filter: blur(10px);
                transition: all 0.3s ease;
            }
            
            .social-btn:hover {
                background: rgba(34, 197, 94, 0.2);
                border-color: rgba(34, 197, 94, 0.3);
                transform: translateY(-2px) scale(1.05);
                box-shadow: 0 10px 20px -5px rgba(34, 197, 94, 0.2);
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
                opacity: 0.04;
                animation: float 8s ease-in-out infinite;
                background: linear-gradient(135deg, #10b981, #065f46);
                border-radius: 50%;
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
            
            .shape:nth-child(4) {
                top: 80%;
                right: 30%;
                animation-delay: 1s;
            }
            
            .shape:nth-child(5) {
                top: 10%;
                right: 20%;
                animation-delay: 3s;
            }
            
            @keyframes float {
                0%, 100% { 
                    transform: translateY(0px) rotate(0deg) scale(1); 
                    opacity: 0.04;
                }
                50% { 
                    transform: translateY(-15px) rotate(90deg) scale(1.05); 
                    opacity: 0.06;
                }
            }
            
            .content-wrapper {
                position: relative;
                z-index: 10;
            }
            
            /* Subtle leaf accent */
            .leaf-accent {
                position: absolute;
                top: -8px;
                right: -8px;
                width: 20px;
                height: 20px;
                background: linear-gradient(135deg, #10b981, #065f46);
                border-radius: 50% 0;
                opacity: 0.3;
                animation: leafFloat 6s ease-in-out infinite;
            }
            
            @keyframes leafFloat {
                0%, 100% { transform: rotate(0deg) scale(1); opacity: 0.3; }
                50% { transform: rotate(5deg) scale(1.02); opacity: 0.4; }
            }
        </style>
    </head>
    <body class="font-sans antialiased main-gradient min-h-screen">
        <!-- Floating Shapes with Green Theme -->
        <div class="floating-shapes">
            <div class="shape w-32 h-32"></div>
            <div class="shape w-24 h-24"></div>
            <div class="shape w-28 h-28"></div>
            <div class="shape w-20 h-20"></div>
            <div class="shape w-16 h-16"></div>
        </div>

        <!-- Main Container -->
        <div class="min-h-screen flex items-center justify-center p-6 content-wrapper">
            <div class="card-glass rounded-3xl p-10 w-full max-w-md mx-auto relative">
                <!-- Green leaf accent -->
                <div class="leaf-accent"></div>
                {{ $slot }}
            </div>
        </div>
    </body>
</html>