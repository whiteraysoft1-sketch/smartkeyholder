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
            --primary-gradient: linear-gradient(135deg, #8b5cf6 0%, #6366f1 100%);
            --secondary-gradient: linear-gradient(135deg, #34d399 0%, #60a5fa 100%);
            --bg-gradient: linear-gradient(135deg, #7c3aed 0%, #4f46e5 100%);
            --glass-bg: rgba(255, 255, 255, 0.35);
            --glass-border: rgba(255, 255, 255, 0.4);
            --glass-highlight: rgba(255, 255, 255, 0.5);
            --glass-shadow: rgba(0, 0, 0, 0.1);
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            color: white;
            background: var(--bg-gradient);
            min-height: 100vh;
            overflow-x: hidden;
            overflow-y: auto;
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
                radial-gradient(circle at 20% 20%, rgba(56, 189, 248, 0.7) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(139, 92, 246, 0.7) 0%, transparent 50%),
                radial-gradient(circle at 50% 50%, rgba(255, 255, 255, 0.2) 0%, transparent 70%);
            z-index: 0;
        }

        /* Apple-style Liquid Glass */
        .liquid-glass {
            background: var(--glass-bg);
            backdrop-filter: blur(12px) saturate(200%);
            -webkit-backdrop-filter: blur(12px) saturate(200%);
            border-radius: 24px;
            border: 1px solid var(--glass-border);
            box-shadow:
                0 15px 35px 0 var(--glass-shadow),
                inset 0 1px 0 0 var(--glass-highlight);
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .liquid-glass::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--glass-highlight), transparent);
        }

        .liquid-glass::after {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            top: -50%;
            left: -50%;
            background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, transparent 60%);
            opacity: 0.5;
        }

        .liquid-glass-dark {
            background: rgba(30, 58, 138, 0.25);
            backdrop-filter: blur(12px) saturate(200%);
            -webkit-backdrop-filter: blur(12px) saturate(200%);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.35);
            box-shadow: 0 15px 35px 0 rgba(0, 0, 0, 0.08);
            position: relative;
            overflow: hidden;
        }

        .liquid-glass-dark::after {
            content: '';
            position: absolute;
            width: 150%;
            height: 150%;
            top: -25%;
            left: -25%;
            background: radial-gradient(circle, rgba(255,255,255,0.25) 0%, transparent 60%);
            opacity: 0.6;
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

        .input-container { display: none; }
        .input-container.active {
            display: block;
            animation: slideInUp 0.6s ease-out;
            margin-top: 3rem;
            margin-bottom: 3rem;
            position: relative;
            z-index: 20;
        }

        /* Floating Elements */
        .floating-elements {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            pointer-events: none;
            z-index: 1;
        }

        .floating-element {
            position: absolute;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.2), rgba(255, 255, 255, 0.1));
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.25);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
        }

        @keyframes float {
            0%,100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        .pulse-glow {
            animation: pulseGlow 2s ease-in-out infinite alternate;
        }

        @keyframes pulseGlow {
            from { box-shadow: 0 0 20px rgba(56, 189, 248, 0.6); }
            to { box-shadow: 0 0 35px rgba(56, 189, 248, 1); }
        }

        /* Pattern Background */
        .pattern-bg {
            background-image:
                radial-gradient(circle at 2px 2px, rgba(255, 255, 255, 0.25) 1px, transparent 0);
            background-size: 20px 20px;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }

        /* Social Media Icons Background */
        .social-icons-bg {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            pointer-events: none;
            z-index: 1;
        }

        .social-icon {
            position: absolute;
            color: rgba(255, 255, 255, 0.25);
            width: 60px;
            height: 60px;
            z-index: 1;
            animation: float 8s ease-in-out infinite;
            opacity: 0.7;
            pointer-events: none;
            filter: blur(0.5px);
            backdrop-filter: blur(2px);
            -webkit-backdrop-filter: blur(2px);
        }

        .content-container {
            position: relative;
            z-index: 50;
        }

        /* Form Elements */
        .liquid-input {
            width: 100%;
            padding: 0.75rem 1rem;
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.45);
            color: white;
            font-size: 1rem;
            transition: all 0.3s ease;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            z-index: 200;
            position: relative;
            pointer-events: auto !important;
        }

        .liquid-input:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.3);
            border: 1px solid rgba(139, 92, 246, 0.9);
            box-shadow: 0 0 25px rgba(139, 92, 246, 0.5);
        }

        .liquid-input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .liquid-btn {
            width: 100%;
            padding: 0.75rem 1.5rem;
            background: var(--primary-gradient);
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.4);
            color: white;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(139, 92, 246, 0.3);
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
            background: linear-gradient(to bottom, rgba(255, 255, 255, 0.3), rgba(255, 255, 255, 0));
            opacity: 0.8;
        }

        .liquid-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(56, 189, 248, 0.5);
        }

        .liquid-btn:active {
            transform: translateY(0);
        }

        .liquid-btn.success {
            background: var(--secondary-gradient);
            box-shadow: 0 8px 25px rgba(52, 211, 153, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.4);
        }

        .liquid-btn.success:hover {
            box-shadow: 0 12px 30px rgba(52, 211, 153, 0.7);
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
    </style>
</head>
<body class="gradient-bg">
    <!-- Pattern Background -->
    <div class="pattern-bg"></div>

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

        <!-- Pinterest -->
        <svg class="social-icon" style="bottom: 45%; left: 40%; animation-delay: 6s;" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 12h8"></path><path d="M12 8v8"></path><circle cx="12" cy="12" r="10"></circle></svg>

        <!-- WhatsApp -->
        <svg class="social-icon" style="top: 75%; right: 40%; animation-delay: 7s;" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>

        <!-- Telegram -->
        <svg class="social-icon" style="top: 35%; left: 55%; animation-delay: 8s;" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 2L11 13"></path><path d="M22 2l-7 20-4-9-9-4 20-7z"></path></svg>

        <!-- Snapchat -->
        <svg class="social-icon" style="bottom: 60%; right: 55%; animation-delay: 9s;" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2C8.5 2 7 4 7 7v3c0 1.5-2 2-2 2s.5 1 2 1c0 1-1.5 3-3 3 0 0 3 1 6 1 0 0 0 2 2 2s2-2 2-2c3 0 6-1 6-1-1.5 0-3-2-3-3 1.5 0 2-1 2-1s-2-.5-2-2V7c0-3-1.5-5-5-5z"></path></svg>

        <!-- Discord -->
        <svg class="social-icon" style="top: 50%; left: 70%; animation-delay: 10s;" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="12" r="1"></circle><circle cx="15" cy="12" r="1"></circle><path d="M7.5 7.5c3.5-1 5.5-1 9 0"></path><path d="M7 16.5c3.5 1 6.5 1 10 0"></path><path d="M15.5 17c0 1 1.5 3 2 3 1.5 0 2.833-1.667 3.5-3 .667-1.667.5-5.833-1.5-11.5-1.457-1.015-3-1.34-4.5-1.5l-1 2.5"></path><path d="M8.5 17c0 1-1.356 3-1.832 3-1.429 0-2.698-1.667-3.333-3-.635-1.667-.48-5.833 1.428-11.5C6.151 4.485 7.545 4.16 9 4l1 2.5"></path></svg>

        <!-- Reddit -->
        <svg class="social-icon" style="bottom: 70%; right: 70%; animation-delay: 11s;" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"></circle><path d="M14.5 15c-.83 1-1.83 1.5-3 1.5-1.17 0-2.17-.5-3-1.5"></path><path d="M7 11c.33-.67 1-1 2-1"></path><path d="M17 11c-.33-.67-1-1-2-1"></path><path d="M12 14h.01"></path></svg>

        <!-- Messenger -->
        <svg class="social-icon" style="top: 85%; left: 30%; animation-delay: 12s;" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2a10 10 0 0 0-10 10c0 4.4 2.9 8.2 7 9.5V18h-2v-2h2v-2.9c0-1.7 1.3-3.1 3-3.1h2v2h-2c-.6 0-1 .4-1 1v3h3v2h-3v3.5c4.1-1.3 7-5.1 7-9.5a10 10 0 0 0-10-10z"></path></svg>

        <!-- Tumblr -->
        <svg class="social-icon" style="bottom: 85%; right: 30%; animation-delay: 13s;" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 21h-4v-6H7V9h3V6h4v3h3v6h-3v6z"></path></svg>

        <!-- WeChat -->
        <svg class="social-icon" style="top: 20%; left: 85%; animation-delay: 14s;" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16v16H4z"></path><path d="M9 8a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"></path><path d="M15 8a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"></path><path d="M9 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path><path d="M19 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path><path d="M12 16v-4"></path></svg>

        <!-- QQ -->
        <svg class="social-icon" style="bottom: 20%; left: 85%; animation-delay: 15s;" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2c-4.4 0-8 3.6-8 8 0 2.1.8 4 2.2 5.4-.3 1.1-.9 2.1-1.7 2.9-.3.3-.4.7-.2 1.1.1.4.5.6.9.6 1.8 0 3.5-.7 4.8-1.9.6.1 1.3.2 2 .2 4.4 0 8-3.6 8-8s-3.6-8-8-8z"></path></svg>

        <!-- Sina Weibo -->
        <svg class="social-icon" style="top: 65%; left: 5%; animation-delay: 16s;" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 15c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"></path><path d="M17.5 7.5a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11zm-11 0a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11z"></path></svg>

        <!-- Google Business -->
        <svg class="social-icon" style="bottom: 65%; right: 5%; animation-delay: 17s;" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><path d="M8 12h8"></path><path d="M12 8v8"></path></svg>

        <!-- Twitch -->
        <svg class="social-icon" style="top: 5%; left: 45%; animation-delay: 18s;" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 2H3v16h5v4l4-4h5l4-4V2zm-10 9V7m5 4V7"></path></svg>

        <!-- Skype -->
        <svg class="social-icon" style="bottom: 5%; right: 45%; animation-delay: 19s;" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 18a6 6 0 1 1 0-12 6 6 0 0 1 0 12z"></path><path d="M8 12a4 4 0 0 1 8 0"></path><line x1="9" y1="10" x2="9.01" y2="10"></line><line x1="15" y1="10" x2="15.01" y2="10"></line></svg>

        <!-- Medium -->
        <svg class="social-icon" style="top: 30%; left: 3%; animation-delay: 20s;" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 3h16a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1z"></path><path d="M8 9h8"></path><path d="M8 13h8"></path><path d="M8 17h5"></path></svg>

        <!-- Dribbble -->
        <svg class="social-icon" style="bottom: 30%; right: 3%; animation-delay: 21s;" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><path d="M19.13 5.09C15.22 9.14 10 10.44 2.25 10.94"></path><path d="M21.75 12.84c-6.62-1.41-12.14 1-16.38 6.32"></path><path d="M8.56 2.75c4.37 6 6 9.42 8 17.72"></path></svg>

        <!-- Slack -->
        <svg class="social-icon" style="bottom: 55%; left: 85%; animation-delay: 23s;" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 10c-.83 0-1.5-.67-1.5-1.5v-5c0-.83.67-1.5 1.5-1.5s1.5.67 1.5 1.5v5c0 .83-.67 1.5-1.5 1.5z"></path><path d="M20.5 10H19V8.5c0-.83.67-1.5 1.5-1.5s1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"></path><path d="M9.5 14c.83 0 1.5.67 1.5 1.5v5c0 .83-.67 1.5-1.5 1.5S8 21.33 8 20.5v-5c0-.83.67-1.5 1.5-1.5z"></path><path d="M3.5 14H5v1.5c0 .83-.67 1.5-1.5 1.5S2 16.33 2 15.5 2.67 14 3.5 14z"></path><path d="M14 14.5c0-.83.67-1.5 1.5-1.5h5c.83 0 1.5.67 1.5 1.5s-.67 1.5-1.5 1.5h-5c-.83 0-1.5-.67-1.5-1.5z"></path><path d="M15.5 19H14v1.5c0 .83.67 1.5 1.5 1.5s1.5-.67 1.5-1.5-.67-1.5-1.5-1.5z"></path><path d="M10 9.5C10 8.67 9.33 8 8.5 8h-5C2.67 8 2 8.67 2 9.5S2.67 11 3.5 11h5c.83 0 1.5-.67 1.5-1.5z"></path><path d="M8.5 5H10V3.5C10 2.67 9.33 2 8.5 2S7 2.67 7 3.5 7.67 5 8.5 5z"></path></svg>

        <!-- Vimeo -->
        <svg class="social-icon" style="top: 45%; right: 88%; animation-delay: 24s;" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 2H5a3 3 0 0 0-3 3v14a3 3 0 0 0 3 3h14a3 3 0 0 0 3-3V5a3 3 0 0 0-3-3z"></path><path d="M10 9l5 3-5 3V9z"></path></svg>

        <!-- Spotify -->
        <svg class="social-icon" style="bottom: 40%; right: 88%; animation-delay: 25s;" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><path d="M8 11.2A5.6 5.6 0 0 1 13.6 6"></path><path d="M6 13.4A7.8 7.8 0 0 1 13.8 6"></path><path d="M10 16.6A3.4 3.4 0 0 1 13.4 14"></path></svg>
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
        <!-- Header -->
        <div class="max-w-md mx-auto mb-16 animate-fade-in">
            <div class="liquid-glass p-6 text-center">
                <div class="flex items-center justify-center mb-3">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-r from-sky-500 to-indigo-500 flex items-center justify-center shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                        </svg>
                    </div>
                </div>
                <h1 class="text-2xl md:text-3xl font-bold text-white mb-2">Smart KeyHolder WST V1</h1>
                <p class="text-white/80 text-sm">Your Digital Identity Awaits</p>
            </div>
        </div>
        <!-- Chat Container -->
        <div class="max-w-2xl mx-auto pt-8">
            <div id="chatContainer" class="space-y-6 mb-12 min-h-[300px] pt-4"></div>

            <!-- Typing Indicator -->
            <div class="typing-indicator flex items-start space-x-3 mb-8">
                <div class="w-12 h-12 rounded-full bg-gradient-to-r from-purple-400 to-indigo-400 flex items-center justify-center text-white font-bold text-sm shadow-lg border border-white/30">AI</div>
                <div class="liquid-glass-dark rounded-2xl rounded-tl-sm p-4 border border-purple-400/40">
                    <div class="flex space-x-2">
                        <div class="w-2 h-2 bg-white/70 rounded-full dot"></div>
                        <div class="w-2 h-2 bg-white/70 rounded-full dot"></div>
                        <div class="w-2 h-2 bg-white/70 rounded-full dot"></div>
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
        <!-- QR Preview -->
        <div id="qrPreview" class="max-w-md mx-auto mt-8" style="display: none;">
            <div class="liquid-glass p-6 text-center animate-fade-in">
                <h3 class="text-white font-bold mb-4">Your QR Code</h3>
                <div class="bg-white p-3 rounded-xl inline-block mb-3 shadow-lg">
                    <img src="{{ route('qr.generate', $qrCode->uuid) }}" alt="QR Code" class="w-32 h-32 mx-auto">
                </div>
                <p class="text-white/80 text-sm">Code: {{ $qrCode->code }}</p>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-8 max-w-md mx-auto">
            <div class="liquid-glass-dark p-3 text-xs text-white/60">
                By claiming this profile, you agree to our
                <a href="#" class="text-sky-300 hover:text-sky-200 transition-colors">Terms of Service</a> and
                <a href="#" class="text-sky-300 hover:text-sky-200 transition-colors">Privacy Policy</a>
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
                response: (value) => `Nice to meet you, ${value}! 😊` },
            {
                question: "Now I need your email address to create your account.",
                field: "email",
                type: "email",
                placeholder: "your.email@example.com",
                validation: (value) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value),
                errorMessage: "Please enter a valid email address",
                response: (value) => `Perfect! ${value} looks great.` },
            {
                question: "Let's secure your account with a strong password.",
                field: "password",
                type: "password",
                placeholder: "Create a secure password",
                validation: (value) => value.length >= 8,
                errorMessage: "Password must be at least 8 characters long",
                response: () => "Excellent! Your account is now secure. 🔒" },
            {
                question: "Please confirm your password to make sure it's correct.",
                field: "password_confirmation",
                type: "password",
                placeholder: "Confirm your password",
                validation: (value) => value === conversationData.password,
                errorMessage: "Passwords don't match. Please try again.",
                response: () => "Great! Passwords match perfectly. ✅" },
            {
                question: "What's your profession or job title? (This helps people know what you do)",
                field: "profession",
                type: "text",
                placeholder: "e.g., Software Developer, Designer, Entrepreneur",
                validation: () => true,
                errorMessage: "",
                response: (value) => value ? `${value} sounds amazing! 🚀` : "No problem, you can add this later if you want." },
            {
                question: "What's your phone number? (Optional, but helpful for contacts)",
                field: "phone",
                type: "tel",
                placeholder: "+1 (555) 123-4567",
                validation: () => true,
                errorMessage: "",
                response: (value) => value ? "Perfect! People can now call you directly. 📞" : "That's okay, you can add this later." },
            {
                question: "Do you have a website or portfolio you'd like to share?",
                field: "website",
                type: "url",
                placeholder: "https://yourwebsite.com",
                validation: (value) => !value || /^https?:\/\/.+/.test(value),
                errorMessage: "Please enter a valid website URL (starting with http:// or https://)",
                response: (value) => value ? "Awesome! Your website will be featured on your profile. 🌐" : "No worries, you can add this anytime." },
            {
                question: "Where are you located? (City, Country)",
                field: "location",
                type: "text",
                placeholder: "e.g., New York, USA",
                validation: () => true,
                errorMessage: "",
                response: (value) => value ? `${value} - what a great place! 📍` : "That's fine, location is optional." },
            {
                question: "Finally, tell people a bit about yourself! What makes you unique?",
                field: "bio",
                type: "textarea",
                placeholder: "Write a short bio about yourself...",
                validation: () => true,
                errorMessage: "",
                response: (value) => value ? "Wonderful! Your bio will help people connect with you. ✨" : "You can always add a bio later when inspiration strikes!" }
        ];
        function showTyping() { document.querySelector('.typing-indicator').classList.add('show'); }
        function hideTyping() { document.querySelector('.typing-indicator').classList.remove('show'); }
        function addChatMessage(message, isUser = false, delay = 0) {
            setTimeout(() => {
                const chatContainer = document.getElementById('chatContainer');
                const messageDiv = document.createElement('div');

                if (isUser) {
                    messageDiv.className = 'chat-bubble user flex items-start space-x-3 justify-end';
                    messageDiv.innerHTML = `
                        <div class="liquid-glass-dark rounded-2xl rounded-tr-sm p-4 max-w-md border border-emerald-400/50">
                            <p class="text-white">${message}</p>
                        </div>
                        <div class="w-12 h-12 rounded-full bg-gradient-to-r from-emerald-300 to-sky-300 flex items-center justify-center text-white font-bold text-sm shadow-lg border border-white/40">You</div>
                    `;
                } else {
                    messageDiv.className = 'chat-bubble flex items-start space-x-3';
                    messageDiv.style.setProperty('--delay', delay);
                    messageDiv.innerHTML = `
                        <div class="w-12 h-12 rounded-full bg-gradient-to-r from-sky-300 to-indigo-300 flex items-center justify-center text-white font-bold text-sm shadow-lg border border-white/40">AI</div>
                        <div class="liquid-glass-dark rounded-2xl rounded-tl-sm p-4 max-w-md border border-sky-400/50">
                            <p class="text-white">${message}</p>
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
            let inputHTML;
            if (stepData.type === 'textarea') {
                inputHTML = `
                    <div class="liquid-glass p-6" style="position: relative; z-index: 200; pointer-events: auto !important;">
                        <textarea
                            id="currentInput"
                            placeholder="${stepData.placeholder}"
                            class="liquid-input resize-none"
                            rows="3"
                            style="position: relative; z-index: 201; pointer-events: auto !important;"
                        ></textarea>
                        <button
                            type="button"
                            onclick="processAnswer()"
                            class="liquid-btn"
                            style="position: relative; z-index: 201; pointer-events: auto !important;"
                        >
                            Continue →
                        </button>
                    </div>
                `;
            } else {
                inputHTML = `
                    <div class="liquid-glass p-6" style="position: relative; z-index: 200; pointer-events: auto !important;">
                        <input
                            type="${stepData.type}"
                            id="currentInput"
                            placeholder="${stepData.placeholder}"
                            class="liquid-input"
                            style="position: relative; z-index: 201; pointer-events: auto !important;"
                        >
                        <button
                            type="button"
                            onclick="processAnswer()"
                            class="liquid-btn"
                            style="position: relative; z-index: 201; pointer-events: auto !important;"
                        >
                            Continue →
                        </button>
                    </div>
                `;
            }
            container.innerHTML = inputHTML;
            container.classList.add('active');

            // Scroll to the input container with a delay to ensure smooth animation
            setTimeout(() => {
                container.scrollIntoView({ behavior: 'smooth', block: 'center' });
                document.getElementById('currentInput').focus();
            }, 300);

            document.getElementById('currentInput').addEventListener('keydown', function(e) {
                if (e.key === 'Enter' && stepData.type !== 'textarea') {
                    e.preventDefault();
                    processAnswer();
                }
            });
        }
        function processAnswer() {
            const input = document.getElementById('currentInput');
            const value = input.value.trim();
            const stepData = conversation[currentStep];

            // Special handling for password confirmation
            if (stepData.field === 'password_confirmation') {
                if (value !== conversationData.password) {
                    input.style.borderColor = 'rgba(239, 68, 68, 0.5)';
                    input.placeholder = "Passwords don't match. Please try again.";
                    input.value = '';
                    return;
                }
                // Set both conversationData and hidden field
                conversationData.password_confirmation = value;
                document.getElementById('hiddenPasswordConfirmation').value = value;
            } else if (stepData.field === 'password') {
                // Set both conversationData and hidden field
                conversationData.password = value;
                document.getElementById('hiddenPassword').value = value;
            } else if (!stepData.validation(value)) {
                if (stepData.errorMessage) {
                    input.style.borderColor = 'rgba(239, 68, 68, 0.5)';
                    input.placeholder = stepData.errorMessage;
                    input.value = '';
                    return;
                }
            } else {
                conversationData[stepData.field] = value;
                document.getElementById('hidden' + stepData.field.charAt(0).toUpperCase() + stepData.field.slice(1)).value = value;
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
                                setTimeout(() => { createInputField(currentStep); }, 1000);
                            }, 1500);
                        } else {
                            showFinalStep();
                        }
                    }, 1200);
                }, 1800);
            }, 500);

                    }
        function showFinalStep() {
            showTyping();
            setTimeout(() => {
                hideTyping();
                addChatMessage("🎉 Fantastic! You're all set up. Let me create your Smart KeyHolder profile now...");
                setTimeout(() => {
                    document.getElementById('qrPreview').style.display = 'block';
                    document.getElementById('qrPreview').scrollIntoView({ behavior: 'smooth', block: 'center' });
                }, 1000);
                setTimeout(() => {
                    addChatMessage("Your Smart KeyHolder is ready! Click below to activate it and start sharing your digital identity. 🚀");
                    setTimeout(() => {
                        const container = document.getElementById('inputContainer');
                        container.innerHTML = `
                            <div class="liquid-glass p-6 text-center">
                                <div class="mb-4">
                                    <div class="w-16 h-16 bg-gradient-to-r from-emerald-400 to-sky-500 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg pulse-glow">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-bold text-white mb-2">Ready to Launch! 🎉</h3>
                                    <p class="text-white/80 text-sm mb-4">30-day free trial • No credit card required</p>
                                </div>
                                <button type="button" onclick="submitClaimForm()" class="liquid-btn success text-lg font-bold">
                                    🚀 Activate My Smart KeyHolder
                                </button>
                            </div>
                        `;
                        container.classList.add('active');

                        // Ensure the final step is visible
                        setTimeout(() => {
                            container.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }, 300);
                    }, 1000);
                }, 2000);
            }, 1500);
        }
        function submitClaimForm() {
            console.log('Submitting form with data:', {
                name: conversationData.name,
                email: conversationData.email,
                password: '********', // Don't log actual password
                password_confirmation: '********'
            });

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

            // Verify password and confirmation match before submitting
            if (conversationData.password !== conversationData.password_confirmation) {
                showErrorMessage("Password and confirmation don't match. Please start over.");
                resetButton();
                return;
            }

            // Double-check all required fields are filled
            if (!conversationData.name || !conversationData.email || !conversationData.password) {
                showErrorMessage("Please fill in all required fields (name, email, password).");
                resetButton();
                return;
            }

            // Ensure hidden fields are properly set
            document.getElementById('hiddenName').value = conversationData.name;
            document.getElementById('hiddenEmail').value = conversationData.email;
            document.getElementById('hiddenPassword').value = conversationData.password;
            document.getElementById('hiddenPasswordConfirmation').value = conversationData.password_confirmation;

            // Submit the form
            try {
                // Short delay to show the loading state
                setTimeout(() => {
                    document.getElementById('claimForm').submit();
                }, 500);
            } catch (error) {
                console.error('Error submitting form:', error);
                showErrorMessage('An error occurred while submitting the form. Please try again.');
                resetButton();
            }

            function resetButton() {
                submitButton.innerHTML = originalButtonText;
                submitButton.disabled = false;

            function showErrorMessage(message) {
                // Create a toast notification instead of an alert
    }
                        const toast = document.createElement('div');
                toast.className = 'fixed bottom-4 left-1/2 transform -translate-x-1/2 liquid-glass-dark p-4 rounded-lg shadow-lg z-50 animate-fade-in';
                toast.innerHTML = `
                    <div class="flex items-center text-red-100">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>${message}</span>
                    </div>
                `;
                document.body.appendChild(toast);

                // Remove the toast after 5 seconds
                setTimeout(() => {
                    toast.style.opacity = '0';
                    toast.style.transform = 'translate(-50%, 20px)';
                    toast.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                    setTimeout(() => {
                        document.body.removeChild(toast);
                    }, 300);
                }, 5000);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                addChatMessage(conversation[0].question);
                setTimeout(() => { createInputField(0); }, 1000);
            }, 1000);
        });
    </script>
</body>
</html>
