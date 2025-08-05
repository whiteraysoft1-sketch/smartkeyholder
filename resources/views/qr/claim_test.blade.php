<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Claim Test</title>
    @vite(['resources/css/app.css', 'resources/css/liquid-glass.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'SF Pro Display', 'Inter', system-ui, sans-serif;
            background: linear-gradient(135deg, #0A0A0B 0%, #1C1C1E 25%, #2C2C2E 75%, #1A1A1C 100%);
            min-height: 100vh;
            color: white;
            padding: 2rem;
        }

        .liquid-glass {
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(40px) saturate(180%);
            -webkit-backdrop-filter: blur(40px) saturate(180%);
            border-radius: 28px;
            border: 1px solid rgba(255, 255, 255, 0.25);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4);
            padding: 2rem;
            margin: 2rem auto;
            max-width: 500px;
        }

        .liquid-input {
            width: 100%;
            padding: 1rem 1.25rem;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(20px) saturate(150%);
            -webkit-backdrop-filter: blur(20px) saturate(150%);
            border-radius: 16px;
            border: 1.5px solid rgba(255, 255, 255, 0.2);
            color: white;
            font-size: 1rem;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
        }

        .liquid-input:focus {
            outline: none;
            border-color: #007AFF;
            box-shadow: 0 0 0 4px rgba(0, 122, 255, 0.15);
        }

        .liquid-input::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .liquid-btn {
            width: 100%;
            padding: 1rem 1.5rem;
            background: linear-gradient(135deg, #007AFF 0%, #AF52DE 100%);
            border-radius: 16px;
            border: none;
            color: white;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .liquid-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 16px 48px rgba(0, 122, 255, 0.4);
        }

        .test-container {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
        }
    </style>
</head>
<body>
    <div class="liquid-glass">
        <h1 class="text-2xl font-bold mb-6 text-center">QR Claim Input Test</h1>
        
        <div class="test-container">
            <div class="mb-4">
                <label class="block text-white/80 text-sm font-medium mb-2">Name</label>
                <input
                    type="text"
                    placeholder="Enter your name"
                    class="liquid-input"
                >
            </div>
            
            <div class="mb-4">
                <label class="block text-white/80 text-sm font-medium mb-2">Email</label>
                <input
                    type="email"
                    placeholder="Enter your email"
                    class="liquid-input"
                >
            </div>
            
            <button type="button" class="liquid-btn">
                Test Button
            </button>
        </div>
    </div>

    <div class="liquid-glass">
        <h2 class="text-xl font-bold mb-4">Debug Info</h2>
        <p class="text-sm text-white/70 mb-2">If you can see the input fields above, the CSS is working correctly.</p>
        <p class="text-sm text-white/70 mb-2">QR Code UUID: {{ $qrCode->uuid ?? 'Not provided' }}</p>
        <p class="text-sm text-white/70">QR Code: {{ $qrCode->code ?? 'Not provided' }}</p>
    </div>

    <script>
        console.log('Test page loaded');
        console.log('Input fields visible:', document.querySelectorAll('.liquid-input').length);
    </script>
</body>
</html>