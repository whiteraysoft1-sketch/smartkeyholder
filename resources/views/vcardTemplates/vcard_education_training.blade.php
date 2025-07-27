<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Education & Training vCard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    
    <meta name="msapplication-TileColor" content="#7c3aed">
    @if($profile->pwa_icon)
        <meta name="msapplication-TileImage" content="{{ $profile->pwa_icon_url }}">
    @endif
    
    <style>
        /* Custom Education & Training Theme Styles */
        .education-gradient {
            background: 
                linear-gradient(135deg, rgba(124, 58, 237, 0.95) 0%, rgba(168, 85, 247, 0.95) 25%, rgba(59, 130, 246, 0.95) 50%, rgba(6, 182, 212, 0.95) 75%, rgba(16, 185, 129, 0.95) 100%),
                url('https://images.unsplash.com/photo-1481627834876-b7833e8f5570?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        
        .academic-pattern {
            background-image: 
                radial-gradient(circle at 20% 20%, rgba(124, 58, 237, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(59, 130, 246, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 60%, rgba(168, 85, 247, 0.05) 0%, transparent 50%);
        }
        
        .knowledge-shadow {
            box-shadow: 
                0 10px 25px -5px rgba(124, 58, 237, 0.3),
                0 4px 6px -2px rgba(124, 58, 237, 0.1);
        }
        
        .academic-border {
            border-radius: 1.5rem;
        }
        
        .book-flip {
            animation: book-flip 4s ease-in-out infinite;
        }
        
        @keyframes book-flip {
            0%, 100% { transform: rotateY(0deg); }
            25% { transform: rotateY(-15deg); }
            75% { transform: rotateY(15deg); }
        }
        
        .knowledge-glow {
            animation: knowledge-glow 3s ease-in-out infinite;
        }
        
        @keyframes knowledge-glow {
            0%, 100% { 
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(124, 58, 237, 0.4);
            }
            50% { 
                transform: scale(1.05);
                box-shadow: 0 0 0 10px rgba(124, 58, 237, 0);
            }
        }
        
        .graduation-bounce {
            animation: graduation-bounce 2s ease-in-out infinite;
        }
        
        @keyframes graduation-bounce {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
        }
        
        .education-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .contact-item {
            background: linear-gradient(135deg, rgba(124, 58, 237, 0.1) 0%, rgba(59, 130, 246, 0.1) 100%);
            border: 1px solid rgba(124, 58, 237, 0.2);
            transition: all 0.3s ease;
        }
        
        .contact-item:hover {
            background: linear-gradient(135deg, rgba(124, 58, 237, 0.15) 0%, rgba(59, 130, 246, 0.15) 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(124, 58, 237, 0.2);
        }
        
        .social-icon {
            background: linear-gradient(135deg, #7c3aed 0%, #a855f7 100%);
            transition: all 0.3s ease;
        }
        
        .social-icon:hover {
            background: linear-gradient(135deg, #6d28d9 0%, #9333ea 100%);
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(124, 58, 237, 0.4);
        }
        
        .course-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(248, 250, 252, 0.9) 100%);
            border: 1px solid rgba(124, 58, 237, 0.2);
            transition: all 0.3s ease;
        }
        
        .course-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(124, 58, 237, 0.2);
            border-color: rgba(124, 58, 237, 0.3);
        }
        
        .academic-badge {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            animation: gentle-shine 4s ease-in-out infinite;
        }
        
        @keyframes gentle-shine {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.9; }
        }
        
        .learning-quote {
            background: linear-gradient(135deg, rgba(124, 58, 237, 0.1) 0%, rgba(59, 130, 246, 0.1) 100%);
            border-left: 4px solid #7c3aed;
        }
        
        .enroll-btn {
            background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%);
            transition: all 0.3s ease;
        }
        
        .enroll-btn:hover {
            background: linear-gradient(135deg, #6d28d9 0%, #5b21b6 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(124, 58, 237, 0.4);
        }
        
        .contact-btn {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            transition: all 0.3s ease;
        }
        
        .contact-btn:hover {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(59, 130, 246, 0.4);
        }
        
        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.6s ease;
        }
        
        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }
        
        .academic-stats {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(6, 182, 212, 0.1) 100%);
            border: 1px solid rgba(16, 185, 129, 0.2);
        }
        
        .achievement-badge {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            animation: achievement-glow 3s ease-in-out infinite;
        }
        
        @keyframes achievement-glow {
            0%, 100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.4); }
            50% { box-shadow: 0 0 0 8px rgba(16, 185, 129, 0); }
        }
    </style>
