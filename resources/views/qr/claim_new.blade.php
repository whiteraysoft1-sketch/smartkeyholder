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
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            color: white;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
            position: relative;
            overflow: hidden;
        }

        .gradient-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background:
                radial-gradient(circle at 20% 20%, rgba(59, 130, 246, 0.15) 0%, transparent 40%),
                radial-gradient(circle at 80% 80%, rgba(139, 92, 246, 0.15) 0%, transparent 40%);
            z-index: 0;
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

        .pattern-bg {
            background-image:
                radial-gradient(circle at 2px 2px, rgba(255,255,255,0.05) 1px, transparent 0);
            background-size: 20px 20px;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
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
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%,100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        .pulse-glow {
            animation: pulseGlow 2s ease-in-out infinite alternate;
        }

        @keyframes pulseGlow {
            from { box-shadow: 0 0 20px rgba(59,130,246,0.4); }
            to { box-shadow: 0 0 30px rgba(59,130,246,0.8); }
        }
    </style>
</head>
<body class="gradient-bg">
    <!-- Background Pattern -->
    <div class="pattern-bg"></div>

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
    <div class="content-container min-h-screen py-8 px-4 sm:px-6">
        <!-- Header -->
        <div class="max-w-md mx-auto mb-8 animate-fade-in">
            <div class="liquid-glass text-center">
                <div class="flex items-center justify-center mb-3">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center shadow-lg">
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
        <div class="max-w-2xl mx-auto">
            <div id="chatContainer" class="space-y-4 mb-6 min-h-[400px]"></div>

            <!-- Typing Indicator -->
            <div class="typing-indicator flex items-start space-x-3 mb-6">
                <div class="w-12 h-12 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm">AI</div>
                <div class="liquid-glass-dark rounded-2xl rounded-tl-sm p-4">
                    <div class="flex space-x-2">
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
                    <div class="liquid-glass rounded-2xl p-4 border border-red-300 mb-6 animate-fade-in">
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
                <div id="inputContainer" class="input-container"></div>
            </form>
        </div>

        <!-- QR Preview -->
        <div id="qrPreview" class="max-w-md mx-auto mt-8" style="display: none;">
            <div class="liquid-glass text-center animate-fade-in">
                <h3 class="text-white font-bold mb-4">Your QR Code</h3>
                <div class="bg-white p-3 rounded-xl inline-block mb-3">
                    <img src="{{ route('qr.generate', $qrCode->uuid) }}" alt="QR Code" class="w-32 h-32 mx-auto">
                </div>
                <p class="text-white/80 text-sm">Code: {{ $qrCode->code }}</p>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-8 max-w-md mx-auto">
            <div class="liquid-glass-dark p-3 text-xs text-white/60">
                By claiming this profile, you agree to our
                <a href="#" class="text-blue-300 hover:text-blue-200 transition-colors">Terms of Service</a> and
                <a href="#" class="text-blue-300 hover:text-blue-200 transition-colors">Privacy Policy</a>
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
                    messageDiv.className = 'chat-bubble user flex items-start space-x-3 justify-end';
                    messageDiv.innerHTML = `
                        <div class="liquid-glass-dark rounded-2xl rounded-tr-sm p-4 max-w-md">
                            <p class="text-white">${message}</p>
                        </div>
                        <div class="w-12 h-12 rounded-full bg-gradient-to-r from-green-500 to-teal-600 flex items-center justify-center text-white font-bold text-sm">You</div>
                    `;
                } else {
                    messageDiv.className = 'chat-bubble flex items-start space-x-3';
                    messageDiv.style.setProperty('--delay', delay);
                    messageDiv.innerHTML = `
                        <div class="w-12 h-12 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm">AI</div>
                        <div class="liquid-glass-dark rounded-2xl rounded-tl-sm p-4 max-w-md">
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
                    <div class="liquid-glass p-6">
                        <textarea id="currentInput" placeholder="${stepData.placeholder}" class="liquid-input resize-none" rows="3"></textarea>
                        <button type="button" onclick="processAnswer()" class="liquid-btn">Continue →</button>
                    </div>
                `;
            } else {
                inputHTML = `
                    <div class="liquid-glass p-6">
                        <input type="${stepData.type}" id="currentInput" placeholder="${stepData.placeholder}" class="liquid-input">
                        <button type="button" onclick="processAnswer()" class="liquid-btn">Continue →</button>
                    </div>
                `;
            }

            container.innerHTML = inputHTML;
            container.classList.add('active');

            setTimeout(() => {
                document.getElementById('currentInput').focus();
            }, 100);

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
                            <div class="liquid-glass p-6 text-center">
                                <div class="mb-4">
                                    <div class="w-16 h-16 bg-gradient-to-r from-green-400 to-blue-500 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
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

        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                addChatMessage(conversation[0].question);
                setTimeout(() => { createInputField(0); }, 1000);
            }, 1000);
        });
    </script>
