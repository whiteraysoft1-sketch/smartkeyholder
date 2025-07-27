<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Install Wizard - Confirm</title>
    <link rel="stylesheet" href="/css/liquid-glass.css">
    <style>
        body { background: linear-gradient(135deg, #e0e7ff 0%, #f3f4f6 100%); min-height: 100vh; }
        .wizard-card { max-width: 400px; margin: 2rem auto; border-radius: 1.5rem; box-shadow: 0 8px 32px 0 rgba(31,38,135,0.18); background: rgba(255,255,255,0.85); padding: 2rem; }
    </style>
</head>
<body>
    <div class="wizard-card">
        <h2 class="text-xl font-bold mb-4 text-center">Confirm Upload</h2>
        <p class="mb-2">Step 2: Confirm the contents of your zip file:</p>
        <ul class="mb-4 text-sm bg-white/60 rounded-lg p-3 max-h-40 overflow-auto">
            @foreach($fileList as $file)
                <li>{{ $file }}</li>
            @endforeach
        </ul>
        <form action="{{ route('install-wizard.extract', ['zip' => $zip]) }}" method="POST">
            @csrf
            <button type="submit" class="liquid-btn"><i class="fas fa-box-open mr-2"></i>Extract & Install</button>
        </form>
    </div>
</body>
</html>
