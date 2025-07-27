<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VCard Template 2</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

        <!-- Microsoft Tiles -->
        <meta name="msapplication-TileColor" content="{{ $profile->pwa_theme_color ?: '#ff6b6b' }}">
        @if($profile->pwa_icon)
            <meta name="msapplication-TileImage" content="{{ $profile->pwa_icon_url }}">
        @endif
    @endif
    
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: #f8f9fa;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }
        .vcard-container {
            max-width: 450px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .vcard-header {
            background: linear-gradient(45deg, #ff6b6b, #ffa500);
            padding: 30px 20px;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }
        .vcard-header.has-background {
            background-image: url('');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        .vcard-header.has-background::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 107, 107, 0.7);
            z-index: 1;
        }
        .vcard-header > * {
            position: relative;
            z-index: 2;
        }
        .profile-img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 4px solid white;
            margin-bottom: 15px;
            object-fit: cover;
        }
        .profile-name {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .profile-title {
            font-size: 16px;
            opacity: 0.9;
        }
        .vcard-body {
            padding: 25px;
        }
        .section-title {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin-bottom: 15px;
            border-bottom: 2px solid #ff6b6b;
            padding-bottom: 5px;
        }
        .contact-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 25px;
        }
        .contact-card {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            text-align: center;
            text-decoration: none;
            color: #333;
            transition: all 0.3s ease;
        }
        .contact-card:hover {
            background: #ff6b6b;
            color: white;
            transform: translateY(-3px);
        }
        .contact-card i {
            font-size: 24px;
            margin-bottom: 8px;
            display: block;
        }
        .contact-card .label {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }
        .contact-card .value {
            font-size: 14px;
            font-weight: 500;
        }
        .bio-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 25px;
        }
        .bio-text {
            color: #666;
            line-height: 1.6;
            margin: 0;
            font-style: italic;
        }
        .social-section {
            text-align: center;
        }
        .social-links {
            display: flex;
            justify-content: center;
            gap: 10px;
            flex-wrap: wrap;
        }
        .social-link {
            width: 50px;
            height: 50px;
            background: linear-gradient(45deg, #ff6b6b, #ffa500);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: white;
            transition: all 0.3s ease;
            font-size: 20px;
        }
        .social-link:hover {
            transform: scale(1.1) rotate(5deg);
            color: white;
        }
    </style>
</head>
<body>
    <div class="vcard-container">
        <!-- Header Section -->
        <div class="vcard-header @if($profile && $profile->hasBackgroundImage()) has-background @endif" 
             @if($profile && $profile->hasBackgroundImage()) style="background-image: url('{{ $profile->full_background_image_url }}');" @endif>
            <img src="{{ $profile->full_profile_image_url ?? 'https://via.placeholder.com/100x100/ff6b6b/ffffff?text=' . substr($user->name ?? 'U', 0, 2) }}" alt="Profile Photo" class="profile-img">
            <div class="profile-name">{{ $profile->display_name ?? $user->name ?? 'User Name' }}</div>
            <div class="profile-title">{{ $profile->profession ?? 'Professional' }}</div>
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

        <!-- Body Section -->
        <div class="vcard-body">
            <!-- Bio Section -->
            @if($profile->bio ?? null)
            <div class="section-title">About Me</div>
            <div class="bio-section">
                <p class="bio-text">{{ $profile->bio }}</p>
            </div>
            @endif

            <!-- Contact Information -->
            <div class="section-title">Contact Information</div>
            <div class="contact-grid">
                @if($profile->phone ?? null)
                <a href="tel:{{ $profile->phone }}" class="contact-card">
                    <i class="fas fa-phone"></i>
                    <div class="label">Phone</div>
                    <div class="value">{{ $profile->phone }}</div>
                </a>
                @endif

                @if($user->email)
                <a href="mailto:{{ $user->email }}" class="contact-card">
                    <i class="fas fa-envelope"></i>
                    <div class="label">Email</div>
                    <div class="value">{{ $user->email }}</div>
                </a>
                @endif

                @if($profile->website ?? null)
                <a href="{{ $profile->website }}" target="_blank" class="contact-card">
                    <i class="fas fa-globe"></i>
                    <div class="label">Website</div>
                    <div class="value">{{ str_replace(['http://', 'https://'], '', $profile->website) }}</div>
                </a>
                @endif

                @if($profile->location ?? null)
                <div class="contact-card">
                    <i class="fas fa-map-marker-alt"></i>
                    <div class="label">Location</div>
                    <div class="value">{{ $profile->location }}</div>
                </div>
                @endif
            </div>

            <!-- Social Links -->
            @if($socialLinks->count() > 0)
            <div class="section-title">Connect With Me</div>
            <div class="social-section">
                <div class="social-links">
                    @foreach($socialLinks as $link)
                        <a href="{{ $link->url }}" target="_blank" class="social-link" title="{{ ucfirst($link->platform) }}">
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
                                @case('dribbble')
                                    <i class="fab fa-dribbble"></i>
                                    @break
                                @case('behance')
                                    <i class="fab fa-behance"></i>
                                    @break
                                @default
                                    <i class="fas fa-link"></i>
                            @endswitch
                        </a>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Gallery Section -->
            @if($galleryItems->count() > 0)
            <div class="section-title">Gallery</div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 25px;">
                @foreach($galleryItems as $item)
                    <div style="position: relative; cursor: pointer; border-radius: 10px; overflow: hidden; transition: all 0.3s ease; background: #f8f9fa;" onclick="openGalleryModal('{{ $item->full_image_url }}', '{{ $item->title }}', '{{ $item->description }}')">
                        <img src="{{ $item->full_image_url }}" 
                             alt="{{ $item->title }}"
                             style="width: 100%; height: 120px; object-fit: cover; transition: transform 0.3s ease;"
                             onmouseover="this.style.transform='scale(1.05)'"
                             onmouseout="this.style.transform='scale(1)'">
                        @if($item->title)
                            <div style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(transparent, rgba(255, 107, 107, 0.9)); color: white; padding: 15px 10px 10px; font-size: 12px; font-weight: 500;">
                                {{ $item->title }}
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
            @endif
            
            <!-- Action Buttons Section -->
            <div class="section-title">Actions</div>
            <div style="text-align: center; margin-top: 20px;">

                <!-- Save Contact Button -->
                <button onclick="saveContact()" style="width: 100%; background: linear-gradient(45deg, #ff6b6b, #ffa500); color: white; border: none; padding: 15px 20px; border-radius: 10px; font-size: 16px; font-weight: 600; cursor: pointer; transition: all 0.3s ease;">
                    <i class="fas fa-download" style="margin-right: 8px;"></i>Save Contact
                </button>
            </div>
        </div>
    </div>

    <!-- Gallery Modal -->
    <div id="galleryModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.9); z-index: 9999; align-items: center; justify-content: center; padding: 20px;">
        <div style="background: white; border-radius: 15px; max-width: 90%; max-height: 90%; overflow: auto; position: relative;">
            <div style="padding: 20px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                    <h3 id="galleryModalTitle" style="margin: 0; color: #333; font-size: 18px; font-weight: 600;"></h3>
                    <button onclick="closeGalleryModal()" style="background: none; border: none; font-size: 24px; color: #666; cursor: pointer; padding: 5px;">&times;</button>
                </div>
                <img id="galleryModalImage" src="" alt="" style="width: 100%; max-height: 70vh; object-fit: contain; border-radius: 10px; margin-bottom: 15px;">
                <p id="galleryModalDescription" style="color: #666; margin: 0; line-height: 1.6;"></p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Function to generate and download vCard
        function saveContact() {
            const name = "{{ $profile->display_name ?? $user->name ?? 'User Name' }}";
            const title = "{{ $profile->profession ?? 'Professional' }}";
            const email = "{{ $user->email ?? '' }}";
            const phone = "{{ $profile->phone ?? '' }}";
            const website = "{{ $profile->website ?? '' }}";
            const location = "{{ $profile->location ?? '' }}";
            const bio = "{{ $profile->bio ?? '' }}";

            const vcard = `BEGIN:VCARD
VERSION:3.0
FN:${name}
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
        }

        // Gallery Modal Functions
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
        
        // Close modal when clicking outside
        document.getElementById('galleryModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeGalleryModal();
            }
        });

    </script>
</body>
</html>