</body>
</html><!DOCTYPE html>
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
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            color: white;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
            position: relative;
            overflow: hidden;
        }

        .gradient-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background:
                radial-gradient(circle at 20% 20%, rgba(59, 130, 246, 0.15) 0%, transparent 40%),
                radial-gradient(circle at 80% 80%, rgba(139, 92, 246, 0.15) 0%, transparent 40%);
            z-index: 0;
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

        .pattern-bg {
            background-image:
                radial-gradient(circle at 2px 2px, rgba(255,255,255,0.05) 1px, transparent 0);
            background-size: 20px 20px;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
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
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%,100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        .pulse-glow {
            animation: pulseGlow 2s ease-in-out infinite alternate;
        }

        @keyframes pulseGlow {
            from { box-shadow: 0 0 20px rgba(59,130,246,0.4); }
            to { box-shadow: 0 0 30px rgba(59,130,246,0.8); }
        }
    </style>
</head>
<body class="gradient-bg">
    <!-- Background Pattern -->
    <div class="pattern-bg"></div>

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
    <div class="content-container min-h-screen py-8 px-4 sm:px-6">
        <!-- Header -->
        <div class="max-w-md mx-auto mb-8 animate-fade-in">
            <div class="liquid-glass text-center">
                <div class="flex items-center justify-center mb-3">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center shadow-lg">
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
        <div class="max-w-2xl mx-auto">
            <div id="chatContainer" class="space-y-4 mb-6 min-h-[400px]"></div>

            <!-- Typing Indicator -->
            <div class="typing-indicator flex items-start space-x-3 mb-6">
                <div class="w-12 h-12 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm">AI</div>
                <div class="liquid-glass-dark rounded-2xl rounded-tl-sm p-4">
                    <div class="flex space-x-2">
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
                    <div class="liquid-glass rounded-2xl p-4 border border-red-300 mb-6 animate-fade-in">
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
                <div id="inputContainer" class="input-container"></div>
            </form>
        </div>

        <!-- QR Preview -->
        <div id="qrPreview" class="max-w-md mx-auto mt-8" style="display: none;">
            <div class="liquid-glass text-center animate-fade-in">
                <h3 class="text-white font-bold mb-4">Your QR Code</h3>
                <div class="bg-white p-3 rounded-xl inline-block mb-3">
                    <img src="{{ route('qr.generate', $qrCode->uuid) }}" alt="QR Code" class="w-32 h-32 mx-auto">
                </div>
                <p class="text-white/80 text-sm">Code: {{ $qrCode->code }}</p>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-8 max-w-md mx-auto">
            <div class="liquid-glass-dark p-3 text-xs text-white/60">
                By claiming this profile, you agree to our
                <a href="#" class="text-blue-300 hover:text-blue-200 transition-colors">Terms of Service</a> and
                <a href="#" class="text-blue-300 hover:text-blue-200 transition-colors">Privacy Policy</a>
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
                    messageDiv.className = 'chat-bubble user flex items-start space-x-3 justify-end';
                    messageDiv.innerHTML = `
                        <div class="liquid-glass-dark rounded-2xl rounded-tr-sm p-4 max-w-md">
                            <p class="text-white">${message}</p>
                        </div>
                        <div class="w-12 h-12 rounded-full bg-gradient-to-r from-green-500 to-teal-600 flex items-center justify-center text-white font-bold text-sm">You</div>
                    `;
                } else {
                    messageDiv.className = 'chat-bubble flex items-start space-x-3';
                    messageDiv.style.setProperty('--delay', delay);
                    messageDiv.innerHTML = `
                        <div class="w-12 h-12 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm">AI</div>
                        <div class="liquid-glass-dark rounded-2xl rounded-tl-sm p-4 max-w-md">
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
                    <div class="liquid-glass p-6">
                        <textarea id="currentInput" placeholder="${stepData.placeholder}" class="liquid-input resize-none" rows="3"></textarea>
                        <button type="button" onclick="processAnswer()" class="liquid-btn">Continue →</button>
                    </div>
                `;
            } else {
                inputHTML = `
                    <div class="liquid-glass p-6">
                        <input type="${stepData.type}" id="currentInput" placeholder="${stepData.placeholder}" class="liquid-input">
                        <button type="button" onclick="processAnswer()" class="liquid-btn">Continue →</button>
                    </div>
                `;
            }

            container.innerHTML = inputHTML;
            container.classList.add('active');

            setTimeout(() => {
                document.getElementById('currentInput').focus();
            }, 100);

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
                            <div class="liquid-glass p-6 text-center">
                                <div class="mb-4">
                                    <div class="w-16 h-16 bg-gradient-to-r from-green-400 to-blue-500 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
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

        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                addChatMessage(conversation[0].question);
                setTimeout(() => { createInputField(0); }, 1000);
            }, 1000);
        });
    </script>
</body>
</html>
