<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Health & Wellness VCard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

        <!-- Microsoft Tiles -->
        <meta name="msapplication-TileColor" content="{{ $profile->pwa_theme_color ?: '#10b981' }}">
        @if($profile->pwa_icon)
            <meta name="msapplication-TileImage" content="{{ $profile->pwa_icon_url }}">
        @endif
    @endif
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Nunito', sans-serif;
            background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 50%, #a7f3d0 100%);
            min-height: 100vh;
            padding: 20px;
            position: relative;
        }
        
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="wellness" width="40" height="40" patternUnits="userSpaceOnUse"><circle cx="20" cy="20" r="1.5" fill="rgba(16,185,129,0.1)"/><path d="M10,20 Q20,10 30,20 Q20,30 10,20" fill="rgba(16,185,129,0.05)"/></pattern></defs><rect width="100" height="100" fill="url(%23wellness)"/></svg>') repeat;
            pointer-events: none;
            z-index: 0;
        }
        
        .vcard-container {
            max-width: 420px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 25px;
            box-shadow: 0 20px 50px rgba(16, 185, 129, 0.15), 
                        0 8px 25px rgba(0, 0, 0, 0.08),
                        0 0 0 1px rgba(255, 255, 255, 0.9);
            overflow: hidden;
            position: relative;
            z-index: 1;
            backdrop-filter: blur(20px);
        }
        
        .vcard-header {
            background: linear-gradient(135deg, #10b981 0%, #059669 50%, #047857 100%);
            padding: 40px 25px 50px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .vcard-header.has-background {
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
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.8) 0%, rgba(5, 150, 105, 0.8) 100%);
            z-index: 1;
        }
        
        .vcard-header::after {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 150px;
            height: 150px;
            background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
            border-radius: 50%;
        }
        
        .vcard-header::before {
            content: '';
            position: absolute;
            bottom: -30px;
            left: -30px;
            width: 100px;
            height: 100px;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            border-radius: 50%;
        }
        
        .vcard-header > * {
            position: relative;
            z-index: 2;
        }
        
        .profile-img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 4px solid rgba(255,255,255,0.3);
            margin: 0 auto 20px;
            display: block;
            object-fit: cover;
            box-shadow: 0 12px 30px rgba(0,0,0,0.2);
            transition: all 0.3s ease;
        }
        
        .profile-img:hover {
            transform: scale(1.05);
            box-shadow: 0 15px 40px rgba(0,0,0,0.3);
        }
        
        .profile-name {
            font-family: 'Poppins', sans-serif;
            color: white;
            font-size: 26px;
            font-weight: 600;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
            text-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }
        
        .profile-title {
            color: rgba(255,255,255,0.95);
            font-size: 16px;
            font-weight: 500;
            margin-bottom: 5px;
        }
        
        .profile-company {
            color: rgba(255,255,255,0.8);
            font-size: 14px;
            font-weight: 400;
        }
        
        .vcard-body {
            padding: 30px 25px;
            background: white;
        }
        
        .section-title {
            color: #065f46;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            position: relative;
            padding-left: 25px;
        }
        
        .section-title::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 6px;
            height: 18px;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border-radius: 3px;
        }
        
        .section-title::after {
            content: '✨';
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 12px;
        }
        
        .bio-section {
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            padding: 25px;
            border-radius: 20px;
            margin-bottom: 25px;
            border: 1px solid #bbf7d0;
            position: relative;
        }
        
        .bio-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, #10b981 0%, #059669 100%);
            border-radius: 20px 20px 0 0;
        }
        
        .bio-text {
            color: #065f46;
            line-height: 1.7;
            font-size: 15px;
            margin: 0;
            text-align: center;
            font-style: italic;
        }
        
        .contact-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 25px;
        }
        
        .contact-card {
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            padding: 20px 15px;
            border-radius: 18px;
            text-align: center;
            text-decoration: none;
            color: #065f46;
            transition: all 0.3s ease;
            border: 1px solid #bbf7d0;
            position: relative;
            overflow: hidden;
        }
        
        .contact-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(16, 185, 129, 0.1), transparent);
            transition: left 0.5s ease;
        }
        
        .contact-card:hover::before {
            left: 100%;
        }
        
        .contact-card:hover {
            color: #10b981;
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(16, 185, 129, 0.2);
            border-color: #10b981;
        }
        
        .contact-card i {
            font-size: 24px;
            margin-bottom: 10px;
            display: block;
            color: #10b981;
        }
        
        .contact-card .label {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 5px;
            font-weight: 600;
            color: #6b7280;
        }
        
        .contact-card .value {
            font-size: 14px;
            font-weight: 500;
            line-height: 1.3;
        }
        
        .services-section {
            margin-bottom: 25px;
        }
        
        .services-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }
        
        .service-item {
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            padding: 18px 12px;
            border-radius: 16px;
            text-align: center;
            border: 1px solid #bbf7d0;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .service-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(16, 185, 129, 0.1), transparent);
            transition: left 0.5s ease;
        }
        
        .service-item:hover::before {
            left: 100%;
        }
        
        .service-item:hover {
            transform: translateY(-2px);
            border-color: #10b981;
            box-shadow: 0 8px 20px rgba(16, 185, 129, 0.15);
        }
        
        .service-item i {
            font-size: 22px;
            color: #10b981;
            margin-bottom: 8px;
        }
        
        .service-name {
            font-size: 13px;
            font-weight: 600;
            color: #065f46;
        }
        
        .social-section {
            text-align: center;
            margin-bottom: 25px;
        }
        
        .social-links {
            display: flex;
            justify-content: center;
            gap: 12px;
            flex-wrap: wrap;
        }
        
        .social-link {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            border: 2px solid #bbf7d0;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: #10b981;
            transition: all 0.3s ease;
            font-size: 20px;
            position: relative;
            overflow: hidden;
        }
        
        .social-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .social-link:hover::before {
            opacity: 1;
        }
        
        .social-link:hover {
            transform: translateY(-3px);
            color: white;
            border-color: #10b981;
            box-shadow: 0 10px 25px rgba(16, 185, 129, 0.3);
        }
        
        .social-link i {
            position: relative;
            z-index: 2;
        }
        
        .action-buttons {
            text-align: center;
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            padding: 25px;
            border-radius: 20px;
            border: 1px solid #bbf7d0;
        }
        
        .action-btn {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border: none;
            padding: 15px 25px;
            border-radius: 15px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            max-width: 280px;
            margin-bottom: 10px;
            position: relative;
            overflow: hidden;
        }
        
        .action-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s ease;
        }
        
        .action-btn:hover::before {
            left: 100%;
        }
        
        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(16, 185, 129, 0.3);
        }
        
        .gallery-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .gallery-item {
            position: relative;
            cursor: pointer;
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.3s ease;
            border: 2px solid #bbf7d0;
        }
        
        .gallery-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(16, 185, 129, 0.2);
            border-color: #10b981;
        }
        
        .gallery-item img {
            width: 100%;
            height: 120px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        
        .gallery-item:hover img {
            transform: scale(1.05);
        }
        
        .gallery-item .overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(transparent, rgba(16, 185, 129, 0.9));
            color: white;
            padding: 15px 10px 10px;
            font-size: 12px;
            font-weight: 500;
        }
        
        @media (max-width: 480px) {
            .vcard-container {
                margin: 10px;
                max-width: none;
                border-radius: 20px;
            }
            
            .contact-grid, .services-grid, .gallery-grid {
                grid-template-columns: 1fr;
            }
            
            .profile-img {
                width: 100px;
                height: 100px;
            }
            
            .profile-name {
                font-size: 22px;
            }
        }
    </style>
