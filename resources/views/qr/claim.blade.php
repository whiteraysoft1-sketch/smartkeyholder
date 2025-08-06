<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Claim Your Smart KeyHolder - {{ setting('site_name', 'Smart KeyHolder') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-center">
                    <div class="flex items-center justify-center mb-6">
                        <div class="w-16 h-16 rounded-full bg-gradient-to-br from-blue-500 via-purple-500 to-pink-500 flex items-center justify-center shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                            </svg>
                        </div>
                    </div>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-3">
                        Claim Your Smart KeyHolder
                    </h1>
                    <p class="text-gray-600 text-lg">Set up your digital profile in just a few steps</p>
                    <div class="mt-4 flex items-center justify-center space-x-2">
                        <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                        <span class="text-green-600 text-sm font-medium">Ready to Setup</span>
                    </div>
                </div>
            </div>

            <!-- Progress Bar -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-gray-700">Setup Progress</span>
                        <span class="text-sm text-gray-500" id="progressText">Step 1 of 8</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" id="progressBar" style="width: 12.5%"></div>
                    </div>
                </div>
            </div>

            <!-- Chat Container -->
            <div class="space-y-6 mb-6" id="chatContainer">
                <!-- Messages will be added here -->
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('qr.claim.process', $qrCode->uuid) }}" id="claimForm">
                @csrf
                @if ($errors->any())
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6 border-l-4 border-red-400 bg-red-50">
                            <div class="flex items-center text-red-800 mb-2">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="font-semibold">Please fix the following:</span>
                            </div>
                            <ul class="list-disc list-inside text-red-700 text-sm space-y-1">
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
                <div id="inputContainer" class="input-container hidden"></div>
            </form>

            <!-- Footer -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-4 text-center">
                    <div class="flex items-center justify-center mb-2">
                        <svg class="w-4 h-4 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-green-600 font-medium text-sm">Secure & Private</span>
                    </div>
                    <p class="text-xs text-gray-500">
                        By claiming this profile, you agree to our
                        <a href="#" class="text-blue-600 hover:text-blue-500 font-medium">Terms of Service</a> and
                        <a href="#" class="text-blue-600 hover:text-blue-500 font-medium">Privacy Policy</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentStep = 0;
        let conversationData = {};
        const conversation = [
            {
                question: "Hello! Welcome to your new Smart KeyHolder! 🎉 What's your name?",
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

        function updateProgress() {
            const progress = ((currentStep + 1) / conversation.length) * 100;
            document.getElementById('progressBar').style.width = progress + '%';
            document.getElementById('progressText').textContent = `Step ${currentStep + 1} of ${conversation.length}`;
        }

        function addChatMessage(message, isUser = false, delay = 0) {
            setTimeout(() => {
                const chatContainer = document.getElementById('chatContainer');
                const messageDiv = document.createElement('div');
                messageDiv.className = 'bg-white overflow-hidden shadow-sm sm:rounded-lg chat-message';

                if (isUser) {
                    messageDiv.innerHTML = `
                        <div class="p-4 sm:p-6">
                            <div class="flex items-start space-x-4 justify-end">
                                <div class="bg-blue-50 rounded-lg p-4 max-w-md border border-blue-200">
                                    <p class="text-gray-900 font-medium">${message}</p>
                                </div>
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center text-white font-bold text-sm shadow-lg">
                                    You
                                </div>
                            </div>
                        </div>
                    `;
                } else {
                    messageDiv.innerHTML = `
                        <div class="p-4 sm:p-6">
                            <div class="flex items-start space-x-4">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm shadow-lg">
                                    AI
                                </div>
                                <div class="bg-gray-50 rounded-lg p-4 max-w-md border border-gray-200">
                                    <p class="text-gray-900 font-medium">${message}</p>
                                </div>
                            </div>
                        </div>
                    `;
                }

                chatContainer.appendChild(messageDiv);
                messageDiv.scrollIntoView({ behavior: 'smooth' });
            }, delay);
        }

        function showTypingIndicator() {
            const chatContainer = document.getElementById('chatContainer');
            const typingDiv = document.createElement('div');
            typingDiv.className = 'bg-white overflow-hidden shadow-sm sm:rounded-lg typing-indicator';
            typingDiv.id = 'typingIndicator';
            typingDiv.innerHTML = `
                <div class="p-4 sm:p-6">
                    <div class="flex items-start space-x-4">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm shadow-lg">
                            AI
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <div class="flex space-x-2">
                                <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"></div>
                                <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                                <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            chatContainer.appendChild(typingDiv);
            typingDiv.scrollIntoView({ behavior: 'smooth' });
        }

        function hideTypingIndicator() {
            const typingIndicator = document.getElementById('typingIndicator');
            if (typingIndicator) {
                typingIndicator.remove();
            }
        }

        function createInputField(step) {
            const stepData = conversation[step];
            const container = document.getElementById('inputContainer');
            
            let inputHTML;
            if (stepData.type === 'textarea') {
                inputHTML = `
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-4 sm:p-6">
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-medium mb-2">Your Response</label>
                                <textarea
                                    id="currentInput"
                                    placeholder="${stepData.placeholder}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 resize-none"
                                    rows="4"
                                ></textarea>
                            </div>
                            <button
                                type="button"
                                onclick="processAnswer()"
                                class="w-full flex items-center justify-center px-4 py-2 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors"
                            >
                                <span class="mr-2">Continue</span>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                `;
            } else {
                inputHTML = `
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-4 sm:p-6">
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-medium mb-2">Your Response</label>
                                <input
                                    type="${stepData.type}"
                                    id="currentInput"
                                    placeholder="${stepData.placeholder}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                >
                            </div>
                            <button
                                type="button"
                                onclick="processAnswer()"
                                class="w-full flex items-center justify-center px-4 py-2 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors"
                            >
                                <span class="mr-2">Continue</span>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                `;
            }
            
            container.innerHTML = inputHTML;
            container.classList.remove('hidden');
            container.classList.add('block');

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
                    input.classList.add('border-red-500');
                    input.classList.remove('border-gray-300');
                    
                    // Show error message
                    let errorDiv = input.parentNode.querySelector('.error-message');
                    if (!errorDiv) {
                        errorDiv = document.createElement('div');
                        errorDiv.className = 'error-message text-red-600 text-sm mt-1';
                        input.parentNode.appendChild(errorDiv);
                    }
                    errorDiv.textContent = stepData.errorMessage;
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
            document.getElementById('inputContainer').classList.add('hidden');
            
            setTimeout(() => {
                showTypingIndicator();
                setTimeout(() => {
                    hideTypingIndicator();
                    const response = stepData.response(value);
                    addChatMessage(response);
                    setTimeout(() => {
                        currentStep++;
                        updateProgress();
                        if (currentStep < conversation.length) {
                            showTypingIndicator();
                            setTimeout(() => {
                                hideTypingIndicator();
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
            showTypingIndicator();
            setTimeout(() => {
                hideTypingIndicator();
                addChatMessage("🎉 Fantastic! You're all set up. Let me create your Smart KeyHolder profile now...");
                setTimeout(() => {
                    addChatMessage("Your Smart KeyHolder is ready! Click below to activate it and start sharing your digital identity. 🚀");
                    setTimeout(() => {
                        const container = document.getElementById('inputContainer');
                        container.innerHTML = `
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                <div class="p-6 text-center">
                                    <div class="mb-8">
                                        <div class="w-20 h-20 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                        <h3 class="text-2xl font-bold text-gray-900 mb-3">Ready to Launch! 🎉</h3>
                                        <p class="text-gray-600 text-base mb-2">Your Smart KeyHolder is configured and ready</p>
                                        <div class="flex items-center justify-center space-x-6 text-sm text-gray-500 mb-6">
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                30-day free trial
                                            </div>
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                No credit card required
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" onclick="submitClaimForm()" class="w-full flex items-center justify-center px-6 py-3 bg-green-600 text-white font-bold text-lg rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors">
                                        <span class="mr-3">🚀 Activate My Smart KeyHolder</span>
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        `;
                        container.classList.remove('hidden');

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
            document.getElementById('hiddenName').value = conversationData.name || '';
            document.getElementById('hiddenEmail').value = conversationData.email || '';
            document.getElementById('hiddenPassword').value = conversationData.password || '';
            document.getElementById('hiddenPasswordConfirmation').value = conversationData.password_confirmation || '';
            document.getElementById('hiddenProfession').value = conversationData.profession || '';
            document.getElementById('hiddenPhone').value = conversationData.phone || '';
            document.getElementById('hiddenWebsite').value = conversationData.website || '';
            document.getElementById('hiddenLocation').value = conversationData.location || '';
            document.getElementById('hiddenBio').value = conversationData.bio || '';

            // Get the submit button and change its text to show loading state
            const submitButton = document.querySelector('button[onclick="submitClaimForm()"]');
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
            updateProgress();
            
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