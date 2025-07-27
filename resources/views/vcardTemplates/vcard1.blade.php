<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Professional VCard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            position: relative;
            overflow-x: hidden;
        }
        
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="2" fill="rgba(255,255,255,0.1)"/><circle cx="80" cy="80" r="3" fill="rgba(255,255,255,0.05)"/><circle cx="40" cy="60" r="1" fill="rgba(255,255,255,0.1)"/></svg>') repeat;
            animation: float 30s infinite linear;
            pointer-events: none;
            z-index: 0;
        }
        
        @keyframes float {
            0% { transform: translateX(0) translateY(0); }
            100% { transform: translateX(-100px) translateY(-100px); }
        }
        
        .vcard-container {
            max-width: 420px;
            margin: 0 auto;
            background: white;
            border-radius: 25px;
            box-shadow: 0 25px 60px rgba(0,0,0,0.2);
            overflow: hidden;
            position: relative;
            z-index: 1;
            backdrop-filter: blur(10px);
        }
        
        .vcard-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 50px 20px 70px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .profile-background {
            position: absolute;
            top: 30px;
            left: 50%;
            transform: translateX(-50%);
            width: 170px;
            height: 170px;
            border-radius: 50%;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            z-index: 1;
            opacity: 0.4;
            filter: blur(3px);
        }
        
        .vcard-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px);
            background-size: 30px 30px;
            animation: rotate 60s infinite linear;
        }
        
        @keyframes rotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .profile-img {
            width: 130px;
            height: 130px;
            border-radius: 50%;
            border: 6px solid rgba(255,255,255,0.3);
            margin: 0 auto 25px;
            display: block;
            object-fit: cover;
            box-shadow: 0 15px 35px rgba(0,0,0,0.3);
            position: relative;
            z-index: 3;
            transition: transform 0.3s ease;
        }
        
        .profile-img:hover {
            transform: scale(1.05);
        }
        
        .profile-name {
            color: white;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
            position: relative;
            z-index: 2;
            text-shadow: 0 2px 10px rgba(0,0,0,0.3);
        }
        
        .profile-title {
            color: rgba(255,255,255,0.95);
            font-size: 16px;
            font-weight: 400;
            position: relative;
            z-index: 2;
            margin-bottom: 5px;
        }
        
        .profile-company {
            color: rgba(255,255,255,0.8);
            font-size: 14px;
            font-weight: 300;
            position: relative;
            z-index: 2;
        }
        
        .vcard-body {
            padding: 35px 25px;
            position: relative;
        }
        
        .bio-section {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            padding: 25px;
            border-radius: 20px;
            margin-bottom: 30px;
            border: 1px solid #e2e8f0;
            position: relative;
            overflow: hidden;
        }
        
        .bio-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
        }
        
        .bio-text {
            color: #4a5568;
            line-height: 1.7;
            font-size: 15px;
            margin: 0;
            text-align: center;
            font-weight: 400;
        }
        
        .contact-item {
            display: flex;
            align-items: center;
            padding: 18px 0;
            border-bottom: 1px solid #e2e8f0;
            text-decoration: none;
            color: #2d3748;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .contact-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 0;
            height: 100%;
            background: linear-gradient(90deg, rgba(102, 126, 234, 0.1) 0%, transparent 100%);
            transition: width 0.3s ease;
        }
        
        .contact-item:hover::before {
            width: 100%;
        }
        
        .contact-item:hover {
            color: #667eea;
            transform: translateX(8px);
            padding-left: 10px;
        }
        
        .contact-item:last-child {
            border-bottom: none;
        }
        
        .contact-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 18px;
            color: white;
            font-size: 20px;
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
            transition: transform 0.3s ease;
        }
        
        .contact-item:hover .contact-icon {
            transform: scale(1.1) rotate(5deg);
        }
        
        .contact-text {
            flex: 1;
        }
        
        .contact-label {
            font-size: 12px;
            color: #a0aec0;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
            margin-bottom: 3px;
        }
        
        .contact-value {
            font-size: 16px;
            font-weight: 500;
            margin-top: 2px;
            line-height: 1.3;
        }
        
        .social-section {
            margin-top: 35px;
            text-align: center;
        }
        
        .social-title {
            color: #4a5568;
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 20px;
            position: relative;
        }
        
        .social-title::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 50px;
            height: 3px;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            border-radius: 2px;
        }
        
        .social-links {
            display: flex;
            justify-content: center;
            gap: 15px;
            flex-wrap: wrap;
        }
        
        .social-link {
            width: 55px;
            height: 55px;
            background: white;
            border: 2px solid #e2e8f0;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: #667eea;
            transition: all 0.3s ease;
            font-size: 22px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        
        .social-link:hover {
            transform: translateY(-5px) rotate(5deg);
            box-shadow: 0 12px 25px rgba(0,0,0,0.15);
        }
        
        .social-link.linkedin:hover {
            background: #0077b5;
            border-color: #0077b5;
            color: white;
        }
        
        .social-link.twitter:hover {
            background: #1da1f2;
            border-color: #1da1f2;
            color: white;
        }
        
        .social-link.github:hover {
            background: #333;
            border-color: #333;
            color: white;
        }
        
        .social-link.instagram:hover {
            background: linear-gradient(45deg, #f09433 0%,#e6683c 25%,#dc2743 50%,#cc2366 75%,#bc1888 100%);
            border-color: #bc1888;
            color: white;
        }
        
        .save-contact-section {
            margin-top: 30px;
            text-align: center;
            padding: 25px;
            background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
            border-radius: 20px;
            border: 1px solid #e2e8f0;
        }
        
        .save-contact-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            color: white;
            font-size: 32px;
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }
        
        .save-contact-title {
            color: #2d3748;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 10px;
        }
        
        .save-contact-subtitle {
            color: #718096;
            font-size: 14px;
            margin-bottom: 20px;
        }
        
        .save-contact-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 15px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
            width: 100%;
            max-width: 250px;
        }
        
        .save-contact-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(102, 126, 234, 0.4);
        }
        
        .save-contact-btn:active {
            transform: translateY(-1px);
        }
        
        @media (max-width: 480px) {
            .vcard-container {
                margin: 10px;
                max-width: none;
                border-radius: 20px;
            }
            
            .vcard-header {
                padding: 40px 15px 60px;
            }
            
            .vcard-body {
                padding: 25px 20px;
            }
            
            .profile-img {
                width: 110px;
                height: 110px;
            }
            
            .profile-name {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="vcard-container">
        <!-- Header Section -->
        <div class="vcard-header">
            @if($profile && $profile->hasBackgroundImage())
                <div class="profile-background" style="background-image: url('{{ $profile->full_background_image_url }}');"></div>
            @endif
            
            <img src="{{ $profile->full_profile_image_url ?? 'https://via.placeholder.com/130x130/667eea/ffffff?text=' . substr($user->name ?? 'MP', 0, 2) }}" alt="Profile Photo" class="profile-img">
            <div class="profile-name">{{ $profile->display_name ?? $user->name ?? 'Modern Professional' }}</div>
            <div class="profile-title">{{ $profile->profession ?? 'Software Developer' }}</div>
            
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
            @else
            <div class="bio-section">
                <p class="bio-text">
                    Passionate professional dedicated to excellence and innovation. 
                    Always ready to take on new challenges and deliver outstanding results.
                </p>
            </div>
            @endif

            <!-- Contact Information -->
            @if($profile->phone ?? null)
            <a href="tel:{{ $profile->phone }}" class="contact-item">
                <div class="contact-icon">
                    <i class="fas fa-phone"></i>
                </div>
                <div class="contact-text">
                    <div class="contact-label">Phone</div>
                    <div class="contact-value">{{ $profile->phone }}</div>
                </div>
            </a>
            @endif

            @if($user->email)
            <a href="mailto:{{ $user->email }}" class="contact-item">
                <div class="contact-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="contact-text">
                    <div class="contact-label">Email</div>
                    <div class="contact-value">{{ $user->email }}</div>
                </div>
            </a>
            @endif

            @if($profile->website ?? null)
            <a href="{{ $profile->website }}" target="_blank" class="contact-item">
                <div class="contact-icon">
                    <i class="fas fa-globe"></i>
                </div>
                <div class="contact-text">
                    <div class="contact-label">Website</div>
                    <div class="contact-value">{{ str_replace(['http://', 'https://'], '', $profile->website) }}</div>
                </div>
            </a>
            @endif

            @if($profile->location ?? null)
            <div class="contact-item">
                <div class="contact-icon">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <div class="contact-text">
                    <div class="contact-label">Location</div>
                    <div class="contact-value">{{ $profile->location }}</div>
                </div>
            </div>
            @endif

            <!-- Social Links -->
            @if($socialLinks->count() > 0)
            <div class="social-section">
                <div class="social-title">Connect With Me</div>
                <div class="social-links">
                    @foreach($socialLinks as $link)
                        <a href="{{ $link->url }}" target="_blank" class="social-link {{ $link->platform }}" title="{{ ucfirst($link->platform) }}">
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
            </div>
            @endif

            <!-- Gallery Section -->
            @if($galleryItems->count() > 0)
            <div class="bio-section">
                <div class="section-title" style="color: #4a5568; font-size: 18px; font-weight: 600; margin-bottom: 20px; position: relative; padding-left: 20px;">
                    <span style="position: absolute; left: 0; top: 50%; transform: translateY(-50%); width: 4px; height: 20px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 2px;"></span>
                    Gallery
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px;">
                    @foreach($galleryItems as $item)
                        <div style="position: relative; cursor: pointer; border-radius: 15px; overflow: hidden; transition: all 0.3s ease;" onclick="openGalleryModal('{{ $item->full_image_url }}', '{{ $item->title }}', '{{ $item->description }}')">
                            <img src="{{ $item->full_image_url }}" 
                                 alt="{{ $item->title }}"
                                 style="width: 100%; height: 120px; object-fit: cover; transition: transform 0.3s ease;"
                                 onmouseover="this.style.transform='scale(1.05)'"
                                 onmouseout="this.style.transform='scale(1)'">
                            @if($item->title)
                                <div style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(transparent, rgba(0,0,0,0.7)); color: white; padding: 15px 10px 10px; font-size: 12px; font-weight: 500;">
                                    {{ $item->title }}
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Save Contact Section -->
            <div class="save-contact-section">
                <div class="save-contact-icon">
                    <i class="fas fa-address-book"></i>
                </div>
                <div class="save-contact-title">Save Contact</div>
                <div class="save-contact-subtitle">Add my contact information to your device</div>

                <button onclick="saveContact()" class="save-contact-btn">
                    <i class="fas fa-download me-2"></i>Add to Contacts
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
        // Add interactive effects
        document.addEventListener('DOMContentLoaded', function() {
            // Add click effect to contact items
            const contactItems = document.querySelectorAll('.contact-item');
            contactItems.forEach(item => {
                item.addEventListener('click', function() {
                    this.style.transform = 'scale(0.98) translateX(8px)';
                    setTimeout(() => {
                        this.style.transform = '';
                    }, 150);
                });
            });

            // Add floating animation to profile image
            const profileImg = document.querySelector('.profile-img');
            setInterval(() => {
                profileImg.style.transform = 'translateY(-5px)';
                setTimeout(() => {
                    profileImg.style.transform = 'translateY(0)';
                }, 1000);
            }, 3000);
        });

        // Function to generate and download vCard
        function saveContact() {
            const name = "{{ $profile->display_name ?? $user->name ?? 'Modern Professional' }}";
            const title = "{{ $profile->profession ?? 'Software Developer' }}";
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

            // Add visual feedback
            const btn = document.querySelector('.save-contact-btn');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-check me-2"></i>Contact Saved!';
            btn.style.background = 'linear-gradient(135deg, #48bb78 0%, #38a169 100%)';
            
            setTimeout(() => {
                btn.innerHTML = originalText;
                btn.style.background = 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
            }, 2000);
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