</head>
<body>
    <div class="vcard-container">
        <!-- Header Section -->
        <div class="vcard-header @if($profile && $profile->hasBackgroundImage()) has-background @endif" 
             @if($profile && $profile->hasBackgroundImage()) style="background-image: url('{{ $profile->full_background_image_url }}');" @endif>
            <img src="{{ $profile->full_profile_image_url ?? 'https://via.placeholder.com/120x120/10b981/ffffff?text=' . substr($user->name ?? 'HW', 0, 2) }}" alt="Profile Photo" class="profile-img">
            <div class="profile-name">{{ $profile->display_name ?? $user->name ?? 'Health & Wellness' }}</div>
            <div class="profile-title">{{ $profile->profession ?? 'Wellness Professional' }}</div>
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
            
            @if($profile->location ?? null)
                <div class="profile-company">{{ $profile->location }}</div>
            @endif
        </div>

        <!-- Body Section -->
        <div class="vcard-body">
            <!-- Bio Section -->
            @if($profile->bio ?? null)
            <div class="bio-section">
                <p class="bio-text">{{ $profile->bio }}</p>
            </div>
            @endif

            <!-- Services Section -->
            <div class="services-section">
                <div class="section-title">Our Services</div>
                <div class="services-grid">
                    <div class="service-item">
                        <i class="fas fa-heartbeat"></i>
                        <div class="service-name">Health Coaching</div>
                    </div>
                    <div class="service-item">
                        <i class="fas fa-spa"></i>
                        <div class="service-name">Wellness Therapy</div>
                    </div>
                    <div class="service-item">
                        <i class="fas fa-dumbbell"></i>
                        <div class="service-name">Fitness Training</div>
                    </div>
                    <div class="service-item">
                        <i class="fas fa-leaf"></i>
                        <div class="service-name">Nutrition</div>
                    </div>
                    <div class="service-item">
                        <i class="fas fa-meditation"></i>
                        <div class="service-name">Meditation</div>
                    </div>
                    <div class="service-item">
                        <i class="fas fa-user-md"></i>
                        <div class="service-name">Consultation</div>
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="section-title">Get In Touch</div>
            <div class="contact-grid">
                @if($profile->phone ?? null)
                <a href="tel:{{ $profile->phone }}" class="contact-card">
                    <i class="fas fa-phone"></i>
                    <div class="label">Call Us</div>
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

            <!-- Gallery Section -->
            @if($galleryItems->count() > 0)
            <div class="section-title">Our Facility</div>
            <div class="gallery-grid">
                @foreach($galleryItems as $item)
                    <div class="gallery-item" onclick="openGalleryModal('{{ $item->full_image_url }}', '{{ $item->title }}', '{{ $item->description }}')">
                        <img src="{{ $item->full_image_url }}" alt="{{ $item->title }}">
                        @if($item->title)
                            <div class="overlay">{{ $item->title }}</div>
                        @endif
                    </div>
                @endforeach
            </div>
            @endif

            <!-- Social Links -->
            @if($socialLinks->count() > 0)
            <div class="section-title">Connect With Us</div>
            <div class="social-section">
                <div class="social-links">
                    @foreach($socialLinks as $link)
                        <a href="{{ $link->url }}" target="_blank" class="social-link" title="{{ ucfirst($link->platform) }}">
                            @switch($link->platform)
                                @case('instagram')
                                    <i class="fab fa-instagram"></i>
                                    @break
                                @case('facebook')
                                    <i class="fab fa-facebook-f"></i>
                                    @break
                                @case('youtube')
                                    <i class="fab fa-youtube"></i>
                                    @break
                                @case('linkedin')
                                    <i class="fab fa-linkedin-in"></i>
                                    @break
                                @case('twitter')
                                    <i class="fab fa-twitter"></i>
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
            </div>
            @endif

            <!-- Action Buttons -->
            <div class="action-buttons">

                <button onclick="saveContact()" class="action-btn">
                    <i class="fas fa-download me-2"></i>Save Contact
                </button>
            </div>
        </div>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Gallery Modal Functions
        function openGalleryModal(imageUrl, title, description) {
            document.getElementById('galleryModalImage').src = imageUrl;
            document.getElementById('galleryModalTitle').textContent = title || 'Facility Image';
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

        // Function to generate and download vCard
        function saveContact() {
            const name = "{{ $profile->display_name ?? $user->name ?? 'Health & Wellness' }}";
            const title = "{{ $profile->profession ?? 'Wellness Professional' }}";
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

    </script>
</body>
</html>
