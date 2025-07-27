<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Install Wizard - Upload Zip</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/css/liquid-glass.css">
    <style>
        body { background: linear-gradient(135deg, #e0e7ff 0%, #f3f4f6 100%); min-height: 100vh; }
        .wizard-card { max-width: 400px; margin: 2rem auto; border-radius: 1.5rem; box-shadow: 0 8px 32px 0 rgba(31,38,135,0.18); background: rgba(255,255,255,0.85); padding: 2rem; }
    </style>
</head>
<body>
    <div class="wizard-card">
        <h2 class="text-xl font-bold mb-4 text-center">Install Wizard</h2>
        <form action="{{ route('install-wizard.upload') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <label class="block font-semibold mb-2">Step 1: Upload your .zip file</label>
            <input type="file" name="zip_file" accept=".zip" required class="liquid-input">
            @error('zip_file')
                <div class="text-red-500 text-sm">{{ $message }}</div>
            @enderror
            <button type="submit" class="liquid-btn mt-4"><i class="fas fa-upload mr-2"></i>Upload & Continue</button>
        </form>
    </div>
</body>
</html>
