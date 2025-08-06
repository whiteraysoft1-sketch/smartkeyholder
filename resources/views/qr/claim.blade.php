<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Smart KeyHolder WST V1 - Whiteray Smart Tag</title>
    @vite(['resources/css/app.css', 'resources/css/liquid-glass.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            /* Mac UI Color Palette */
            --mac-blue: #007AFF;
            --mac-purple: #AF52DE;
            --mac-pink: #FF2D92;
            --mac-red: #FF3B30;
            --mac-orange: #FF9500;
            --mac-yellow: #FFCC00;
            --mac-green: #34C759;
            --mac-teal: #5AC8FA;
            --mac-indigo: #5856D6;
            
            /* Mac System Colors */
            --mac-gray-1: #8E8E93;
            --mac-gray-2: #AEAEB2;
            --mac-gray-3: #C7C7CC;
            --mac-gray-4: #D1D1D6;
            --mac-gray-5: #E5E5EA;
            --mac-gray-6: #F2F2F7;
            
            /* Mac Dark Mode Colors */
            --mac-dark-1: #1C1C1E;
            --mac-dark-2: #2C2C2E;
            --mac-dark-3: #3A3A3C;
            --mac-dark-4: #48484A;
            --mac-dark-5: #636366;
            --mac-dark-6: #8E8E93;
            
            /* Enhanced Gradients with Mac Colors */
            --primary-gradient: linear-gradient(135deg, var(--mac-blue) 0%, var(--mac-purple) 100%);
            --secondary-gradient: linear-gradient(135deg, var(--mac-green) 0%, var(--mac-teal) 100%);
            --accent-gradient: linear-gradient(135deg, var(--mac-pink) 0%, var(--mac-orange) 100%);
            --bg-gradient: linear-gradient(135deg, #0A0A0B 0%, var(--mac-dark-1) 25%, var(--mac-dark-2) 75%, #1A1A1C 100%);
            
            /* Enhanced Glass Morphism */
            --glass-bg: rgba(255, 255, 255, 0.08);
            --glass-bg-strong: rgba(255, 255, 255, 0.12);
            --glass-border: rgba(255, 255, 255, 0.15);
            --glass-border-strong: rgba(255, 255, 255, 0.25);
            --glass-highlight: rgba(255, 255, 255, 0.3);
            --glass-shadow: rgba(0, 0, 0, 0.25);
            --glass-shadow-strong: rgba(0, 0, 0, 0.4);
            
            /* Mac-style Blur Values */
            --blur-light: blur(20px);
            --blur-medium: blur(40px);
            --blur-strong: blur(60px);
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'SF Pro Display', 'Inter', system-ui, sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            color: white;
            background: var(--bg-gradient);
            min-height: 100vh;
            overflow-x: hidden;
            overflow-y: auto;
            font-feature-settings: "kern" 1, "liga" 1, "calt" 1;
        }

        .gradient-bg {
            background: var(--bg-gradient);
            position: relative;
            overflow-x: hidden;
            overflow-y: auto;
            min-height: 100vh;
            padding-bottom: 4rem;
        }

        .gradient-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background:
                radial-gradient(circle at 15% 15%, rgba(0, 122, 255, 0.15) 0%, transparent 40%),
                radial-gradient(circle at 85% 20%, rgba(175, 82, 222, 0.12) 0%, transparent 45%),
                radial-gradient(circle at 70% 80%, rgba(52, 199, 89, 0.08) 0%, transparent 35%),
                radial-gradient(circle at 25% 75%, rgba(255, 45, 146, 0.1) 0%, transparent 40%),
                radial-gradient(circle at 50% 50%, rgba(255, 255, 255, 0.02) 0%, transparent 60%);
            z-index: 0;
            animation: gradientShift 20s ease-in-out infinite;
        }

        @keyframes gradientShift {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.8; }
        }

        /* Enhanced Mac-style Liquid Glass */
        .liquid-glass {
            background: var(--glass-bg-strong);
            backdrop-filter: var(--blur-medium) saturate(180%);
            -webkit-backdrop-filter: var(--blur-medium) saturate(180%);
            border-radius: 28px;
            border: 1px solid var(--glass-border-strong);
            box-shadow:
                0 25px 50px -12px var(--glass-shadow-strong),
                0 8px 16px -4px var(--glass-shadow),
                inset 0 1px 0 0 var(--glass-highlight),
                inset 0 0 0 1px rgba(255, 255, 255, 0.05);
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        .liquid-glass:hover {
            transform: translateY(-2px);
            box-shadow:
                0 32px 64px -12px var(--glass-shadow-strong),
                0 12px 24px -4px var(--glass-shadow),
                inset 0 1px 0 0 var(--glass-highlight),
                inset 0 0 0 1px rgba(255, 255, 255, 0.08);
        }

        .liquid-glass::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, 
                transparent 0%, 
                var(--glass-highlight) 20%, 
                rgba(255, 255, 255, 0.8) 50%, 
                var(--glass-highlight) 80%, 
                transparent 100%);
            opacity: 0.6;
        }

        .liquid-glass::after {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            top: -50%;
            left: -50%;
            background: radial-gradient(circle at center, 
                rgba(255, 255, 255, 0.1) 0%, 
                rgba(255, 255, 255, 0.05) 30%, 
                transparent 70%);
            opacity: 0.4;
            animation: glassShimmer 8s ease-in-out infinite;
        }

        @keyframes glassShimmer {
            0%, 100% { transform: rotate(0deg) scale(1); opacity: 0.4; }
            50% { transform: rotate(180deg) scale(1.1); opacity: 0.2; }
        }

        .liquid-glass-dark {
            background: rgba(28, 28, 30, 0.7);
            backdrop-filter: var(--blur-medium) saturate(150%);
            -webkit-backdrop-filter: var(--blur-medium) saturate(150%);
            border-radius: 24px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 
                0 20px 40px -8px rgba(0, 0, 0, 0.4),
                0 8px 16px -4px rgba(0, 0, 0, 0.2),
                inset 0 1px 0 0 rgba(255, 255, 255, 0.1);
            position: relative;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        .liquid-glass-dark:hover {
            background: rgba(28, 28, 30, 0.8);
            border-color: rgba(255, 255, 255, 0.15);
            transform: translateY(-1px);
        }

        .liquid-glass-dark::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, 
                transparent 0%, 
                rgba(255, 255, 255, 0.2) 50%, 
                transparent 100%);
        }

        .liquid-glass-dark::after {
            content: '';
            position: absolute;
            width: 150%;
            height: 150%;
            top: -25%;
            left: -25%;
            background: radial-gradient(circle at center, 
                rgba(255, 255, 255, 0.08) 0%, 
                rgba(255, 255, 255, 0.03) 40%, 
                transparent 70%);
            opacity: 0.8;
        }

        /* Animations */
        .chat-bubble {
            animation: slideInUp 0.6s ease-out;
            opacity: 0;
            animation-fill-mode: forwards;
            animation-delay: calc(var(--delay, 0) * 0.1s);
            margin-bottom: 1.5rem;
        }

        .chat-bubble.user {
            animation: slideInRight 0.6s ease-out;
            opacity: 0;
            animation-fill-mode: forwards;
            margin-bottom: 1.5rem;
        }

        @keyframes slideInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(30px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .typing-indicator { display: none; }
        .typing-indicator.show { display: flex; animation: slideInUp 0.3s ease-out; }
        .dot { animation: typing 1.4s infinite ease-in-out; }
        .dot:nth-child(1) { animation-delay: -0.32s; }
        .dot:nth-child(2) { animation-delay: -0.16s; }

        @keyframes typing {
            0%,80%,100% { transform: scale(0); opacity: 0.5; }
            40% { transform: scale(1); opacity: 1; }
        }

        .input-container { 
            display: none !important; 
        }
        .input-container.active {
            display: block !important;
            animation: slideInUp 0.6s ease-out;
            margin-top: -1rem;
            margin-bottom: 3rem;
            position: relative;
            z-index: 200;
            visibility: visible !important;
            opacity: 1 !important;
            min-height: 200px;
        }
        
        /* Ensure input fields are always visible when container is active */
        .input-container.active .liquid-glass {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
        }
        
        .input-container.active .liquid-input {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
        }
        
        .input-container.active .liquid-btn {
            display: flex !important;
            visibility: visible !important;
            opacity: 1 !important;
        }

        .content-container {
            position: relative;
            z-index: 50;
        }

        /* Enhanced Mac-style Form Elements */
        .liquid-input {
            width: 100%;
            padding: 1rem 1.25rem;
            /* Fallback background for all browsers */
            background-color: rgba(44, 44, 46, 0.9);
            border-radius: 16px;
            border: 1.5px solid rgba(255, 255, 255, 0.2);
            color: white !important;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            margin-bottom: 1.5rem;
            box-shadow: 
                0 4px 16px rgba(0, 0, 0, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
            z-index: 200;
            position: relative;
            pointer-events: auto !important;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
        }

        /* Enhanced glass effect for modern browsers */
        @supports (backdrop-filter: blur(20px)) {
            .liquid-input {
                background: rgba(255, 255, 255, 0.15);
                backdrop-filter: blur(20px) saturate(150%);
                -webkit-backdrop-filter: blur(20px) saturate(150%);
            }
        }

        .liquid-input:focus {
            outline: none;
            background-color: rgba(58, 58, 60, 0.95);
            border: 1.5px solid var(--mac-blue);
            box-shadow: 
                0 0 0 4px rgba(0, 122, 255, 0.15),
                0 8px 24px rgba(0, 122, 255, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.25);
            transform: translateY(-1px);
        }

        @supports (backdrop-filter: blur(20px)) {
            .liquid-input:focus {
                background: rgba(255, 255, 255, 0.2);
            }
        }

        .liquid-input::placeholder {
            color: rgba(255, 255, 255, 0.6);
            font-weight: 400;
        }

        .liquid-input:hover:not(:focus) {
            border-color: rgba(255, 255, 255, 0.3);
            background-color: rgba(48, 48, 50, 0.92);
        }

        @supports (backdrop-filter: blur(20px)) {
            .liquid-input:hover:not(:focus) {
                background: rgba(255, 255, 255, 0.18);
            }
        }

        .liquid-btn {
            width: 100%;
            padding: 1rem 1.5rem;
            background: var(--primary-gradient);
            border-radius: 16px;
            border: none;
            color: white;
            font-weight: 600;
            font-size: 1rem;
            line-height: 1.5;
            transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
            box-shadow: 
                0 8px 32px rgba(0, 122, 255, 0.3),
                0 4px 16px rgba(0, 0, 0, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
            z-index: 200;
            pointer-events: auto !important;
        }

        .liquid-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, 
                rgba(255, 255, 255, 0.2) 0%, 
                rgba(255, 255, 255, 0.1) 50%, 
                rgba(255, 255, 255, 0.05) 100%);
            opacity: 1;
            transition: opacity 0.3s ease;
        }

        .liquid-btn:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 
                0 16px 48px rgba(0, 122, 255, 0.4),
                0 8px 24px rgba(0, 0, 0, 0.15),
                inset 0 1px 0 rgba(255, 255, 255, 0.3);
        }

        .liquid-btn:hover::before {
            opacity: 0.8;
        }

        .liquid-btn:active {
            transform: translateY(-1px) scale(1.01);
            transition: all 0.1s ease;
        }

        .liquid-btn.success {
            background: var(--secondary-gradient);
            box-shadow: 
                0 8px 32px rgba(52, 199, 89, 0.3),
                0 4px 16px rgba(0, 0, 0, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
        }

        .liquid-btn.success:hover {
            box-shadow: 
                0 16px 48px rgba(52, 199, 89, 0.4),
                0 8px 24px rgba(0, 0, 0, 0.15),
                inset 0 1px 0 rgba(255, 255, 255, 0.3);
        }

        .liquid-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .liquid-btn:disabled:hover {
            transform: none;
            box-shadow: 
                0 8px 32px rgba(0, 122, 255, 0.2),
                0 4px 16px rgba(0, 0, 0, 0.1);
        }

        /* Mobile Optimizations */
        @media (max-width: 640px) {
            .liquid-glass {
                border-radius: 20px;
                padding: 1.25rem;
            }

            .liquid-input {
                padding: 0.625rem 0.875rem;
                border-radius: 10px;
                font-size: 0.95rem;
            }

            .liquid-btn {
                padding: 0.625rem 1.25rem;
                border-radius: 10px;
                font-size: 0.95rem;
            }
        }

        /* Animations */
        .animate-fade-in {
            animation: fadeIn 0.8s ease-out;
        }

        .animate-slide-up {
            animation: slideUp 0.6s ease-out;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideUp {
            0% {
                opacity: 0;
                transform: translateY(40px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Social Media Icons Background */
        .social-icons-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
            overflow: hidden;
        }

        .social-icon {
            position: absolute;
            color: rgba(255, 255, 255, 0.1);
            animation: socialFloat 20s ease-in-out infinite;
            transition: all 0.3s ease;
        }

        .social-icon:hover {
            color: rgba(255, 255, 255, 0.3);
            transform: scale(1.2);
        }

        @keyframes socialFloat {
            0%, 100% {
                transform: translateY(0px) rotate(0deg);
                opacity: 0.1;
            }
            25% {
                transform: translateY(-20px) rotate(90deg);
                opacity: 0.2;
            }
            50% {
                transform: translateY(-10px) rotate(180deg);
                opacity: 0.15;
            }
            75% {
                transform: translateY(-30px) rotate(270deg);
                opacity: 0.25;
            }
        }

        /* Floating Elements */
        .floating-elements {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 2;
            overflow: hidden;
        }

        .floating-element {
            position: absolute;
            background: radial-gradient(circle at 30% 30%, 
                rgba(0, 122, 255, 0.1) 0%, 
                rgba(175, 82, 222, 0.08) 35%, 
                rgba(52, 199, 89, 0.06) 70%, 
                transparent 100%);
            border-radius: 50%;
            animation: float 15s ease-in-out infinite;
            backdrop-filter: blur(1px);
            -webkit-backdrop-filter: blur(1px);
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px) translateX(0px) rotate(0deg);
                opacity: 0.3;
            }
            25% {
                transform: translateY(-30px) translateX(20px) rotate(90deg);
                opacity: 0.5;
            }
            50% {
                transform: translateY(-60px) translateX(-10px) rotate(180deg);
                opacity: 0.4;
            }
            75% {
                transform: translateY(-20px) translateX(-30px) rotate(270deg);
                opacity: 0.6;
            }
        }

        /* Enhanced responsive design for social icons */
        @media (max-width: 768px) {
            .social-icon {
                width: 18px;
                height: 18px;
            }
            
            .floating-element {
                opacity: 0.5;
            }
        }

        @media (max-width: 480px) {
            .social-icon {
                width: 16px;
                height: 16px;
                opacity: 0.08;
            }
            
            .floating-element {
                opacity: 0.3;
            }
        }
    </style>
</head>
<body class="gradient-bg">
    <!-- Social Media Icons Background -->
    <div class="social-icons-bg">
        <!-- Facebook -->
        <svg class="social-icon" style="top: 15%; left: 10%; animation-delay: 0s;" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>

        <!-- Twitter/X -->
        <svg class="social-icon" style="top: 25%; right: 10%; animation-delay: 1s;" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z"></path></svg>

        <!-- Instagram -->
        <svg class="social-icon" style="bottom: 30%; left: 15%; animation-delay: 2s;" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>

        <!-- LinkedIn -->
        <svg class="social-icon" style="bottom: 20%; right: 15%; animation-delay: 3s;" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path><rect x="2" y="9" width="4" height="12"></rect><circle cx="4" cy="4" r="2"></circle></svg>

        <!-- YouTube -->
        <svg class="social-icon" style="top: 40%; left: 25%; animation-delay: 4s;" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z"></path><polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02"></polygon></svg>

        <!-- TikTok -->
        <svg class="social-icon" style="top: 60%; right: 25%; animation-delay: 5s;" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12a4 4 0 1 0 0 8 4 4 0 0 0 0-8z"></path><path d="M15 8a4 4 0 1 0 0-8 4 4 0 0 0 0 8z"></path><path d="M15 8v8a4 4 0 0 1-4 4"></path><line x1="9" y1="12" x2="15" y2="8"></line></svg>

        <!-- WhatsApp -->
        <svg class="social-icon" style="top: 75%; right: 40%; animation-delay: 7s;" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>

        <!-- Telegram -->
        <svg class="social-icon" style="top: 35%; left: 55%; animation-delay: 8s;" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 2L11 13"></path><path d="M22 2l-7 20-4-9-9-4 20-7z"></path></svg>

        <!-- Discord -->
        <svg class="social-icon" style="top: 50%; left: 70%; animation-delay: 10s;" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="12" r="1"></circle><circle cx="15" cy="12" r="1"></circle><path d="M7.5 7.5c3.5-1 5.5-1 9 0"></path><path d="M7 16.5c3.5 1 6.5 1 10 0"></path><path d="M15.5 17c0 1 1.5 3 2 3 1.5 0 2.833-1.667 3.5-3 .667-1.667.5-5.833-1.5-11.5-1.457-1.015-3-1.34-4.5-1.5l-1 2.5"></path><path d="M8.5 17c0 1-1.356 3-1.832 3-1.429 0-2.698-1.667-3.333-3-.635-1.667-.48-5.833 1.428-11.5C6.151 4.485 7.545 4.16 9 4l1 2.5"></path></svg>
    </div>

    <!-- Floating Elements -->
    <div class="floating-elements">
        <div class="floating-element w-20 h-20 top-10 left-10" style="animation-delay: 0s;"></div>
        <div class="floating-element w-32 h-32 top-20 right-20" style="animation-delay: 2s;"></div>
        <div class="floating-element w-16 h-16 bottom-20 left-20" style="animation-delay: 4s;"></div>
        <div class="floating-element w-24 h-24 bottom-10 right-10" style="animation-delay: 1s;"></div>
        <div class="floating-element w-28 h-28 top-1/2 left-1/4" style="animation-delay: 3s;"></div>
        <div class="floating-element w-36 h-36 bottom-1/3 right-1/3" style="animation-delay: 5s;"></div>
    </div>

    <!-- Main Content -->
    <div class="content-container min-h-screen py-12 px-4 sm:px-6">
        <!-- Enhanced Header -->
        <div class="max-w-md mx-auto mb-8 animate-fade-in">
            <div class="liquid-glass p-8 text-center">
                <div class="flex items-center justify-center mb-6">
                    <div class="relative">
                        <div class="w-16 h-16 rounded-full bg-gradient-to-br from-blue-500 via-purple-500 to-pink-500 flex items-center justify-center shadow-2xl ring-4 ring-white/20">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                            </svg>
                        </div>
                        <div class="absolute -inset-2 bg-gradient-to-br from-blue-400/20 via-purple-400/20 to-pink-400/20 rounded-full blur-lg animate-pulse"></div>
                    </div>
                </div>
                <h1 class="text-3xl md:text-4xl font-bold text-white mb-3 tracking-tight">
                    Smart KeyHolder 
                    <span class="bg-gradient-to-r from-blue-400 via-purple-400 to-pink-400 bg-clip-text text-transparent">WST V1</span>
                </h1>
                <p class="text-white/70 text-base font-medium">Your Digital Identity Awaits</p>
                <div class="mt-4 flex items-center justify-center space-x-2">
                    <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                    <span class="text-green-400 text-sm font-medium">Ready to Claim</span>
                </div>
            </div>
        </div>
        
        <!-- Chat Container -->
        <div class="max-w-2xl mx-auto pt-2">
            <div id="chatContainer" class="space-y-6 mb-12 min-h-[300px] pt-2"></div>

            <!-- Enhanced Typing Indicator -->
            <div class="typing-indicator flex items-start space-x-4 mb-8">
                <div class="relative">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 via-purple-500 to-indigo-500 flex items-center justify-center text-white font-bold text-sm shadow-xl ring-2 ring-white/20">
                        AI
                    </div>
                    <div class="absolute -inset-1 bg-gradient-to-br from-blue-400/30 via-purple-400/30 to-indigo-400/30 rounded-full blur-md animate-pulse"></div>
                </div>
                <div class="liquid-glass-dark rounded-2xl rounded-tl-sm p-4 border border-blue-400/30 shadow-lg">
                    <div class="flex space-x-2">
                        <div class="w-2.5 h-2.5 bg-gradient-to-r from-blue-400 to-purple-400 rounded-full dot"></div>
                        <div class="w-2.5 h-2.5 bg-gradient-to-r from-purple-400 to-pink-400 rounded-full dot"></div>
                        <div class="w-2.5 h-2.5 bg-gradient-to-r from-pink-400 to-blue-400 rounded-full dot"></div>
                    </div>
                </div>
            </div>
            
            <!-- Form -->
            <form method="POST" action="{{ route('qr.claim.process', $qrCode->uuid) }}" id="claimForm">
                @csrf
                @if ($errors->any())
                    <div class="liquid-glass p-4 border border-red-300 mb-6 animate-fade-in">
                        <div class="flex items-center text-red-100 mb-2">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="font-semibold">Please fix the following:</span>
                        </div>
                        <ul class="list-disc list-inside text-red-100 text-sm space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Hidden Fields -->
                <input type="hidden" name="name" id="hiddenName">
                <input type="hidden" name="email" id="hiddenEmail">
                <input type="hidden" name="password" id="hiddenPassword">
                <input type="hidden" name="password_confirmation" id="hiddenPasswordConfirmation">
                <input type="hidden" name="profession" id="hiddenProfession">
                <input type="hidden" name="phone" id="hiddenPhone">
                <input type="hidden" name="website" id="hiddenWebsite">
                <input type="hidden" name="location" id="hiddenLocation">
                <input type="hidden" name="bio" id="hiddenBio">

                <!-- Input Container -->
                <div id="inputContainer" class="input-container" style="scroll-margin-top: 120px; position: relative; z-index: 200; pointer-events: auto !important;"></div>
            </form>
        </div>

        <!-- Enhanced Footer -->
        <div class="text-center mt-12 max-w-md mx-auto">
            <div class="liquid-glass-dark p-4 text-sm text-white/70 rounded-2xl">
                <div class="flex items-center justify-center mb-2">
                    <svg class="w-4 h-4 mr-2 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-blue-400 font-medium">Secure & Private</span>
                </div>
                <p class="text-xs leading-relaxed">
                    By claiming this profile, you agree to our
                    <a href="#" class="text-blue-400 hover:text-blue-300 transition-colors font-medium underline decoration-blue-400/30">Terms of Service</a> and
                    <a href="#" class="text-blue-400 hover:text-blue-300 transition-colors font-medium underline decoration-blue-400/30">Privacy Policy</a>
                </p>
            </div>
        </div>
    </div>
    
    <script>
        let currentStep = 0;
        let conversationData = {};
        const conversation = [
            {
                question: "Hello! Welcome to your new Smart KeyHolder WST V1! 🎉 What's your name?",
                field: "name",
                type: "text",
                placeholder: "Enter your full name",
                validation: (value) => value.trim().length >= 2,
                errorMessage: "Please enter your full name (at least 2 characters)",
                response: (value) => `Nice to meet you, ${value}! 😊`
            },
            {
                question: "Now I need your email address to create your account.",
                field: "email",
                type: "email",
                placeholder: "your.email@example.com",
                validation: (value) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value),
                errorMessage: "Please enter a valid email address",
                response: (value) => `Perfect! ${value} looks great.`
            },
            {
                question: "Let's secure your account with a strong password.",
                field: "password",
                type: "password",
                placeholder: "Create a secure password (min 8 characters)",
                validation: (value) => value.length >= 8,
                errorMessage: "Password must be at least 8 characters long",
                response: () => "Excellent! Your account is now secure. 🔒"
            },
            {
                question: "Please confirm your password to make sure it's correct.",
                field: "password_confirmation",
                type: "password",
                placeholder: "Confirm your password",
                validation: (value) => {
                    if (!value || value.length === 0) {
                        return false;
                    }
                    return value === conversationData.password;
                },
                errorMessage: "Passwords don't match. Please try again.",
                response: () => "Great! Passwords match perfectly. ✅"
            },
            {
                question: "What's your profession or job title? (This helps people know what you do)",
                field: "profession",
                type: "text",
                placeholder: "e.g., Software Developer, Designer, Entrepreneur",
                validation: () => true,
                errorMessage: "",
                response: (value) => value ? `${value} sounds amazing! 🚀` : "No problem, you can add this later if you want."
            },
            {
                question: "What's your phone number? (Optional, but helpful for contacts)",
                field: "phone",
                type: "tel",
                placeholder: "+1 (555) 123-4567",
                validation: () => true,
                errorMessage: "",
                response: (value) => value ? "Perfect! People can now call you directly. 📞" : "That's okay, you can add this later."
            },
            {
                question: "Where are you located? (City, Country)",
                field: "location",
                type: "text",
                placeholder: "e.g., New York, USA",
                validation: () => true,
                errorMessage: "",
                response: (value) => value ? `${value} - what a great place! 📍` : "That's fine, location is optional."
            },
            {
                question: "Finally, what services do you offer? Tell people what you can help them with!",
                field: "bio",
                type: "textarea",
                placeholder: "Describe your services and what you can help people with...",
                validation: () => true,
                errorMessage: "",
                response: (value) => value ? "Excellent! People will know exactly how you can help them. 💼" : "You can always add your services later when you're ready!"
            }
        ];

        function showTyping() { 
            document.querySelector('.typing-indicator').classList.add('show'); 
        }
        
        function hideTyping() { 
            document.querySelector('.typing-indicator').classList.remove('show'); 
        }
        
        function addChatMessage(message, isUser = false, delay = 0) {
            setTimeout(() => {
                const chatContainer = document.getElementById('chatContainer');
                const messageDiv = document.createElement('div');

                if (isUser) {
                    messageDiv.className = 'chat-bubble user flex items-start space-x-4 justify-end';
                    messageDiv.innerHTML = `
                        <div class="liquid-glass-dark rounded-2xl rounded-tr-sm p-4 max-w-md border border-green-400/30 shadow-lg backdrop-blur-xl">
                            <p class="text-white font-medium">${message}</p>
                        </div>
                        <div class="relative">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-green-400 via-emerald-500 to-teal-500 flex items-center justify-center text-white font-bold text-sm shadow-xl ring-2 ring-white/20">You</div>
                            <div class="absolute -inset-1 bg-gradient-to-br from-green-400/30 via-emerald-400/30 to-teal-400/30 rounded-full blur-md opacity-60"></div>
                        </div>
                    `;
                } else {
                    messageDiv.className = 'chat-bubble flex items-start space-x-4';
                    messageDiv.style.setProperty('--delay', delay);
                    messageDiv.innerHTML = `
                        <div class="relative">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 via-purple-500 to-indigo-500 flex items-center justify-center text-white font-bold text-sm shadow-xl ring-2 ring-white/20">AI</div>
                            <div class="absolute -inset-1 bg-gradient-to-br from-blue-400/30 via-purple-400/30 to-indigo-400/30 rounded-full blur-md opacity-60"></div>
                        </div>
                        <div class="liquid-glass-dark rounded-2xl rounded-tl-sm p-4 max-w-md border border-blue-400/30 shadow-lg backdrop-blur-xl">
                            <p class="text-white font-medium">${message}</p>
                        </div>
                    `;
                }

                chatContainer.appendChild(messageDiv);
                messageDiv.scrollIntoView({ behavior: 'smooth' });
            }, delay);
        }
        
        function createInputField(step) {
            const stepData = conversation[step];
            const container = document.getElementById('inputContainer');
            
            if (!container) {
                console.error('Input container not found!');
                return;
            }
            
            let inputHTML;
            if (stepData.type === 'textarea') {
                inputHTML = `
                    <div class="liquid-glass p-8" style="position: relative; z-index: 200; pointer-events: auto !important;">
                        <div class="mb-4">
                            <label class="block text-white/80 text-sm font-medium mb-2">Your Response</label>
                            <textarea
                                id="currentInput"
                                placeholder="${stepData.placeholder}"
                                class="liquid-input resize-none"
                                rows="4"
                                style="position: relative; z-index: 201; pointer-events: auto !important;"
                            ></textarea>
                        </div>
                        <button
                            type="button"
                            onclick="processAnswer()"
                            class="liquid-btn group"
                            style="position: relative; z-index: 201; pointer-events: auto !important;"
                        >
                            <span class="mr-2">Continue</span>
                            <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </button>
                    </div>
                `;
            } else {
                inputHTML = `
                    <div class="liquid-glass p-8" style="position: relative; z-index: 200; pointer-events: auto !important;">
                        <div class="mb-4">
                            <label class="block text-white/80 text-sm font-medium mb-2">Your Response</label>
                            <input
                                type="${stepData.type}"
                                id="currentInput"
                                placeholder="${stepData.placeholder}"
                                class="liquid-input"
                                style="position: relative; z-index: 201; pointer-events: auto !important;"
                            >
                        </div>
                        <button
                            type="button"
                            onclick="processAnswer()"
                            class="liquid-btn group"
                            style="position: relative; z-index: 201; pointer-events: auto !important;"
                        >
                            <span class="mr-2">Continue</span>
                            <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </button>
                    </div>
                `;
            }
            
            container.innerHTML = inputHTML;
            container.classList.add('active');
            container.style.display = 'block';
            container.style.visibility = 'visible';
            container.style.opacity = '1';

            // Scroll to the input container with a delay to ensure smooth animation
            setTimeout(() => {
                container.scrollIntoView({ behavior: 'smooth', block: 'center' });
                const inputElement = document.getElementById('currentInput');
                if (inputElement) {
                    inputElement.focus();
                }
            }, 300);

            // Add enter key listener
            const inputElement = document.getElementById('currentInput');
            if (inputElement) {
                inputElement.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter' && stepData.type !== 'textarea') {
                        e.preventDefault();
                        processAnswer();
                    }
                });
            }
        }
        
        function processAnswer() {
            const input = document.getElementById('currentInput');
            const value = input.value.trim();
            const stepData = conversation[currentStep];

            // Validation
            if (!stepData.validation(value)) {
                if (stepData.errorMessage) {
                    input.style.borderColor = 'rgba(239, 68, 68, 0.5)';
                    input.placeholder = stepData.errorMessage;
                    input.value = '';
                    return;
                }
            }

            // Store the data
            conversationData[stepData.field] = value;
            
            // Set hidden form field
            const hiddenFieldName = 'hidden' + stepData.field.charAt(0).toUpperCase() + stepData.field.slice(1);
            const hiddenField = document.getElementById(hiddenFieldName);
            if (hiddenField) {
                hiddenField.value = value;
            }
            
            // Special handling for password_confirmation field
            if (stepData.field === 'password_confirmation') {
                const passwordConfirmationField = document.getElementById('hiddenPasswordConfirmation');
                if (passwordConfirmationField) {
                    passwordConfirmationField.value = value;
                }
            }

            // For password fields, show asterisks instead of the actual password in the chat
            let displayValue = value;
            if (stepData.type === 'password' && value) {
                displayValue = '••••••••';
            }

            addChatMessage(displayValue || "I'll skip this for now", true);
            document.getElementById('inputContainer').classList.remove('active');
            
            setTimeout(() => {
                showTyping();
                setTimeout(() => {
                    hideTyping();
                    const response = stepData.response(value);
                    addChatMessage(response);
                    setTimeout(() => {
                        currentStep++;
                        if (currentStep < conversation.length) {
                            showTyping();
                            setTimeout(() => {
                                hideTyping();
                                addChatMessage(conversation[currentStep].question);
                                setTimeout(() => { 
                                    createInputField(currentStep); 
                                }, 200);
                            }, 300);
                        } else {
                            showFinalStep();
                        }
                    }, 250);
                }, 400);
            }, 100);
        }
        
        function showFinalStep() {
            showTyping();
            setTimeout(() => {
                hideTyping();
                addChatMessage("🎉 Fantastic! You're all set up. Let me create your Smart KeyHolder profile now...");
                setTimeout(() => {
                    addChatMessage("Your Smart KeyHolder is ready! Click below to activate it and start sharing your digital identity. 🚀");
                    setTimeout(() => {
                        const container = document.getElementById('inputContainer');
                        container.innerHTML = `
                            <div class="liquid-glass p-8 text-center">
                                <div class="mb-8">
                                    <div class="relative">
                                        <div class="w-20 h-20 bg-gradient-to-br from-green-400 via-emerald-500 to-teal-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-2xl ring-4 ring-white/20">
                                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                        <div class="absolute -inset-3 bg-gradient-to-br from-green-400/20 via-emerald-400/20 to-teal-400/20 rounded-full blur-xl animate-pulse"></div>
                                    </div>
                                    <h3 class="text-2xl font-bold text-white mb-3">Ready to Launch! 🎉</h3>
                                    <p class="text-white/70 text-base mb-2">Your Smart KeyHolder is configured and ready</p>
                                    <div class="flex items-center justify-center space-x-6 text-sm text-white/60 mb-6">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            30-day free trial
                                        </div>
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            No credit card required
                                        </div>
                                    </div>
                                </div>
                                <button type="button" onclick="submitClaimForm()" class="liquid-btn success text-lg font-bold group">
                                    <span class="mr-3">🚀 Activate My Smart KeyHolder</span>
                                    <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                    </svg>
                                </button>
                            </div>
                        `;
                        container.classList.add('active');

                        // Ensure the final step is visible
                        setTimeout(() => {
                            container.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }, 300);
                    }, 300);
                }, 500);
            }, 400);
        }
        
        function submitClaimForm() {
            // Verify all required fields are filled
            if (!conversationData.name || !conversationData.email || !conversationData.password) {
                alert('Please fill in all required fields (name, email, password).');
                return;
            }

            // Verify password and confirmation match
            if (conversationData.password !== conversationData.password_confirmation) {
                alert("Password and confirmation don't match. Please start over.");
                return;
            }

            // Ensure all hidden form fields are populated
            console.log('Conversation data:', conversationData);
            
            // Double-check all hidden fields are set
            document.getElementById('hiddenName').value = conversationData.name || '';
            document.getElementById('hiddenEmail').value = conversationData.email || '';
            document.getElementById('hiddenPassword').value = conversationData.password || '';
            document.getElementById('hiddenPasswordConfirmation').value = conversationData.password_confirmation || '';
            document.getElementById('hiddenProfession').value = conversationData.profession || '';
            document.getElementById('hiddenPhone').value = conversationData.phone || '';
            document.getElementById('hiddenWebsite').value = conversationData.website || '';
            document.getElementById('hiddenLocation').value = conversationData.location || '';
            document.getElementById('hiddenBio').value = conversationData.bio || '';

            // Debug: Log all form field values
            console.log('Form field values:');
            console.log('Name:', document.getElementById('hiddenName').value);
            console.log('Email:', document.getElementById('hiddenEmail').value);
            console.log('Password:', document.getElementById('hiddenPassword').value ? '***' : 'EMPTY');
            console.log('Password Confirmation:', document.getElementById('hiddenPasswordConfirmation').value ? '***' : 'EMPTY');

            // Get the submit button and change its text to show loading state
            const submitButton = document.querySelector('.liquid-btn.success');
            const originalButtonText = submitButton.innerHTML;
            submitButton.innerHTML = `
                <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Activating...
            `;
            submitButton.disabled = true;

            // Submit the form
            setTimeout(() => {
                document.getElementById('claimForm').submit();
            }, 500);
        }

        // Start the conversation when the page loads
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM Content Loaded - Starting chat conversation');
            
            // Hide typing indicator initially
            const typingIndicator = document.querySelector('.typing-indicator');
            if (typingIndicator) {
                typingIndicator.style.display = 'none';
            }
            
            // Start the conversational interface
            setTimeout(() => {
                addChatMessage(conversation[0].question);
                setTimeout(() => { 
                    createInputField(0); 
                }, 1000);
            }, 500);
        });
    </script>
</body>
</html>