</head>
<body class="education-gradient academic-pattern min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md mx-auto">
        <div class="education-card academic-border knowledge-shadow overflow-hidden">
            
            <!-- Header Section -->
            @if($profile->background_image)
            <!-- Header with Background Image -->
            <div class="relative w-full h-48 bg-cover bg-center" style="background-image: url('{{ $profile->background_image_url }}');">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-black/20"></div>
                <div class="absolute inset-0 bg-gradient-to-br from-purple-400/40 via-blue-500/30 to-purple-600/40"></div>
                
                <!-- Profile Image Overlapping -->
                <div class="absolute -bottom-16 left-1/2 transform -translate-x-1/2">
                    <div class="relative inline-block">
                        <div class="w-32 h-32 rounded-full bg-gradient-to-br from-purple-400 to-blue-500 p-1 knowledge-glow">
                            <img src="{{ $profile->full_profile_image_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name ?? 'ET') . '&background=7c3aed&color=fff&size=128' }}" 
                                 class="w-full h-full rounded-full object-cover border-4 border-white" 
                                 alt="Profile Photo">
                        </div>
                        <!-- Academic Achievement Badge -->
                        <div class="absolute -bottom-2 -right-2 academic-badge text-white rounded-full w-10 h-10 flex items-center justify-center text-lg">
                            <i class="fas fa-award"></i>
                        </div>
                    </div>
                </div>
                
                <!-- Decorative Academic Elements -->
                <div class="absolute top-4 left-4 text-white/50 text-2xl book-flip">
                    <i class="fas fa-book"></i>
                </div>
                <div class="absolute top-4 right-4 text-white/50 text-2xl graduation-bounce">
                    <i class="fas fa-graduation-cap"></i>
                </div>
            </div>
            <!-- Spacer and Profile Info -->
            <div class="pt-20 pb-6 px-6 text-center">
                <!-- Name & Title -->
                <h1 class="text-2xl font-bold text-gray-800 mb-1">
                    {{ $profile->display_name ?? $user->name ?? 'Prof. Educator' }}
                </h1>
                <p class="text-purple-700 font-semibold text-lg mb-2">
                    {{ $profile->profession ?? 'Education Specialist' }}
                </p>
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
                <div class="flex items-center justify-center text-gray-600 text-sm mb-4">
                    <i class="fas fa-university text-purple-600 mr-2"></i>
                    {{ $profile->location }}
                </div>
                @endif
            </div>
            @else
            <!-- Header without Background Image -->
            <div class="relative px-6 pt-8 pb-6 text-center">
                <!-- Decorative Academic Elements -->
                <div class="absolute top-4 left-4 text-purple-500/30 text-2xl book-flip">
                    <i class="fas fa-book"></i>
                </div>
                <div class="absolute top-4 right-4 text-blue-500/30 text-2xl graduation-bounce">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                
                <!-- Profile Image with Academic Badge -->
                <div class="relative inline-block mb-4">
                    <div class="w-32 h-32 rounded-full bg-gradient-to-br from-purple-400 to-blue-500 p-1 knowledge-glow">
                        <img src="{{ $profile->full_profile_image_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name ?? 'ET') . '&background=7c3aed&color=fff&size=128' }}" 
                             class="w-full h-full rounded-full object-cover border-4 border-white" 
                             alt="Profile Photo">
                    </div>
                    <!-- Academic Achievement Badge -->
                    <div class="absolute -bottom-2 -right-2 academic-badge text-white rounded-full w-10 h-10 flex items-center justify-center text-lg">
                        <i class="fas fa-award"></i>
                    </div>
                </div>
                
                <!-- Name & Title -->
                <h1 class="text-2xl font-bold text-gray-800 mb-1">
                    {{ $profile->display_name ?? $user->name ?? 'Prof. Educator' }}
                </h1>
                <p class="text-purple-700 font-semibold text-lg mb-2">
                    {{ $profile->profession ?? 'Education Specialist' }}
                </p>
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
                <div class="flex items-center justify-center text-gray-600 text-sm mb-4">
                    <i class="fas fa-university text-purple-600 mr-2"></i>
                    {{ $profile->location }}
                </div>
                @endif
            @endif
                
                <!-- Academic Credentials -->
                <div class="flex justify-center gap-2 mb-4">
                    <div class="achievement-badge px-3 py-1 rounded-full text-xs font-medium">
                        <i class="fas fa-certificate mr-1"></i>
                        Certified Educator
                    </div>
                </div>
            </div>
            
            <!-- Bio Section -->
            <div class="px-6 py-4">
                <div class="learning-quote rounded-xl p-4 mb-6">
                    <div class="flex items-center mb-3">
                        <i class="fas fa-quote-left text-purple-600 text-lg mr-2"></i>
                        <h3 class="font-semibold text-gray-800">Teaching Philosophy</h3>
                    </div>
                    <p class="text-gray-700 text-sm leading-relaxed">
                        {{ $profile->bio ?? 'Passionate about empowering minds through innovative education and personalized learning experiences. Committed to fostering growth, creativity, and lifelong learning in every student.' }}
                    </p>
                </div>
            </div>
            
            <!-- Academic Stats -->
            <div class="px-6 py-4">
                <div class="academic-stats rounded-lg p-4 mb-6">
                    <h3 class="font-semibold text-gray-800 mb-3 flex items-center">
                        <i class="fas fa-chart-line text-green-600 mr-2"></i>
                        Academic Achievements
                    </h3>
                    <div class="grid grid-cols-3 gap-4 text-center">
                        <div>
                            <div class="text-2xl font-bold text-purple-600">500+</div>
                            <div class="text-xs text-gray-600">Students Taught</div>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-blue-600">15+</div>
                            <div class="text-xs text-gray-600">Years Experience</div>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-green-600">98%</div>
                            <div class="text-xs text-gray-600">Success Rate</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Contact Information -->
            @if($profile->phone || $profile->email || $profile->website)
            <div class="px-6 py-4">
                <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-address-book text-purple-600 mr-2"></i>
                    Contact Information
                </h3>
                <div class="space-y-3">
                    @if($profile->phone)
                    <div class="contact-item rounded-lg p-3 flex items-center fade-in">
                        <div class="w-10 h-10 bg-purple-500 rounded-full flex items-center justify-center text-white mr-3">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="flex-1">
                            <div class="font-medium text-gray-800">Phone</div>
                            <div class="text-sm text-gray-600">{{ $profile->phone }}</div>
                        </div>
                        <a href="tel:{{ $profile->phone }}" class="bg-purple-500 text-white px-3 py-1 rounded-lg text-sm hover:bg-purple-600 transition-colors">
                            Call
                        </a>
                    </div>
                    @endif
                    
                    @if($profile->email)
                    <div class="contact-item rounded-lg p-3 flex items-center fade-in">
                        <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white mr-3">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="flex-1">
                            <div class="font-medium text-gray-800">Email</div>
                            <div class="text-sm text-gray-600">{{ $profile->email }}</div>
                        </div>
                        <a href="mailto:{{ $profile->email }}" class="bg-blue-500 text-white px-3 py-1 rounded-lg text-sm hover:bg-blue-600 transition-colors">
                            Email
                        </a>
                    </div>
                    @endif
                    
                    @if($profile->website)
                    <div class="contact-item rounded-lg p-3 flex items-center fade-in">
                        <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center text-white mr-3">
                            <i class="fas fa-globe"></i>
                        </div>
                        <div class="flex-1">
                            <div class="font-medium text-gray-800">Website</div>
                            <div class="text-sm text-gray-600">Visit our academy</div>
                        </div>
                        <a href="{{ $profile->website }}" target="_blank" class="bg-green-500 text-white px-3 py-1 rounded-lg text-sm hover:bg-green-600 transition-colors">
                            Visit
                        </a>
                    </div>
                    @endif
                </div>
            </div>
            @endif
            
            <!-- Courses & Services Section -->
            <div class="px-6 py-4">
                <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-chalkboard-teacher text-purple-600 mr-2"></i>
                    Courses & Training
                </h3>
                <div class="grid grid-cols-2 gap-3">
                    <div class="course-card rounded-lg p-3 text-center fade-in">
                        <i class="fas fa-laptop-code text-purple-600 text-2xl mb-2"></i>
                        <div class="text-sm font-medium text-gray-800">Online Courses</div>
                    </div>
                    <div class="course-card rounded-lg p-3 text-center fade-in">
                        <i class="fas fa-users text-blue-600 text-2xl mb-2"></i>
                        <div class="text-sm font-medium text-gray-800">Group Training</div>
                    </div>
                    <div class="course-card rounded-lg p-3 text-center fade-in">
                        <i class="fas fa-user-graduate text-green-600 text-2xl mb-2"></i>
                        <div class="text-sm font-medium text-gray-800">1-on-1 Tutoring</div>
                    </div>
                    <div class="course-card rounded-lg p-3 text-center fade-in">
                        <i class="fas fa-certificate text-orange-600 text-2xl mb-2"></i>
                        <div class="text-sm font-medium text-gray-800">Certification</div>
                    </div>
                    <div class="course-card rounded-lg p-3 text-center fade-in">
                        <i class="fas fa-book-open text-indigo-600 text-2xl mb-2"></i>
                        <div class="text-sm font-medium text-gray-800">Workshops</div>
                    </div>
                    <div class="course-card rounded-lg p-3 text-center fade-in">
                        <i class="fas fa-video text-red-600 text-2xl mb-2"></i>
                        <div class="text-sm font-medium text-gray-800">Video Lessons</div>
                    </div>
                </div>
            </div>
            
            <!-- Social Links -->
            @if($socialLinks->count() > 0)
            <div class="px-6 py-4">
                <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-share-alt text-purple-600 mr-2"></i>
                    Connect & Learn
                </h3>
                <div class="flex gap-3 justify-center">
                    @foreach($socialLinks as $link)
                        <a href="{{ $link->url }}" target="_blank" class="social-icon w-12 h-12 flex items-center justify-center rounded-full text-white text-lg" title="{{ ucfirst($link->platform) }}">
                            @switch($link->platform)
                                @case('facebook')<i class="fab fa-facebook-f"></i>@break
                                @case('instagram')<i class="fab fa-instagram"></i>@break
                                @case('twitter')<i class="fab fa-twitter"></i>@break
                                @case('linkedin')<i class="fab fa-linkedin-in"></i>@break
                                @case('youtube')<i class="fab fa-youtube"></i>@break
                                @case('whatsapp')<i class="fab fa-whatsapp"></i>@break
                                @case('telegram')<i class="fab fa-telegram-plane"></i>@break
                                @case('discord')<i class="fab fa-discord"></i>@break
                                @case('zoom')<i class="fas fa-video"></i>@break
                                @default<i class="fas fa-link"></i>@break
                            @endswitch
                        </a>
                    @endforeach
                </div>
            </div>
            @endif
            
            <!-- Gallery Section -->
            @if($galleryItems->count() > 0)
            <div class="px-6 py-4">
                <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-images text-purple-600 mr-2"></i>
                    Learning Environment
                </h3>
                <div class="grid grid-cols-2 gap-3">
                    @foreach($galleryItems->take(4) as $item)
                        <div class="relative group overflow-hidden rounded-lg fade-in">
                            <img src="{{ $item->full_image_url }}" 
                                 alt="{{ $item->title }}" 
                                 class="w-full h-24 object-cover transition-transform duration-300 group-hover:scale-110">
                            @if($item->title)
                                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-2">
                                    <p class="text-white text-xs font-medium">{{ $item->title }}</p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
            
            <!-- Action Buttons -->
            <div class="px-6 py-6 space-y-3">
                @if($profile->email)
                <a href="mailto:{{ $profile->email }}?subject=Course Enrollment Inquiry" class="enroll-btn w-full text-white py-3 px-4 rounded-xl font-semibold text-center flex items-center justify-center">
                    <i class="fas fa-user-plus mr-2"></i>
                    Enroll Now
                </a>
                @endif
                
                @if($profile->phone)
                <a href="tel:{{ $profile->phone }}" class="contact-btn w-full text-white py-3 px-4 rounded-xl font-semibold text-center flex items-center justify-center">
                    <i class="fas fa-phone mr-2"></i>
                    Call for Info
                </a>
                @endif
                
                <!-- Save Contact Button -->
                <button onclick="downloadVCard()" class="w-full bg-gradient-to-r from-green-500 to-emerald-500 text-white py-3 px-4 rounded-xl font-semibold text-center flex items-center justify-center hover:from-green-600 hover:to-emerald-600 transition-all">
                    <i class="fas fa-download mr-2"></i>
                    Save Contact
                </button>
            </div>
            
            <!-- Footer -->
            <div class="px-6 py-4 bg-purple-50 text-center border-t border-purple-200">
                <div class="flex items-center justify-center text-purple-700 text-sm mb-2">
                    <i class="fas fa-lightbulb mr-2"></i>
                    <span>Empowering Minds, Shaping Futures</span>
                    <i class="fas fa-graduation-cap ml-2 graduation-bounce"></i>
                </div>
                <div class="text-xs text-gray-500">
                    Certified Education Professional
                </div>
                <div class="text-xs text-gray-400 mt-1">
                    Powered by Smart Tag Education
                </div>
            </div>
        </div>
    </div>
    
    <!-- vCard Download Script -->
    <script>
        function downloadVCard() {
            const vCardData = `BEGIN:VCARD
VERSION:3.0
FN:{{ $profile->display_name ?? $user->name ?? 'Prof. Educator' }}
ORG:{{ $profile->profession ?? 'Education Specialist' }}
TITLE:{{ $profile->profession ?? 'Education Specialist' }}
TEL:{{ $profile->phone ?? '' }}
EMAIL:{{ $profile->email ?? '' }}
URL:{{ $profile->website ?? '' }}
NOTE:{{ $profile->bio ?? 'Passionate educator committed to empowering minds through innovative learning experiences.' }}
END:VCARD`;
            
            const blob = new Blob([vCardData], { type: 'text/vcard' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = '{{ Str::slug($profile->display_name ?? $user->name ?? 'prof-educator') }}.vcf';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            window.URL.revokeObjectURL(url);
        }
        
        // Interactive animations and educational effects
        document.addEventListener('DOMContentLoaded', function() {
            // Fade in animation observer
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };
            
            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                    }
                });
            }, observerOptions);
            
            // Observe all fade-in elements
            document.querySelectorAll('.fade-in').forEach(el => {
                observer.observe(el);
            });
            
            // Add staggered animation delays for course cards
            document.querySelectorAll('.course-card').forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
            });
            
            // Educational tip system
            const educationalTips = [
                "💡 Continuous learning is the key to success!",
                "📚 Knowledge shared is knowledge multiplied!",
                "🎯 Set learning goals and achieve them step by step!",
                "🌟 Every expert was once a beginner!",
                "🚀 Invest in your education, it pays the best interest!"
            ];
            
            // Show random educational tip
            const tipElement = document.createElement('div');
            tipElement.className = 'fixed bottom-4 right-4 bg-purple-500 text-white p-3 rounded-lg shadow-lg text-sm max-w-xs opacity-0 transition-opacity duration-300';
            tipElement.innerHTML = educationalTips[Math.floor(Math.random() * educationalTips.length)];
            document.body.appendChild(tipElement);
            
            // Show tip after 6 seconds
            setTimeout(() => {
                tipElement.style.opacity = '1';
                setTimeout(() => {
                    tipElement.style.opacity = '0';
                    setTimeout(() => {
                        document.body.removeChild(tipElement);
                    }, 300);
                }, 5000);
            }, 6000);
            
            // Academic achievement counter animation
            const counters = document.querySelectorAll('.academic-stats .text-2xl');
            counters.forEach(counter => {
                const target = parseInt(counter.textContent);
                let current = 0;
                const increment = target / 50;
                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        counter.textContent = target + (counter.textContent.includes('+') ? '+' : '') + (counter.textContent.includes('%') ? '%' : '');
                        clearInterval(timer);
                    } else {
                        counter.textContent = Math.floor(current) + (counter.textContent.includes('+') ? '+' : '') + (counter.textContent.includes('%') ? '%' : '');
                    }
                }, 50);
            });
            
            // Book flip effect on scroll
            let bookFlipElements = document.querySelectorAll('.book-flip');
            window.addEventListener('scroll', () => {
                bookFlipElements.forEach(el => {
                    el.style.transform = `rotateY(${window.scrollY * 0.1}deg)`;
                });
            });
        });
    </script>
</body>
</html>
