<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Health Services - Uganda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    
        <meta name="msapplication-TileColor" content="#0ea5e9">
        @if($profile->pwa_icon)
            <meta name="msapplication-TileImage" content="{{ $profile->pwa_icon_url }}">
        @endif
    @endif
    <style>
        body {
            background: linear-gradient(135deg, #0ea5e9 0%, #38bdf8 100%);
            min-height: 100vh;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .glass-card {
            backdrop-filter: blur(16px) saturate(180%);
            -webkit-backdrop-filter: blur(16px) saturate(180%);
            background: rgba(255, 255, 255, 0.22);
            border-radius: 2rem;
            border: 1.5px solid #38bdf8;
            box-shadow: 0 8px 32px 0 rgba(14, 165, 233, 0.18);
            max-width: 410px;
            width: 100%;
            padding: 2.2rem 1.5rem 1.5rem 1.5rem;
            margin: 2rem auto;
        }
        .glass-header {
            text-align: left;
            margin-bottom: 1.5rem;
        }
        .avatar {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #38bdf8;
            box-shadow: 0 2px 8px rgba(14,165,233,0.12);
            float: left;
            margin-right: 1.2rem;
        }
        .glass-title {
            font-size: 1.6rem;
            font-weight: 700;
            color: #0e7490;
            margin-top: 0.5rem;
        }
        .glass-role {
            font-size: 1rem;
            color: #0ea5e9;
            margin-bottom: 0.5rem;
        }
        .section-title {
            color: #0ea5e9;
            font-size: 1.05rem;
            font-weight: 700;
            margin-bottom: 0.7rem;
            margin-top: 1.2rem;
            letter-spacing: 1px;
        }
        .glass-bio {
            color: #0e7490;
            font-size: 0.98rem;
            margin-bottom: 1.2rem;
            text-align: left;
            clear: both;
        }
        .glass-socials {
            display: flex;
            justify-content: flex-start;
            gap: 1.1rem;
            margin-bottom: 1.2rem;
        }
        .glass-socials a {
            color: #0ea5e9;
            font-size: 1.3rem;
            transition: color 0.2s;
        }
        .glass-socials a:hover {
            color: #38bdf8;
        }
        .glass-contact {
            background: rgba(255,255,255,0.55);
            border-radius: 1rem;
            padding: 0.8rem 1rem;
            box-shadow: 0 2px 8px rgba(14,165,233,0.04);
            margin-bottom: 1.2rem;
        }
        .glass-contact div {
            margin-bottom: 0.4rem;
            color: #0e7490;
            font-size: 0.97rem;
        }
        .glass-btn {
            display: block;
            width: 100%;
            padding: 0.7rem;
            background: linear-gradient(90deg, #0ea5e9 0%, #38bdf8 100%);
            color: #fff;
            font-weight: 600;
            border: none;
            border-radius: 1rem;
            font-size: 1.05rem;
            box-shadow: 0 2px 8px rgba(14,165,233,0.08);
            transition: background 0.2s;
        }
        .glass-btn:hover {
            background: linear-gradient(90deg, #38bdf8 0%, #0ea5e9 100%);
        }
        .glass-gallery {
            margin-top: 1.5rem;
        }
        .gallery-title {
            color: #0ea5e9;
            font-size: 1.05rem;
            font-weight: 600;
            margin-bottom: 0.7rem;
            text-align: left;
        }
        .gallery-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }
        .gallery-item {
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(14,165,233,0.06);
            cursor: pointer;
            position: relative;
        }
        .gallery-item img {
            width: 100%;
            height: 80px;
            object-fit: cover;
            transition: transform 0.2s;
        }
        .gallery-item:hover img {
            transform: scale(1.05);
        }
        .gallery-caption {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(transparent, rgba(14,165,233,0.7));
            color: #fff;
            font-size: 0.85rem;
            padding: 6px 10px 5px;
            font-weight: 500;
        }
        @media (max-width: 600px) {
            .glass-card { padding: 1.2rem 0.5rem; }
            .avatar { width: 70px; height: 70px; margin-right: 0.7rem; }
            .glass-title { font-size: 1.2rem; }
        }
    </style>
</head>
<body>
    <div class="glass-card">
        @if($profile->background_image)
        <!-- Header with Background Image -->
        <div class="relative w-full h-48 bg-cover bg-center rounded-t-2xl" style="background-image: url('{{ $profile->background_image_url }}');">
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-black/20 rounded-t-2xl"></div>
            <div class="absolute inset-0 bg-gradient-to-br from-sky-500/40 via-blue-500/30 to-sky-600/40 rounded-t-2xl"></div>
            
            <!-- Profile Image Overlapping -->
            <div class="absolute -bottom-12 left-6">
                <img src="{{ $profile->full_profile_image_url ?? 'https://via.placeholder.com/90x90/0ea5e9/ffffff?text=' . substr($user->name ?? 'HS', 0, 2) }}" alt="Avatar" class="avatar border-4 border-white">
            </div>
            
        </div>
        <!-- Spacer and Profile Info -->
        <div class="pt-16 pb-6 px-6">
            <div class="glass-title">{{ $profile->display_name ?? $user->name ?? 'Health Pro' }}</div>
            <div class="glass-role">{{ $profile->profession ?? 'Health Specialist' }}</div>
            <!-- Call and Email Action Buttons -->
            <div style="display: flex; align-items: center; justify-content: center; gap: 15px; margin: 20px 0;">
                @if($profile->phone)
                <a href="tel:{{ $profile->phone }}" 
                   style="display: flex; align-items: center; justify-content: center; background: #10b981; color: white; padding: 12px 24px; border-radius: 25px; font-weight: 600; font-size: 14px; text-decoration: none; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);"
                   onmouseover="this.style.background='#059669'; this.style.transform='scale(1.05)'"
                   onmouseout="this.style.background='#10b981'; this.style.transform='scale(1)'">
                    <i class="fas fa-phone" style="margin-right: 8px;"></i>
                    Call
                </a>
                @endif
                
                @if($profile->email ?? $user->email)
                <a href="mailto:{{ $profile->email ?? $user->email }}" 
                   style="display: flex; align-items: center; justify-content: center; background: #3b82f6; color: white; padding: 12px 24px; border-radius: 25px; font-weight: 600; font-size: 14px; text-decoration: none; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);"
                   onmouseover="this.style.background='#2563eb'; this.style.transform='scale(1.05)'"
                   onmouseout="this.style.background='#3b82f6'; this.style.transform='scale(1)'">
                    <i class="fas fa-envelope" style="margin-right: 8px;"></i>
                    Email
                </a>
                @endif
            </div>
            
        </div>
        @else
        <!-- Header without Background Image -->
        <div class="glass-header">
            <img src="{{ $profile->full_profile_image_url ?? 'https://via.placeholder.com/90x90/0ea5e9/ffffff?text=' . substr($user->name ?? 'HS', 0, 2) }}" alt="Avatar" class="avatar">
            <div style="overflow:hidden;">
                <div class="glass-title">{{ $profile->display_name ?? $user->name ?? 'Health Pro' }}</div>
                <div class="glass-role">{{ $profile->profession ?? 'Health Specialist' }}</div>
            </div>
        </div>
        @endif
        <div class="section-title">About Me</div>
        <div class="glass-bio">
            {{ $profile->bio ?? 'Dedicated to improving health and wellness in Uganda.' }}
        </div>
        @if($socialLinks->count() > 0)
        <div class="section-title">Connect With Me</div>
        <div class="glass-socials">
            @foreach($socialLinks as $link)
                <a href="{{ $link->url }}" target="_blank" title="{{ ucfirst($link->platform) }}">
                    @switch($link->platform)
                        @case('linkedin')
                            <i class="fab fa-linkedin-in"></i>
                            @break
                        @case('twitter')
                            <i class="fab fa-twitter"></i>
                            @break
                        @case('github')
                            <i class="fab fa-github"></i>
                            @break
                        @case('instagram')
                            <i class="fab fa-instagram"></i>
                            @break
                        @case('facebook')
                            <i class="fab fa-facebook-f"></i>
                            @break
                        @case('youtube')
                            <i class="fab fa-youtube"></i>
                            @break
                        @case('tiktok')
                            <i class="fab fa-tiktok"></i>
                            @break
                        @case('whatsapp')
                            <i class="fab fa-whatsapp"></i>
                            @break
                        @default
                            <i class="fas fa-link"></i>
                    @endswitch
                </a>
            @endforeach
        </div>
        @endif
        <div class="section-title">Contact Information</div>
        <div class="glass-contact">
            @if($profile->phone ?? null)
            <div><i class="fas fa-phone"></i> {{ $profile->phone }}</div>
            @endif
            @if($user->email)
            <div><i class="fas fa-envelope"></i> {{ $user->email }}</div>
            @endif
            @if($profile->website ?? null)
            <div><i class="fas fa-globe"></i> {{ str_replace(['http://', 'https://'], '', $profile->website) }}</div>
            @endif
            @if($profile->location ?? null)
            <div><i class="fas fa-map-marker-alt"></i> {{ $profile->location }}</div>
            @endif
        </div>
        @if($galleryItems->count() > 0)
        <div class="section-title">Gallery</div>
        <div class="glass-gallery">
            <div class="gallery-grid">
                @foreach($galleryItems as $item)
                <div class="gallery-item" onclick="openGalleryModal('{{ $item->full_image_url }}', '{{ $item->title }}', '{{ $item->description }}')">
                    <img src="{{ $item->full_image_url }}" alt="{{ $item->title }}">
                    @if($item->title)
                    <div class="gallery-caption">{{ $item->title }}</div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endif
        <div class="section-title">Actions</div>
        
        <button class="glass-btn" onclick="saveContact()"><i class="fas fa-address-card"></i> Save Contact</button>
    </div>
    <!-- Gallery Modal -->
    <div id="galleryModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.9); z-index: 9999; align-items: center; justify-content: center; padding: 20px;">
        <div style="background: white; border-radius: 20px; max-width: 90%; max-height: 90%; overflow: auto; position: relative;">
            <div style="padding: 20px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                    <h3 id="galleryModalTitle" style="margin: 0; color: #333; font-size: 18px; font-weight: 600;"></h3>
                    <button onclick="closeGalleryModal()" style="background: none; border: none; font-size: 24px; color: #666; cursor: pointer; padding: 5px;">&times;</button>
                </div>
                <img id="galleryModalImage" src="" alt="" style="width: 100%; max-height: 70vh; object-fit: contain; border-radius: 15px; margin-bottom: 15px;">
                <p id="galleryModalDescription" style="color: #666; margin: 0; line-height: 1.6;"></p>
            </div>
        </div>
    </div>
    <script>
        function saveContact() {
            const name = "{{ $profile->display_name ?? $user->name ?? 'Health Pro' }}";
            const title = "{{ $profile->profession ?? 'Health Specialist' }}";
            const email = "{{ $user->email ?? '' }}";
            const phone = "{{ $profile->phone ?? '' }}";
            const website = "{{ $profile->website ?? '' }}";
            const location = "{{ $profile->location ?? '' }}";
            const bio = `{{ $profile->bio ?? '' }}`;
            const vcard = `BEGIN:VCARD\nVERSION:3.0\nFN:${name}\nTITLE:${title}\nEMAIL:${email}\nTEL:${phone}\nURL:${website}\nADR:;;${location};;;;\nNOTE:${bio}\nEND:VCARD`;
            const blob = new Blob([vcard], { type: 'text/vcard' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `${name.replace(/\s+/g, '_')}_contact.vcf`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            window.URL.revokeObjectURL(url);
        }
        function openGalleryModal(imageUrl, title, description) {
            document.getElementById('galleryModalImage').src = imageUrl;
            document.getElementById('galleryModalTitle').textContent = title || 'Gallery Image';
            document.getElementById('galleryModalDescription').textContent = description || '';
            const modal = document.getElementById('galleryModal');
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }
        function closeGalleryModal() {
            const modal = document.getElementById('galleryModal');
            modal.style.display = 'none';
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

