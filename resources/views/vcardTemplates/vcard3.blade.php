<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dark Executive VCard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Microsoft Tiles -->
        <meta name="msapplication-TileColor" content="{{ $profile->pwa_theme_color ?: '#667eea' }}">
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
            font-family: 'Inter', sans-serif;
            background: #0f0f23;
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
            background: radial-gradient(circle at 20% 50%, rgba(102, 126, 234, 0.1) 0%, transparent 50%),
                        radial-gradient(circle at 80% 20%, rgba(118, 75, 162, 0.1) 0%, transparent 50%),
                        radial-gradient(circle at 40% 80%, rgba(102, 126, 234, 0.05) 0%, transparent 50%);
            pointer-events: none;
            z-index: 0;
        }
        
        .vcard-container {
            max-width: 420px;
            margin: 0 auto;
            background: linear-gradient(145deg, #1a1a2e 0%, #16213e 100%);
            border-radius: 25px;
            box-shadow: 0 25px 60px rgba(0,0,0,0.4), 
                        0 0 0 1px rgba(255,255,255,0.1);
            overflow: hidden;
            position: relative;
            z-index: 1;
            backdrop-filter: blur(20px);
        }
        
        .vcard-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 50px 20px 70px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .vcard-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: conic-gradient(from 0deg, transparent, rgba(255,255,255,0.1), transparent);
            animation: rotate 20s infinite linear;
        }
        
        .vcard-header::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            right: 0;
            height: 30px;
            background: linear-gradient(145deg, #1a1a2e 0%, #16213e 100%);
            border-radius: 30px 30px 0 0;
        }
        
        @keyframes rotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .profile-img {
            width: 130px;
            height: 130px;
            border-radius: 50%;
            border: 5px solid rgba(255,255,255,0.2);
            margin: 0 auto 25px;
            display: block;
            object-fit: cover;
            box-shadow: 0 15px 40px rgba(0,0,0,0.4);
            position: relative;
            z-index: 2;
            transition: all 0.3s ease;
        }
        
        .profile-img:hover {
            transform: scale(1.05);
            box-shadow: 0 20px 50px rgba(102, 126, 234, 0.3);
        }
        
        .profile-name {
            color: white;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
            position: relative;
            z-index: 2;
            text-shadow: 0 2px 15px rgba(0,0,0,0.5);
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
            color: #fff;
            position: relative;
        }
        
        .bio-section {
            background: linear-gradient(145deg, #232347 0%, #1e1e3f 100%);
            padding: 25px;
            border-radius: 20px;
            margin-bottom: 30px;
            border: 1px solid rgba(102, 126, 234, 0.2);
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
        
        .bio-section::after {
            content: '';
            position: absolute;
            top: 10px;
            right: 10px;
            width: 40px;
            height: 40px;
            background: radial-gradient(circle, rgba(102, 126, 234, 0.1) 0%, transparent 70%);
            border-radius: 50%;
        }
        
        .bio-text {
            color: #cbd5e0;
            line-height: 1.7;
            font-size: 15px;
            margin: 0;
            text-align: center;
            font-weight: 400;
            position: relative;
            z-index: 2;
        }
        
        .contact-list {
            list-style: none;
            padding: 0;
            margin: 0 0 30px 0;
        }
        
        .contact-item {
            display: flex;
            align-items: center;
            padding: 20px 0;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            text-decoration: none;
            color: #fff;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .contact-item::before {
            content: '';
            position: absolute;
            left: -100%;
            top: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(102, 126, 234, 0.1), transparent);
            transition: left 0.5s ease;
        }
        
        .contact-item:hover::before {
            left: 100%;
        }
        
        .contact-item:hover {
            color: #667eea;
            padding-left: 15px;
            transform: translateX(5px);
        }
        
        .contact-item:last-child {
            border-bottom: none;
        }
        
        .contact-icon {
            width: 55px;
            height: 55px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 20px;
            color: white;
            font-size: 22px;
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
            transition: all 0.3s ease;
            position: relative;
            z-index: 2;
        }
        
        .contact-item:hover .contact-icon {
            transform: scale(1.1) rotate(-5deg);
            box-shadow: 0 15px 35px rgba(102, 126, 234, 0.4);
        }
        
        .contact-details {
            flex: 1;
            position: relative;
            z-index: 2;
        }
        
        .contact-label {
            font-size: 12px;
            color: #a0aec0;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
            margin-bottom: 4px;
        }
        
        .contact-value {
            font-size: 16px;
            font-weight: 500;
            color: #fff;
            line-height: 1.3;
        }
        
        .skills-section {
            margin-bottom: 30px;
        }
        
        .section-title {
            color: #fff;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            position: relative;
            padding-left: 20px;
        }
        
        .section-title::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 2px;
        }
        
        .skills-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }
        
        .skill-item {
            background: linear-gradient(145deg, #232347 0%, #1e1e3f 100%);
            padding: 15px;
            border-radius: 15px;
            text-align: center;
            border: 1px solid rgba(102, 126, 234, 0.2);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .skill-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(102, 126, 234, 0.1), transparent);
            transition: left 0.5s ease;
        }
        
        .skill-item:hover::before {
            left: 100%;
        }
        
        .skill-item:hover {
            transform: translateY(-3px);
            border-color: #667eea;
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.2);
        }
        
        .skill-name {
            font-size: 14px;
            font-weight: 500;
            color: #cbd5e0;
            position: relative;
            z-index: 2;
        }
        
        .social-section {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 30px;
        }
        
        .social-title {
            color: #cbd5e0;
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
        }
        
        .social-link {
            width: 55px;
            height: 55px;
            background: linear-gradient(145deg, #232347 0%, #1e1e3f 100%);
            border: 2px solid rgba(102, 126, 234, 0.3);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: #667eea;
            transition: all 0.3s ease;
            font-size: 22px;
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .social-link:hover::before {
            opacity: 1;
        }
        
        .social-link:hover {
            transform: translateY(-5px) rotate(5deg);
            color: white;
            border-color: #667eea;
            box-shadow: 0 15px 35px rgba(102, 126, 234, 0.3);
        }
        
        .social-link i {
            position: relative;
            z-index: 2;
        }
        
        .save-contact-section {
            background: linear-gradient(145deg, #232347 0%, #1e1e3f 100%);
            padding: 30px;
            border-radius: 20px;
            text-align: center;
            border: 1px solid rgba(102, 126, 234, 0.2);
            position: relative;
            overflow: hidden;
        }
        
        .save-contact-section::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: conic-gradient(from 0deg, transparent, rgba(102, 126, 234, 0.05), transparent);
            animation: rotate 30s infinite linear;
        }
        
        .save-contact-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: white;
            font-size: 32px;
            box-shadow: 0 15px 35px rgba(102, 126, 234, 0.4);
            position: relative;
            z-index: 2;
            transition: transform 0.3s ease;
        }
        
        .save-contact-icon:hover {
            transform: scale(1.05);
        }
        
        .save-contact-title {
            color: #fff;
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 10px;
            position: relative;
            z-index: 2;
        }
        
        .save-contact-subtitle {
            color: #a0aec0;
            font-size: 14px;
            margin-bottom: 25px;
            position: relative;
            z-index: 2;
        }
        
        .save-contact-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 16px 35px;
            border-radius: 15px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
            width: 100%;
            max-width: 280px;
            position: relative;
            z-index: 2;
            overflow: hidden;
        }
        
        .save-contact-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s ease;
        }
        
        .save-contact-btn:hover::before {
            left: 100%;
        }
        
        .save-contact-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.4);
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
            
            .skills-grid {
                grid-template-columns: 1fr;
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
        <div class="vcard-header @if($profile && $profile->hasBackgroundImage()) has-background @endif" 
             @if($profile && $profile->hasBackgroundImage()) style="background-image: url('{{ $profile->full_background_image_url }}');" @endif>
            <img src="{{ $profile->full_profile_image_url ?? 'https://via.placeholder.com/130x130/667eea/ffffff?text=' . substr($user->name ?? 'DE', 0, 2) }}" alt="Profile Photo" class="profile-img">
            <div class="profile-name">{{ $profile->display_name ?? $user->name ?? 'Dark Executive' }}</div>
            <div class="profile-title">{{ $profile->profession ?? 'Marketing Director' }}</div>
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
                    Strategic professional with expertise in driving growth and building strong brand presence. 
                    Passionate about data-driven solutions and innovative marketing strategies.
                </p>
            </div>
            @endif

            <!-- Gallery Section -->
            @if($galleryItems->count() > 0)
            <div class="skills-section">
                <div class="section-title">Gallery</div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px;">
                    @foreach($galleryItems as $item)
                        <div style="position: relative; cursor: pointer; border-radius: 15px; overflow: hidden; transition: all 0.3s ease; background: linear-gradient(145deg, #232347 0%, #1e1e3f 100%); border: 1px solid rgba(102, 126, 234, 0.2);" onclick="openGalleryModal('{{ $item->full_image_url }}', '{{ $item->title }}', '{{ $item->description }}')">
                            <img src="{{ $item->full_image_url }}" 
                                 alt="{{ $item->title }}"
                                 style="width: 100%; height: 120px; object-fit: cover; transition: transform 0.3s ease;"
                                 onmouseover="this.style.transform='scale(1.05)'"
                                 onmouseout="this.style.transform='scale(1)'">
                            @if($item->title)
                                <div style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(transparent, rgba(102, 126, 234, 0.9)); color: white; padding: 15px 10px 10px; font-size: 12px; font-weight: 500;">
                                    {{ $item->title }}
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Skills Section -->
            <div class="skills-section">
                <div class="section-title">Core Expertise</div>
                <div class="skills-grid">
                    <div class="skill-item">
                        <div class="skill-name">Leadership</div>
                    </div>
                    <div class="skill-item">
                        <div class="skill-name">Strategy</div>
                    </div>
                    <div class="skill-item">
                        <div class="skill-name">Innovation</div>
                    </div>
                    <div class="skill-item">
                        <div class="skill-name">Analytics</div>
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <ul class="contact-list">
                @if($user->email)
                <li>
                    <a href="mailto:{{ $user->email }}" class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="contact-details">
                            <div class="contact-label">Email</div>
                            <div class="contact-value">{{ $user->email }}</div>
                        </div>
                    </a>
                </li>
                @endif

                @if($profile->phone ?? null)
                <li>
                    <a href="tel:{{ $profile->phone }}" class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="contact-details">
                            <div class="contact-label">Phone</div>
                            <div class="contact-value">{{ $profile->phone }}</div>
                        </div>
                    </a>
                </li>
                @endif

                @if($profile->website ?? null)
                <li>
                    <a href="{{ $profile->website }}" target="_blank" class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-globe"></i>
                        </div>
                        <div class="contact-details">
                            <div class="contact-label">Website</div>
                            <div class="contact-value">{{ str_replace(['http://', 'https://'], '', $profile->website) }}</div>
                        </div>
                    </a>
                </li>
                @endif

                @if($profile->location ?? null)
                <li>
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="contact-details">
                            <div class="contact-label">Location</div>
                            <div class="contact-value">{{ $profile->location }}</div>
                        </div>
                    </div>
                </li>
                @endif
            </ul>

            <!-- Social Links -->
            @if($socialLinks->count() > 0)
            <div class="social-section">
                <div class="social-title">Connect With Me</div>
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
                                @default
                                    <i class="fas fa-link"></i>
                            @endswitch
                        </a>
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
                <div class="save-contact-subtitle">Download my contact information to your device</div>

                <button onclick="saveContact()" class="save-contact-btn">
                    <i class="fas fa-download me-2"></i>Add to Contacts
                </button>
            </div>
        </div>
    </div>

    <!-- Gallery Modal -->
    <div id="galleryModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.95); z-index: 9999; align-items: center; justify-content: center; padding: 20px;">
        <div style="background: linear-gradient(145deg, #1a1a2e 0%, #16213e 100%); border-radius: 20px; max-width: 90%; max-height: 90%; overflow: auto; position: relative; border: 1px solid rgba(102, 126, 234, 0.3);">
            <div style="padding: 20px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                    <h3 id="galleryModalTitle" style="margin: 0; color: #fff; font-size: 18px; font-weight: 600;"></h3>
                    <button onclick="closeGalleryModal()" style="background: none; border: none; font-size: 24px; color: #cbd5e0; cursor: pointer; padding: 5px;">&times;</button>
                </div>
                <img id="galleryModalImage" src="" alt="" style="width: 100%; max-height: 70vh; object-fit: contain; border-radius: 15px; margin-bottom: 15px;">
                <p id="galleryModalDescription" style="color: #cbd5e0; margin: 0; line-height: 1.6;"></p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Add interactive effects
        document.addEventListener('DOMContentLoaded', function() {
            // Add hover effects to contact items
            const contactItems = document.querySelectorAll('.contact-item');
            contactItems.forEach(item => {
                item.addEventListener('mouseenter', function() {
                    this.style.background = 'rgba(102, 126, 234, 0.05)';
                });
                item.addEventListener('mouseleave', function() {
                    this.style.background = '';
                });
            });

            // Add floating animation to skills
            const skillItems = document.querySelectorAll('.skill-item');
            skillItems.forEach((item, index) => {
                setTimeout(() => {
                    item.style.animation = `float 3s ease-in-out infinite`;
                    item.style.animationDelay = `${index * 0.2}s`;
                }, 1000);
            });

            // Add CSS for floating animation
            const style = document.createElement('style');
            style.textContent = `
                @keyframes float {
                    0%, 100% { transform: translateY(0px); }
                    50% { transform: translateY(-5px); }
                }
            `;
            document.head.appendChild(style);
        });

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

        // Function to generate and download vCard
        function saveContact() {
            const name = "{{ $profile->display_name ?? $user->name ?? 'Dark Executive' }}";
            const title = "{{ $profile->profession ?? 'Marketing Director' }}";
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

    </script>
</body>
</html>
