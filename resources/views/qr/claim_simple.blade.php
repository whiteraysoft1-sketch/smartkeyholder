<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Claim Your Smart KeyHolder - WST V1</title>
    @vite(['resources/css/app.css'])
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #1e293b 0%, #334155 50%, #475569 100%);
            min-height: 100vh;
            color: white;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
        }

        .header h1 {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 10px;
            background: linear-gradient(135deg, #60a5fa, #a78bfa);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .header p {
            font-size: 1.1rem;
            opacity: 0.8;
        }

        .form-container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 40px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #e2e8f0;
            font-size: 0.95rem;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 15px 20px;
            background: rgba(255, 255, 255, 0.15);
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            color: white;
            font-size: 1rem;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #60a5fa;
            background: rgba(255, 255, 255, 0.2);
            box-shadow: 0 0 0 3px rgba(96, 165, 250, 0.2);
        }

        .form-group input::placeholder,
        .form-group textarea::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .required {
            color: #f87171;
        }

        .submit-btn {
            width: 100%;
            padding: 18px;
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            border: none;
            border-radius: 12px;
            color: white;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 20px;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(59, 130, 246, 0.4);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        .error-message {
            background: rgba(239, 68, 68, 0.2);
            border: 1px solid rgba(239, 68, 68, 0.5);
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            color: #fecaca;
        }

        .error-message ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .error-message li {
            margin-bottom: 5px;
        }

        .error-message li:before {
            content: "• ";
            color: #f87171;
            font-weight: bold;
        }

        .qr-info {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 30px;
            text-align: center;
        }

        .qr-info h3 {
            margin-bottom: 10px;
            color: #60a5fa;
        }

        .loading {
            opacity: 0.7;
            pointer-events: none;
        }

        .loading .submit-btn {
            background: #6b7280;
        }

        @media (max-width: 640px) {
            .container {
                padding: 10px;
            }
            
            .form-container {
                padding: 25px;
            }
            
            .header h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎉 Welcome!</h1>
            <p>Claim your Smart KeyHolder and create your digital profile</p>
        </div>

        <div class="qr-info">
            <h3>QR Code Information</h3>
            <p><strong>Code:</strong> {{ $qrCode->code }}</p>
            <p><strong>UUID:</strong> {{ $qrCode->uuid }}</p>
        </div>

        @if ($errors->any())
            <div class="error-message">
                <strong>Please fix the following errors:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="form-container">
            <form method="POST" action="{{ route('qr.claim.process', $qrCode->uuid) }}" id="claimForm">
                @csrf
                
                <div class="form-group">
                    <label for="name">Full Name <span class="required">*</span></label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        placeholder="Enter your full name"
                        value="{{ old('name') }}"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="email">Email Address <span class="required">*</span></label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        placeholder="your.email@example.com"
                        value="{{ old('email') }}"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="password">Password <span class="required">*</span></label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        placeholder="Create a secure password (min 8 characters)"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirm Password <span class="required">*</span></label>
                    <input 
                        type="password" 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        placeholder="Confirm your password"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="profession">Profession</label>
                    <input 
                        type="text" 
                        id="profession" 
                        name="profession" 
                        placeholder="e.g., Software Developer, Designer, Teacher"
                        value="{{ old('profession') }}"
                    >
                </div>

                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input 
                        type="tel" 
                        id="phone" 
                        name="phone" 
                        placeholder="+1 (555) 123-4567"
                        value="{{ old('phone') }}"
                    >
                </div>

                <div class="form-group">
                    <label for="website">Website</label>
                    <input 
                        type="url" 
                        id="website" 
                        name="website" 
                        placeholder="https://yourwebsite.com"
                        value="{{ old('website') }}"
                    >
                </div>

                <div class="form-group">
                    <label for="location">Location</label>
                    <input 
                        type="text" 
                        id="location" 
                        name="location" 
                        placeholder="e.g., New York, USA"
                        value="{{ old('location') }}"
                    >
                </div>

                <div class="form-group">
                    <label for="bio">Bio</label>
                    <textarea 
                        id="bio" 
                        name="bio" 
                        rows="4" 
                        placeholder="Tell people a bit about yourself..."
                    >{{ old('bio') }}</textarea>
                </div>

                <button type="submit" class="submit-btn" id="submitBtn">
                    🚀 Claim My Smart KeyHolder
                </button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('QR Claim page loaded successfully');
            
            const form = document.getElementById('claimForm');
            const submitBtn = document.getElementById('submitBtn');
            
            // Focus on first input
            const firstInput = document.getElementById('name');
            if (firstInput) {
                firstInput.focus();
            }
            
            // Form submission handling
            form.addEventListener('submit', function(e) {
                const name = document.getElementById('name').value.trim();
                const email = document.getElementById('email').value.trim();
                const password = document.getElementById('password').value;
                const passwordConfirm = document.getElementById('password_confirmation').value;
                
                // Basic validation
                if (!name) {
                    alert('Please enter your name');
                    document.getElementById('name').focus();
                    e.preventDefault();
                    return;
                }
                
                if (!email) {
                    alert('Please enter your email');
                    document.getElementById('email').focus();
                    e.preventDefault();
                    return;
                }
                
                if (!password || password.length < 8) {
                    alert('Password must be at least 8 characters long');
                    document.getElementById('password').focus();
                    e.preventDefault();
                    return;
                }
                
                if (password !== passwordConfirm) {
                    alert('Passwords do not match');
                    document.getElementById('password_confirmation').focus();
                    e.preventDefault();
                    return;
                }
                
                // Show loading state
                submitBtn.textContent = '⏳ Creating your profile...';
                submitBtn.disabled = true;
                document.body.classList.add('loading');
            });
            
            // Real-time password confirmation validation
            const passwordInput = document.getElementById('password');
            const confirmInput = document.getElementById('password_confirmation');
            
            function validatePasswordMatch() {
                if (confirmInput.value && passwordInput.value !== confirmInput.value) {
                    confirmInput.style.borderColor = '#f87171';
                } else {
                    confirmInput.style.borderColor = 'rgba(255, 255, 255, 0.2)';
                }
            }
            
            passwordInput.addEventListener('input', validatePasswordMatch);
            confirmInput.addEventListener('input', validatePasswordMatch);
        });
    </script>
</body>
</html>