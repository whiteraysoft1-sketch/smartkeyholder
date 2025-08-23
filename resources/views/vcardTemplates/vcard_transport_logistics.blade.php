<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $profile->display_name ?? $user->name ?? 'Transport & Logistics' }} - Digital Business Card</title>
    <meta name="description" content="{{ $profile->bio ?? 'Professional transport and logistics services digital business card' }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .logistics-gradient {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #f59e0b 100%);
            background-size: 200% 200%;
            animation: gradientFlow 15s ease infinite;
        }
        @keyframes gradientFlow {
            0% { background-position: 0% 50% }
            50% { background-position: 100% 50% }
            100% { background-position: 0% 50% }
        }
        .logistics-card {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(12px);
            border-radius: 2rem;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        .logistics-card:hover {
            transform: translateY(-5px);
        }
        .service-badge {
            background: linear-gradient(90deg, #1e40af 0%, #f59e0b 100%);
            color: #fff;
            border-radius: 1rem;
            padding: 0.5rem 1rem;
            font-size: 0.95rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 4px 12px rgba(37,99,235,0.15);
            transition: all 0.3s ease;
        }
        .service-badge:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(37,99,235,0.2);
        }
        .divider {
            border-bottom: 1px solid rgba(37,99,235,0.1);
            margin: 1.5rem 0 1rem 0;
        }
        .tracking-section {
            background: rgba(37,99,235,0.05);
            border-radius: 1rem;
            padding: 1rem;
            margin-top: 1rem;
        }
        .tracking-input {
            border: 2px solid rgba(37,99,235,0.2);
            border-radius: 0.75rem;
            padding: 0.75rem 1rem;
            width: 100%;
            transition: all 0.3s ease;
        }
        .tracking-input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59,130,246,0.1);
        }
        .logistics-stat {
            background: white;
            border-radius: 1rem;
            padding: 1rem;
            text-align: center;
            box-shadow: 0 4px 12px rgba(37,99,235,0.05);
            transition: transform 0.3s ease;
        }
        .logistics-stat:hover {
            transform: translateY(-2px);
        }
        .contact-button {
            background: linear-gradient(90deg, #1e40af 0%, #f59e0b 100%);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.75rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(37,99,235,0.15);
        }
        .contact-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(37,99,235,0.2);
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
    </style>
</head>
<body class="logistics-gradient min-h-screen flex items-center justify-center p-2 sm:p-4">
    <div class="w-full max-w-md mx-auto">
        <div class="logistics-card overflow-hidden">
            @if($profile->background_image)
            <!-- Header with Background Image -->
            <div class="relative w-full h-48 bg-cover bg-center" style="background-image: url('{{ $profile->background_image_url }}');">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-black/20"></div>
                <div class="absolute inset-0 bg-gradient-to-br from-blue-600/40 via-yellow-400/30 to-blue-700/40"></div>
                
                <!-- Profile Image Overlapping -->
                <div class="absolute -bottom-12 left-1/2 transform -translate-x-1/2">
                    <img src="{{ $profile->full_profile_image_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name ?? 'TL') . '&background=2563eb&color=fff&size=128' }}" class="w-24 h-24 sm:w-28 sm:h-28 rounded-full border-4 border-white shadow-lg object-cover" alt="Profile Photo">
                </div>
                
            </div>
            <!-- Spacer and Profile Info -->
            <div class="pt-16 pb-4 px-4 sm:px-6 text-center">
                <div class="text-xl sm:text-2xl font-bold tracking-tight text-gray-800 mb-1">{{ $profile->display_name ?? $user->name ?? 'Transport & Logistics' }}</div>
                <div class="text-blue-700 text-base font-medium mb-1">{{ $profile->profession ?? 'Transport & Logistics' }}</div>
                <!-- Call and Email Action Buttons -->
                <div class="flex items-center justify-center space-x-4 mb-4">
                    @if($profile->phone)
                    <a href="tel:{{ $profile->phone }}" 
                       class="flex items-center justify-center bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-full font-semibold text-sm transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                        <i class="fas fa-phone mr-2"></i>
                        Call
                    </a>
                    @endif
                    
                    @if($profile->email ?? $user->email)
                    <a href="mailto:{{ $profile->email ?? $user->email }}" 
                       class="flex items-center justify-center bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-full font-semibold text-sm transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                        <i class="fas fa-envelope mr-2"></i>
                        Email
                    </a>
                    @endif
                </div>
                
                @if($profile->location ?? null)
                <div class="text-gray-600 text-xs flex items-center justify-center gap-1"><i class="fas fa-map-marker-alt text-blue-600"></i> {{ $profile->location }}</div>
                @endif
            </div>
            @else
            <!-- Header without Background Image -->
            <div class="flex flex-col items-center pt-7 pb-4 px-4 sm:px-6 bg-gradient-to-br from-blue-600/90 to-yellow-400/80">
                <img src="{{ $profile->full_profile_image_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name ?? 'TL') . '&background=2563eb&color=fff&size=128' }}" class="w-24 h-24 sm:w-28 sm:h-28 rounded-full border-4 border-white shadow-lg object-cover" alt="Profile Photo">
                <div class="mt-3 text-white text-xl sm:text-2xl font-bold tracking-tight drop-shadow-lg text-center">{{ $profile->display_name ?? $user->name ?? 'Transport & Logistics' }}</div>
                <div class="text-blue-100 text-base font-medium mt-1 text-center">{{ $profile->profession ?? 'Transport & Logistics' }}</div>
                @if($profile->location ?? null)
                <div class="text-blue-200 text-xs mt-1 flex items-center gap-1"><i class="fas fa-map-marker-alt"></i> {{ $profile->location }}</div>
                @endif
            </div>
            @endif
            <div class="px-4 sm:px-6 py-4">
                <div class="text-base text-blue-900/90 font-semibold mb-2 flex items-center gap-2"><i class="fas fa-truck-moving text-blue-500"></i> About Us</div>
                <div class="text-blue-800/80 text-sm mb-4">{{ $profile->bio ?? 'Reliable and efficient transport & logistics solutions for your business.' }}</div>
                <div class="divider"></div>
                <!-- Services Offered Section -->
                <div class="mb-4">
                    <div class="text-base text-blue-900/90 font-semibold mb-2 flex items-center gap-2"><i class="fas fa-shipping-fast text-yellow-500"></i> Services Offered</div>
                    <div class="flex flex-wrap gap-2">
                        @if($profile->services ?? null)
                            @foreach(explode(',', $profile->services) as $service)
                                <span class="service-badge"><i class="fas fa-check-circle"></i> {{ trim($service) }}</span>
                            @endforeach
                        @else
                            <span class="service-badge"><i class="fas fa-truck"></i> Freight Transport</span>
                            <span class="service-badge"><i class="fas fa-ship"></i> Shipping</span>
                            <span class="service-badge"><i class="fas fa-warehouse"></i> Warehousing</span>
                            <span class="service-badge"><i class="fas fa-route"></i> Route Planning</span>
                        @endif
                    </div>
                </div>
                <!-- Shipment Tracking Section -->
                <div class="tracking-section mb-4">
                    <div class="text-base text-blue-900/90 font-semibold mb-3 flex items-center gap-2">
                        <i class="fas fa-search-location text-blue-600"></i> Track Your Shipment
                    </div>
                    <div class="flex gap-2">
                        <input type="text" placeholder="Enter tracking number" class="tracking-input" id="trackingInput">
                        <button onclick="checkTracking()" class="contact-button whitespace-nowrap">
                            <i class="fas fa-search"></i> Track
                        </button>
                    </div>
                    <div id="trackingResult" class="hidden mt-3 text-sm"></div>
                </div>

                <!-- Key Statistics -->
                <div class="grid grid-cols-3 gap-3 mb-4">
                    <div class="logistics-stat">
                        <div class="text-2xl font-bold text-blue-600">{{ $profile->stats_deliveries ?? '1K+' }}</div>
                        <div class="text-xs text-gray-600">Deliveries</div>
                    </div>
                    <div class="logistics-stat">
                        <div class="text-2xl font-bold text-blue-600">{{ $profile->stats_countries ?? '15+' }}</div>
                        <div class="text-xs text-gray-600">Countries</div>
                    </div>
                    <div class="logistics-stat">
                        <div class="text-2xl font-bold text-blue-600">{{ $profile->stats_clients ?? '500+' }}</div>
                        <div class="text-xs text-gray-600">Clients</div>
                    </div>
                </div>

                <div class="divider"></div>
                @if($socialLinks->count() > 0)
                <div class="flex gap-2 sm:gap-3 justify-center mb-4 flex-wrap">
                    @foreach($socialLinks as $link)
                        <a href="{{ $link->url }}" target="_blank" class="w-9 h-9 sm:w-10 sm:h-10 flex items-center justify-center rounded-full bg-white/80 hover:bg-blue-100/80 shadow text-blue-700 text-lg transition" title="{{ ucfirst($link->platform) }}">
                            @switch($link->platform)
                                @case('linkedin')<i class="fab fa-linkedin-in"></i>@break
                                @case('twitter')<i class="fab fa-twitter"></i>@break
                                @case('github')<i class="fab fa-github"></i>@break
                                @case('instagram')<i class="fab fa-instagram"></i>@break
                                @case('facebook')<i class="fab fa-facebook-f"></i>@break
                                @case('youtube')<i class="fab fa-youtube"></i>@break
                                @case('tiktok')<i class="fab fa-tiktok"></i>@break
                                @case('whatsapp')<i class="fab fa-whatsapp"></i>@break
                                @default<i class="fas fa-link"></i>
                            @endswitch
                        </a>
                    @endforeach
                </div>
                @endif
                <div class="grid grid-cols-1 gap-2 mb-4">
                    @if($profile->phone ?? null)
                    <div class="flex items-center gap-2 text-blue-900/80 text-sm"><i class="fas fa-phone"></i> <a href="tel:{{ $profile->phone }}" class="hover:underline">{{ $profile->phone }}</a></div>
                    @endif
                    @if($user->email)
                    <div class="flex items-center gap-2 text-blue-900/80 text-sm"><i class="fas fa-envelope"></i> <a href="mailto:{{ $user->email }}" class="hover:underline">{{ $user->email }}</a></div>
                    @endif
                    @if($profile->website ?? null)
                    <div class="flex items-center gap-2 text-blue-900/80 text-sm"><i class="fas fa-globe"></i> <a href="{{ $profile->website }}" target="_blank" class="hover:underline">{{ str_replace(['http://', 'https://'], '', $profile->website) }}</a></div>
                    @endif
                </div>
                @if($galleryItems->count() > 0)
                <div class="mb-4">
                    <div class="text-base text-blue-900/90 font-semibold mb-2 flex items-center gap-2"><i class="fas fa-images text-yellow-500"></i> Gallery</div>
                    <div class="grid grid-cols-2 gap-2">
                        @foreach($galleryItems as $item)
                        <div class="rounded-xl overflow-hidden shadow cursor-pointer group relative" onclick="openGalleryModal('{{ $item->full_image_url }}', '{{ $item->title }}', '{{ $item->description }}')">
                            <img src="{{ $item->full_image_url }}" alt="{{ $item->title }}" class="w-full h-20 sm:h-24 object-cover group-hover:scale-105 transition">
                            @if($item->title)
                            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-blue-900/80 to-transparent text-white text-xs px-2 py-1">{{ $item->title }}</div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
                <div class="flex flex-col gap-2 mt-4">
                    <button class="w-full py-2 rounded-xl bg-gradient-to-r from-blue-600 to-yellow-500 text-white font-semibold shadow hover:from-blue-700 hover:to-yellow-600 transition text-base flex items-center justify-center gap-2" onclick="saveContact()"><i class="fas fa-address-card"></i> Save Contact</button>
                </div>
            </div>
        </div>
    </div>
    <div id="galleryModal" class="fixed top-0 left-0 w-full h-full bg-black/90 z-50 items-center justify-center p-2 sm:p-4" style="display: none;">
        <div class="bg-white rounded-2xl max-w-lg w-full max-h-full overflow-auto relative">
            <div class="flex justify-between items-center p-4 border-b">
                <h3 id="galleryModalTitle" class="text-lg font-bold text-blue-900"></h3>
                <button onclick="closeGalleryModal()" class="text-2xl text-blue-700 hover:text-blue-900">&times;</button>
            </div>
            <img id="galleryModalImage" src="" alt="" class="w-full object-contain rounded-b-2xl" style="max-height:60vh;">
            <div class="p-4 text-blue-800 text-sm" id="galleryModalDescription"></div>
        </div>
    </div>
    <script>
        function saveContact() {
            const name = "{{ $profile->display_name ?? $user->name ?? 'Transport & Logistics' }}";
            const title = "{{ $profile->profession ?? 'Transport & Logistics' }}";
            const email = "{{ $user->email ?? '' }}";
            const phone = "{{ $profile->phone ?? '' }}";
            const website = "{{ $profile->website ?? '' }}";
            const location = "{{ $profile->location ?? '' }}";
            const bio = `{{ $profile->bio ?? '' }}`;
            const organization = "{{ $profile->company_name ?? '' }}";
            
            const vcard = `BEGIN:VCARD
VERSION:3.0
FN:${name}
ORG:${organization}
TITLE:${title}
EMAIL:${email}
TEL:${phone}
URL:${website}
ADR:;;${location};;;;
NOTE:${bio}
END:VCARD`;
            
            const blob = new Blob([vcard], { type: 'text/vcard' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `${name.replace(/\s+/g, '_')}_contact.vcf`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            window.URL.revokeObjectURL(url);
            
            // Show success message
            const successMessage = document.createElement('div');
            successMessage.className = 'fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg';
            successMessage.textContent = 'Contact saved successfully!';
            document.body.appendChild(successMessage);
            setTimeout(() => successMessage.remove(), 3000);
        }
        
        function checkTracking() {
            const trackingNumber = document.getElementById('trackingInput').value.trim();
            const resultDiv = document.getElementById('trackingResult');
            
            if (!trackingNumber) {
                showTrackingError('Please enter a tracking number');
                return;
            }
            
            // Simulate tracking status - In a real implementation, this would call your tracking API
            const statuses = [
                { status: 'In Transit', location: 'Distribution Center', eta: '2 days' },
                { status: 'Out for Delivery', location: 'Local Hub', eta: 'Today' },
                { status: 'Delivered', location: 'Destination', eta: 'Completed' }
            ];
            
            const randomStatus = statuses[Math.floor(Math.random() * statuses.length)];
            
            resultDiv.innerHTML = `
                <div class="bg-white rounded-lg p-3 shadow-sm">
                    <div class="flex items-center gap-2 text-blue-600 font-medium mb-2">
                        <i class="fas fa-truck-loading"></i>
                        Status: ${randomStatus.status}
                    </div>
                    <div class="text-gray-600 text-xs space-y-1">
                        <div><i class="fas fa-map-marker-alt text-blue-500 mr-2"></i>Location: ${randomStatus.location}</div>
                        <div><i class="fas fa-clock text-blue-500 mr-2"></i>ETA: ${randomStatus.eta}</div>
                    </div>
                </div>
            `;
            
            resultDiv.classList.remove('hidden');
            resultDiv.classList.add('animate-fade-in');
        }
        
        function showTrackingError(message) {
            const resultDiv = document.getElementById('trackingResult');
            resultDiv.innerHTML = `
                <div class="text-red-500 bg-red-50 rounded-lg p-3">
                    <i class="fas fa-exclamation-circle mr-2"></i>${message}
                </div>
            `;
            resultDiv.classList.remove('hidden');
        }
        function openGalleryModal(imageUrl, title, description) {
            document.getElementById('galleryModalImage').src = imageUrl;
            document.getElementById('galleryModalTitle').textContent = title || 'Gallery Image';
            document.getElementById('galleryModalDescription').textContent = description || '';
            document.getElementById('galleryModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        function closeGalleryModal() {
            document.getElementById('galleryModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
        document.getElementById('galleryModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeGalleryModal();
            }
        });
    </script>
</body>
</html>

