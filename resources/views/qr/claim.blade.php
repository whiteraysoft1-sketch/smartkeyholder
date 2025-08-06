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
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: #000000;
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            color: white;
            overflow-x: hidden;
        }

        .gradient-bg {
            position: relative;
            min-height: 100vh;
            background: #000000;
        }





        .chat-bubble {
            animation: slideInUp 0.6s ease-out;
            opacity: 0;
            animation-fill-mode: forwards;
            animation-delay: calc(var(--delay, 0) * 0.1s);
        }

        .chat-bubble.user {
            animation: slideInRight 0.6s ease-out;
            opacity: 0;
            animation-fill-mode: forwards;
        }

        @keyframes slideInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(30px); }
            to { opacity: 1; transform: translateX(0); }
        }



        .content-container {
            position: relative;
            z-index: 10;
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
        .input-container.active { display: block; animation: slideInUp 0.6s ease-out; }



        .pulse-glow {
            animation: pulseGlow 3s ease-in-out infinite alternate;
        }

        @keyframes pulseGlow {
            from { 
                box-shadow: 0 0 20px rgba(59,130,246,0.4), 0 0 40px rgba(59,130,246,0.2); 
                filter: brightness(1);
            }
            to { 
                box-shadow: 0 0 30px rgba(59,130,246,0.8), 0 0 60px rgba(59,130,246,0.4); 
                filter: brightness(1.2);
            }
        }

        /* Particle system */
        .particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 2;
            pointer-events: none;
        }

        .particle {
            position: absolute;
            width: 2px;
            height: 2px;
            background: rgba(255, 255, 255, 0.6);
            border-radius: 50%;
            animation: particleFloat 20s linear infinite;
        }

        @keyframes particleFloat {
            0% {
                transform: translateY(100vh) translateX(0px);
                opacity: 0;
            }
            10% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            100% {
                transform: translateY(-10px) translateX(100px);
                opacity: 0;
            }
        }







        /* Reduced motion for accessibility */
        @media (prefers-reduced-motion: reduce) {
            .pulse-glow {
                animation: none;
            }
        }

        /* Enhanced Input Field UI */
        .input-field-container {
            display: flex;
            flex-direction: column;
            gap: 0;
        }

        .input-wrapper {
            position: relative;
            margin-bottom: 0;
        }

        .button-spacer {
            height: 24px; /* Space between input and button */
            background: linear-gradient(180deg, 
                rgba(255, 255, 255, 0.02) 0%, 
                transparent 50%, 
                rgba(59, 130, 246, 0.01) 100%);
            border-radius: 4px;
            margin: 8px 0;
        }

        .button-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .enhanced-input {
            position: relative;
            z-index: 2;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 2px solid rgba(255, 255, 255, 0.1);
        }

        .enhanced-input:focus {
            border-color: rgba(59, 130, 246, 0.5);
            box-shadow: 
                0 0 0 3px rgba(59, 130, 246, 0.1),
                0 8px 32px rgba(59, 130, 246, 0.15),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }

        .input-focus-ring {
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            border-radius: inherit;
            background: linear-gradient(135deg, 
                rgba(59, 130, 246, 0.3) 0%, 
                rgba(139, 92, 246, 0.3) 50%, 
                rgba(236, 72, 153, 0.3) 100%);
            opacity: 0;
            z-index: 1;
            transition: opacity 0.3s ease;
            filter: blur(8px);
        }

        .enhanced-input:focus + .input-focus-ring {
            opacity: 1;
            animation: focusRingPulse 2s ease-in-out infinite;
        }

        @keyframes focusRingPulse {
            0%, 100% { transform: scale(1); opacity: 0.3; }
            50% { transform: scale(1.02); opacity: 0.6; }
        }

        .enhanced-btn {
            position: relative;
            overflow: hidden;
            min-width: 160px;
            padding: 16px 32px;
            border-radius: 16px;
            background: linear-gradient(135deg, 
                rgba(59, 130, 246, 0.9) 0%, 
                rgba(139, 92, 246, 0.9) 100%);
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(20px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .enhanced-btn:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 
                0 12px 40px rgba(59, 130, 246, 0.4),
                0 0 0 1px rgba(255, 255, 255, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
        }

        .enhanced-btn:active {
            transform: translateY(-1px) scale(0.98);
            transition: all 0.1s ease;
        }

        .btn-content {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            position: relative;
            z-index: 2;
        }

        .btn-text {
            font-weight: 600;
            font-size: 16px;
            color: white;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
        }

        .btn-icon {
            display: flex;
            align-items: center;
            transition: transform 0.3s ease;
        }

        .enhanced-btn:hover .btn-icon {
            transform: translateX(4px);
        }

        .btn-glow {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, 
                rgba(255, 255, 255, 0.2) 0%, 
                transparent 50%, 
                rgba(59, 130, 246, 0.1) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
            border-radius: inherit;
        }

        .enhanced-btn:hover .btn-glow {
            opacity: 1;
            animation: btnGlowPulse 2s ease-in-out infinite;
        }

        @keyframes btnGlowPulse {
            0%, 100% { opacity: 0.3; transform: scale(1); }
            50% { opacity: 0.6; transform: scale(1.01); }
        }

        /* Enhanced mobile performance */
        @media (max-width: 768px) {
            .gradient-bg::before {
                animation-duration: 30s; /* Slower animation on mobile */
            }
            
            .floating-element {
                animation-duration: 12s; /* Slower floating on mobile */
            }
            
            .particle {
                animation-duration: 25s; /* Slower particles on mobile */
            }
            
            .aurora {
                opacity: 0.2; /* Reduced opacity on mobile */
                filter: blur(3px); /* More blur on mobile */
            }
            
            .aurora-1 { animation-duration: 35s; }
            .aurora-2 { animation-duration: 40s; }
            .aurora-3 { animation-duration: 45s; }

            /* Mobile input adjustments */
            .button-spacer {
                height: 20px;
                margin: 6px 0;
            }

            .enhanced-btn {
                min-width: 140px;
                padding: 14px 28px;
                border-radius: 14px;
            }

            .btn-text {
                font-size: 15px;
            }

            .enhanced-input {
                padding: 16px;
                font-size: 16px; /* Prevent zoom on iOS */
            }

            /* Mobile completion adjustments */
            .completion-btn {
                min-width: 280px;
                padding: 18px 24px;
            }

            .completion-btn-text {
                font-size: 16px;
            }

            .completion-spacer {
                height: 20px;
            }
        }

        /* Completion Section Styles */
        .completion-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding: 8px;
        }

        .completion-header {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 0;
        }

        .completion-icon {
            position: relative;
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, 
                rgba(34, 197, 94, 0.9) 0%, 
                rgba(59, 130, 246, 0.9) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            box-shadow: 
                0 8px 32px rgba(34, 197, 94, 0.3),
                0 0 0 1px rgba(255, 255, 255, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
            animation: completionIconPulse 2s ease-in-out infinite;
        }

        .icon-glow {
            position: absolute;
            top: -4px;
            left: -4px;
            right: -4px;
            bottom: -4px;
            background: linear-gradient(135deg, 
                rgba(34, 197, 94, 0.4) 0%, 
                rgba(59, 130, 246, 0.4) 100%);
            border-radius: 50%;
            filter: blur(8px);
            opacity: 0.6;
            animation: iconGlowPulse 3s ease-in-out infinite;
        }

        @keyframes completionIconPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        @keyframes iconGlowPulse {
            0%, 100% { opacity: 0.4; transform: scale(1); }
            50% { opacity: 0.8; transform: scale(1.1); }
        }

        .completion-title {
            font-size: 24px;
            font-weight: 700;
            color: white;
            margin-bottom: 8px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .completion-subtitle {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 0;
        }

        .completion-spacer {
            height: 32px;
            width: 100%;
            background: linear-gradient(180deg, 
                rgba(255, 255, 255, 0.03) 0%, 
                transparent 50%, 
                rgba(34, 197, 94, 0.02) 100%);
            border-radius: 8px;
            margin: 16px 0;
        }

        .completion-button-wrapper {
            display: flex;
            justify-content: center;
            width: 100%;
        }

        .completion-btn {
            position: relative;
            overflow: hidden;
            min-width: 320px;
            padding: 20px 32px;
            border-radius: 20px;
            background: linear-gradient(135deg, 
                rgba(34, 197, 94, 0.95) 0%, 
                rgba(59, 130, 246, 0.95) 50%,
                rgba(139, 92, 246, 0.95) 100%);
            border: 2px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(20px);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            box-shadow: 
                0 8px 32px rgba(34, 197, 94, 0.3),
                0 0 0 1px rgba(255, 255, 255, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
        }

        .completion-btn:hover {
            transform: translateY(-4px) scale(1.02);
            box-shadow: 
                0 16px 48px rgba(34, 197, 94, 0.4),
                0 8px 32px rgba(59, 130, 246, 0.3),
                0 0 0 2px rgba(255, 255, 255, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.3);
        }

        .completion-btn:active {
            transform: translateY(-2px) scale(0.98);
            transition: all 0.1s ease;
        }

        .completion-btn-content {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            position: relative;
            z-index: 2;
        }

        .completion-btn-icon {
            font-size: 24px;
            animation: rocketBounce 2s ease-in-out infinite;
        }

        @keyframes rocketBounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-4px); }
        }

        .completion-btn-text {
            font-weight: 700;
            font-size: 18px;
            color: white;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .completion-btn-glow {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, 
                rgba(255, 255, 255, 0.3) 0%, 
                transparent 50%, 
                rgba(34, 197, 94, 0.2) 100%);
            opacity: 0;
            transition: opacity 0.4s ease;
            border-radius: inherit;
        }

        .completion-btn:hover .completion-btn-glow {
            opacity: 1;
            animation: completionBtnGlowPulse 2s ease-in-out infinite;
        }

        @keyframes completionBtnGlowPulse {
            0%, 100% { opacity: 0.4; transform: scale(1); }
            50% { opacity: 0.8; transform: scale(1.01); }
        }

        .completion-btn-particles {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 20%, rgba(255, 255, 255, 0.3) 1px, transparent 1px),
                radial-gradient(circle at 80% 80%, rgba(255, 255, 255, 0.2) 1px, transparent 1px),
                radial-gradient(circle at 40% 60%, rgba(255, 255, 255, 0.25) 1px, transparent 1px);
            background-size: 30px 30px, 40px 40px, 50px 50px;
            opacity: 0;
            border-radius: inherit;
            animation: particleFloat 4s linear infinite;
        }

        .completion-btn:hover .completion-btn-particles {
            opacity: 1;
        }

        @keyframes particleFloat {
            0% { transform: translate(0, 0); }
            100% { transform: translate(20px, -20px); }
        }
    </style>
</head>
<body class="gradient-bg">


    <!-- Main Content -->
    <div class="content-container min-h-screen py-4 px-3 sm:py-8 sm:px-6">
        <!-- Header -->
        <div class="max-w-lg mx-auto mb-6 sm:mb-8 animate-fade-in">
            <div class="liquid-glass enhanced text-center">
                <div class="flex items-center justify-center mb-4">
                    <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center shadow-lg animate-pulse-glow">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 sm:h-8 sm:w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                        </svg>
                    </div>
                </div>
                <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-white mb-2">Smart KeyHolder WST V1</h1>
                <p class="text-white/80 text-sm sm:text-base">Your Digital Identity Awaits</p>
            </div>
        </div>

        <!-- Chat Container -->
        <div class="max-w-2xl mx-auto px-2 sm:px-0">
            <div id="chatContainer" class="space-y-3 sm:space-y-4 mb-6 min-h-[300px] sm:min-h-[400px]"></div>

            <!-- Typing Indicator -->
            <div class="typing-indicator flex items-start space-x-2 sm:space-x-3 mb-4 sm:mb-6 px-2 sm:px-0">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-xs sm:text-sm flex-shrink-0">AI</div>
                <div class="liquid-glass-dark rounded-xl sm:rounded-2xl rounded-tl-sm p-3 sm:p-4 max-w-[80%]">
                    <div class="flex space-x-1 sm:space-x-2">
                        <div class="w-2 h-2 bg-white/60 rounded-full dot"></div>
                        <div class="w-2 h-2 bg-white/60 rounded-full dot"></div>
                        <div class="w-2 h-2 bg-white/60 rounded-full dot"></div>
                    </div>
                </div>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('qr.claim.process', $qrCode->uuid) }}" id="claimForm">
                @csrf
                @if ($errors->any())
                    <div class="mx-2 sm:mx-0 mb-4 sm:mb-6">
                        <div class="liquid-glass enhanced border border-red-400/30 animate-fade-in">
                            <div class="flex items-start text-red-100 mb-3">
                                <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="font-semibold text-sm sm:text-base">Please fix the following:</span>
                            </div>
                            <ul class="list-disc list-inside text-red-100 text-sm space-y-1 ml-7">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
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
                <div id="inputContainer" class="input-container px-2 sm:px-0"></div>
            </form>
        </div>

        <!-- QR Preview -->
        <div id="qrPreview" class="max-w-lg mx-auto mt-6 sm:mt-8 px-2 sm:px-0" style="display: none;">
            <div class="liquid-glass enhanced text-center animate-fade-in">
                <h3 class="text-white font-bold mb-4 text-lg sm:text-xl">Your QR Code</h3>
                <div class="bg-white p-3 sm:p-4 rounded-xl inline-block mb-4 shadow-lg">
                    <img src="{{ route('qr.generate', $qrCode->uuid) }}" alt="QR Code" class="w-28 h-28 sm:w-32 sm:h-32 mx-auto">
                </div>
                <p class="text-white/80 text-sm sm:text-base">Code: <span class="font-mono font-semibold">{{ $qrCode->code }}</span></p>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-6 sm:mt-8 max-w-lg mx-auto px-2 sm:px-0">
            <div class="liquid-glass-dark text-xs sm:text-sm text-white/70 leading-relaxed">
                By claiming this profile, you agree to our
                <a href="#" class="text-blue-300 hover:text-blue-200 transition-colors underline decoration-dotted">Terms of Service</a> and
                <a href="#" class="text-blue-300 hover:text-blue-200 transition-colors underline decoration-dotted">Privacy Policy</a>
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
                    messageDiv.className = 'chat-bubble user flex items-start space-x-2 sm:space-x-3 justify-end px-2 sm:px-0';
                    messageDiv.innerHTML = `
                        <div class="liquid-glass-dark rounded-xl sm:rounded-2xl rounded-tr-sm p-3 sm:p-4 max-w-[80%] sm:max-w-md">
                            <p class="text-white text-sm sm:text-base leading-relaxed">${message}</p>
                        </div>
                        <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-gradient-to-r from-green-500 to-teal-600 flex items-center justify-center text-white font-bold text-xs sm:text-sm flex-shrink-0">You</div>
                    `;
                } else {
                    messageDiv.className = 'chat-bubble flex items-start space-x-2 sm:space-x-3 px-2 sm:px-0';
                    messageDiv.style.setProperty('--delay', delay);
                    messageDiv.innerHTML = `
                        <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-xs sm:text-sm flex-shrink-0">AI</div>
                        <div class="liquid-glass-dark rounded-xl sm:rounded-2xl rounded-tl-sm p-3 sm:p-4 max-w-[80%] sm:max-w-md">
                            <p class="text-white text-sm sm:text-base leading-relaxed">${message}</p>
                        </div>
                    `;
                }

                chatContainer.appendChild(messageDiv);
                // Smooth scroll with better mobile handling
                setTimeout(() => {
                    messageDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                }, 100);
            }, delay);
        }

        function createInputField(step) {
            const stepData = conversation[step];
            const container = document.getElementById('inputContainer');
            let inputHTML;

            if (stepData.type === 'textarea') {
                inputHTML = `
                    <div class="liquid-glass enhanced animate-slide-up">
                        <div class="input-field-container">
                            <div class="input-wrapper">
                                <textarea id="currentInput" placeholder="${stepData.placeholder}" class="liquid-input enhanced-input resize-none" rows="4" autocomplete="off"></textarea>
                                <div class="input-focus-ring"></div>
                            </div>
                            <div class="button-spacer"></div>
                            <div class="button-wrapper">
                                <button type="button" onclick="processAnswer()" class="liquid-btn enhanced-btn">
                                    <div class="btn-content">
                                        <span class="btn-text">Continue</span>
                                        <div class="btn-icon">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="btn-glow"></div>
                                </button>
                            </div>
                        </div>
                    </div>
                `;
            } else {
                inputHTML = `
                    <div class="liquid-glass enhanced animate-slide-up">
                        <div class="input-field-container">
                            <div class="input-wrapper">
                                <input type="${stepData.type}" id="currentInput" placeholder="${stepData.placeholder}" class="liquid-input enhanced-input" autocomplete="off">
                                <div class="input-focus-ring"></div>
                            </div>
                            <div class="button-spacer"></div>
                            <div class="button-wrapper">
                                <button type="button" onclick="processAnswer()" class="liquid-btn enhanced-btn">
                                    <div class="btn-content">
                                        <span class="btn-text">Continue</span>
                                        <div class="btn-icon">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="btn-glow"></div>
                                </button>
                            </div>
                        </div>
                    </div>
                `;
            }

            container.innerHTML = inputHTML;
            container.classList.add('active');

            // Smooth scroll to input on mobile
            setTimeout(() => {
                const input = document.getElementById('currentInput');
                input.focus();
                input.scrollIntoView({ behavior: 'smooth', block: 'center' });
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
                console.log('Confirming password: ', value, 'Original password: ', conversationData.password);
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
                    document.getElementById('qrPreview').scrollIntoView({ behavior: 'smooth' });
                }, 1000);

                setTimeout(() => {
                    addChatMessage("Your Smart KeyHolder is ready! Click below to activate it and start sharing your digital identity. 🚀");

                    setTimeout(() => {
                        const container = document.getElementById('inputContainer');
                        container.innerHTML = `
                            <div class="liquid-glass enhanced animate-slide-up">
                                <div class="completion-container">
                                    <div class="completion-header">
                                        <div class="completion-icon">
                                            <div class="icon-glow"></div>
                                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                        <h3 class="completion-title">Ready to Launch! 🎉</h3>
                                        <p class="completion-subtitle">30-day free trial • No credit card required</p>
                                    </div>
                                    <div class="completion-spacer"></div>
                                    <div class="completion-button-wrapper">
                                        <button type="button" onclick="submitClaimForm()" class="completion-btn">
                                            <div class="completion-btn-content">
                                                <span class="completion-btn-icon">🚀</span>
                                                <span class="completion-btn-text">Activate My Smart KeyHolder</span>
                                            </div>
                                            <div class="completion-btn-glow"></div>
                                            <div class="completion-btn-particles"></div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        `;
                        container.classList.add('active');
                    }, 1000);
                }, 2000);
            }, 1500);
        }

        function submitClaimForm() {
            console.log('Submitting form with data:', {
                name: conversationData.name,
                email: conversationData.email,
                password: '********', // Don't log actual password
                password_confirmation: '********',
                hiddenPassword: document.getElementById('hiddenPassword').value ? 'Set' : 'Not set',
                hiddenPasswordConfirmation: document.getElementById('hiddenPasswordConfirmation').value ? 'Set' : 'Not set'
            });

            // Verify password and confirmation match before submitting
            if (conversationData.password !== conversationData.password_confirmation) {
                alert("Password and confirmation don't match. Please start over.");
                return;
            }

            // Double-check all required fields are filled
            if (!conversationData.name || !conversationData.email || !conversationData.password) {
                alert("Please fill in all required fields (name, email, password).");
                return;
            }

            // Ensure hidden fields are properly set
            document.getElementById('hiddenName').value = conversationData.name;
            document.getElementById('hiddenEmail').value = conversationData.email;
            document.getElementById('hiddenPassword').value = conversationData.password;
            document.getElementById('hiddenPasswordConfirmation').value = conversationData.password_confirmation;

            // Submit the form
            try {
                // Add a debug message to the page
                const debugDiv = document.createElement('div');
                debugDiv.style.display = 'none';
                debugDiv.innerHTML = `
                    <p>Name: ${document.getElementById('hiddenName').value ? 'Set' : 'Not set'}</p>
                    <p>Email: ${document.getElementById('hiddenEmail').value ? 'Set' : 'Not set'}</p>
                    <p>Password: ${document.getElementById('hiddenPassword').value ? 'Set' : 'Not set'}</p>
                    <p>Password Confirmation: ${document.getElementById('hiddenPasswordConfirmation').value ? 'Set' : 'Not set'}</p>
                `;
                document.body.appendChild(debugDiv);

                document.getElementById('claimForm').submit();
            } catch (error) {
                console.error('Error submitting form:', error);
                alert('An error occurred while submitting the form. Please try again.');
            }
        }

        // Initialize everything
        document.addEventListener('DOMContentLoaded', function() {
            // Start the chat
            setTimeout(() => {
                addChatMessage(conversation[0].question);
                setTimeout(() => { createInputField(0); }, 1000);
            }, 1000);
        });
    </script>
</body>
</html>
