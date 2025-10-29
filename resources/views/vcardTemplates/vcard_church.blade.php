<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $profile->display_name ?: $user->name }} - Church Profile</title>
    <meta name="description" content="{{ $profile->bio ?: 'Church Profile Card' }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ $profile->pwa_icon ? Storage::disk('public')->url($profile->pwa_icon) : '/favicon.ico' }}">

    <!-- Fonts & CSS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="{{ asset('front/css/bootstrap.min.css') }}" rel="stylesheet">
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Slick Slider -->
    <link rel="stylesheet" href="{{ asset('assets/css/slider/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slider/css/slick-theme.min.css') }}">
    
    <!-- Flatpickr for Appointments -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- TailwindCSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'cormorant': ['Cormorant Garamond', 'serif'],
                        'montserrat': ['Montserrat', 'sans-serif'],
                    },
                    colors: {
                        'church-gold': '#D4AF37',
                        'church-burgundy': '#800020',
                        'church-navy': '#14213D',
                        'church-cream': '#FFF8E7',
                    },
                    animation: {
                        'fade-in': 'fadeIn 1s ease-out',
                        'slide-up': 'slideUp 0.8s ease-out',
                        'slide-down': 'slideDown 0.8s ease-out',
                        'slide-in-left': 'slideInLeft 0.8s ease-out',
                        'slide-in-right': 'slideInRight 0.8s ease-out',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(20px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
                        },
                        slideDown: {
                            '0%': { transform: 'translateY(-20px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
                        },
                        slideInLeft: {
                            '0%': { transform: 'translateX(-20px)', opacity: '0' },
                            '100%': { transform: 'translateX(0)', opacity: '1' },
                        },
                        slideInRight: {
                            '0%': { transform: 'translateX(20px)', opacity: '0' },
                            '100%': { transform: 'translateX(0)', opacity: '1' },
                        },
                    }
                }
            }
        }
    </script>
    <style>
        .church-gradient {
            background: linear-gradient(135deg, #D4AF37 0%, #800020 100%);
        }
        .church-card {
            background-color: rgba(255, 248, 231, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(212, 175, 55, 0.2);
        }
        .church-button {
            background: linear-gradient(135deg, #D4AF37 0%, #800020 100%);
            transition: all 0.3s ease;
        }
        .church-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(212, 175, 55, 0.3);
        }
        .profile-image-border {
            position: relative;
            padding: 4px;
            background: linear-gradient(135deg, #D4AF37 0%, #800020 100%);
            border-radius: 9999px;
        }
        .profile-image-border::after {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 9999px;
            background: linear-gradient(135deg, #D4AF37 0%, #800020 100%);
        }
        
        /* Church-specific styles */
        .service-times {
            background-color: rgba(20, 33, 61, 0.05);
            border-left: 4px solid #D4AF37;
        }
        
        .event-card {
            transition: transform 0.3s ease;
        }
        
        .event-card:hover {
            transform: translateY(-5px);
        }
        
        .ministry-card {
            border-radius: 1rem;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .ministry-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        
        .verse-card {
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.1) 0%, rgba(128, 0, 32, 0.1) 100%);
            border-radius: 1rem;
            padding: 2rem;
            margin: 2rem 0;
        }
        
        .testimonial-card {
            background-color: #FFF8E7;
            border-radius: 1rem;
            padding: 2rem;
            margin: 1rem 0;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .sermon-card {
            background: white;
            border-radius: 1rem;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .sermon-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
                linear-gradient(#fff 0 0) content-box, 
                linear-gradient(#fff 0 0);
            mask: 
                linear-gradient(#fff 0 0) content-box, 
                linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
        }

        <!-- Ministries Section -->
        <div class="vcard-one__ministries py-12 bg-white">
            <h2 class="text-3xl font-cormorant font-bold text-center mb-8">Our Ministries</h2>
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($profile->ministries ?? [] as $ministry)
                    <div class="ministry-card">
                        @if($ministry->image)
                            <img src="{{ Storage::disk('public')->url($ministry->image) }}" 
                                 alt="{{ $ministry->name }}"
                                 class="w-full h-48 object-cover"
                                 loading="lazy">
                        @endif
                        <div class="p-4">
                            <h3 class="text-xl font-semibold mb-2">{{ $ministry->name }}</h3>
                            <p class="text-gray-600 mb-4">{{ $ministry->description }}</p>
                            @if($ministry->meeting_time)
                                <p class="text-sm text-church-burgundy">
                                    <i class="fas fa-clock mr-2"></i>
                                    {{ $ministry->meeting_time }}
                                </p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Upcoming Events -->
        <div class="vcard-one__events py-12 bg-church-cream">
            <h2 class="text-3xl font-cormorant font-bold text-center mb-8">Upcoming Events</h2>
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($profile->events ?? [] as $event)
                    <div class="event-card bg-white rounded-lg shadow-md overflow-hidden">
                        @if($event->image)
                            <img src="{{ Storage::disk('public')->url($event->image) }}"
                                 alt="{{ $event->name }}"
                                 class="w-full h-48 object-cover"
                                 loading="lazy">
                        @endif
                        <div class="p-4">
                            <h3 class="text-xl font-semibold mb-2">{{ $event->name }}</h3>
                            <p class="text-gray-600 mb-4">{{ $event->description }}</p>
                            <div class="flex items-center text-sm text-church-burgundy">
                                <span class="mr-4">
                                    <i class="fas fa-calendar mr-2"></i>
                                    {{ $event->date }}
                                </span>
                                <span>
                                    <i class="fas fa-clock mr-2"></i>
                                    {{ $event->time }}
                                </span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="vcard-one__contact py-12 bg-church-cream">
            <h2 class="text-3xl font-cormorant font-bold text-center mb-8">Connect With Us</h2>
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto">
                    <!-- Contact Details -->
                    <div class="bg-white rounded-lg p-6 shadow-sm">
                        <h3 class="text-xl font-semibold mb-4">Contact Information</h3>
                        <ul class="space-y-4">
                            @if($profile->phone)
                            <li class="flex items-center">
                                <i class="fas fa-phone text-church-burgundy mr-3"></i>
                                <span>{{ $profile->phone }}</span>
                            </li>
                            @endif
                            @if($profile->email)
                            <li class="flex items-center">
                                <i class="fas fa-envelope text-church-burgundy mr-3"></i>
                                <span>{{ $profile->email }}</span>
                            </li>
                            @endif
                            @if($profile->address)
                            <li class="flex items-center">
                                <i class="fas fa-map-marker-alt text-church-burgundy mr-3"></i>
                                <span>{{ $profile->address }}</span>
                            </li>
                            @endif
                        </ul>
                        
                        <!-- Social Media Links -->
                        <div class="mt-6">
                            <h4 class="text-lg font-semibold mb-3">Follow Us</h4>
                            <div class="flex space-x-4">
                                @if($profile->facebook)
                                <a href="{{ $profile->facebook }}" class="text-church-burgundy hover:text-church-gold transition-colors">
                                    <i class="fab fa-facebook fa-2x"></i>
                                </a>
                                @endif
                                @if($profile->twitter)
                                <a href="{{ $profile->twitter }}" class="text-church-burgundy hover:text-church-gold transition-colors">
                                    <i class="fab fa-twitter fa-2x"></i>
                                </a>
                                @endif
                                @if($profile->instagram)
                                <a href="{{ $profile->instagram }}" class="text-church-burgundy hover:text-church-gold transition-colors">
                                    <i class="fab fa-instagram fa-2x"></i>
                                </a>
                                @endif
                                @if($profile->youtube)
                                <a href="{{ $profile->youtube }}" class="text-church-burgundy hover:text-church-gold transition-colors">
                                    <i class="fab fa-youtube fa-2x"></i>
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Contact Form -->
                    <div class="bg-white rounded-lg p-6 shadow-sm">
                        <h3 class="text-xl font-semibold mb-4">Send Us a Message</h3>
                        <form id="contactForm" class="space-y-4">
                            @csrf
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                <input type="text" name="name" id="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-church-gold focus:ring-church-gold" required>
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" name="email" id="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-church-gold focus:ring-church-gold" required>
                            </div>
                            <div>
                                <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
                                <textarea name="message" id="message" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-church-gold focus:ring-church-gold" required></textarea>
                            </div>
                            <div id="formResponse" class="hidden">
                                <p class="text-church-burgundy"></p>
                            </div>
                            <button type="button" onclick="submitContactForm()" class="church-button text-white px-6 py-2 rounded-md shadow-sm hover:shadow-md transition-all w-full">
                                Send Message
                            </button>
                        </form>
                        
                        <script>
                            function submitContactForm() {
                                const form = document.getElementById('contactForm');
                                const response = document.getElementById('formResponse');
                                const responseText = response.querySelector('p');
                                
                                // Basic form validation
                                const name = form.querySelector('#name').value;
                                const email = form.querySelector('#email').value;
                                const message = form.querySelector('#message').value;
                                
                                if (!name || !email || !message) {
                                    response.classList.remove('hidden');
                                    responseText.textContent = 'Please fill in all fields.';
                                    return;
                                }
                                
                                // Show submission message
                                response.classList.remove('hidden');
                                responseText.textContent = 'Thank you for your message. We will get back to you soon.';
                                
                                // Clear form
                                form.reset();
                            }
                        </script>
                    </div>
                </div>
            </div>
        </div>

        <!-- Weekly Sermon -->
        <div class="vcard-one__sermon py-12 bg-white">
            <h2 class="text-3xl font-cormorant font-bold text-center mb-8">Latest Sermon</h2>
            <div class="container mx-auto px-4">
                @if($profile->latest_sermon)
                <div class="sermon-card max-w-3xl mx-auto">
                    @if($profile->latest_sermon->video_url)
                        <div class="aspect-w-16 aspect-h-9 mb-4">
                            <iframe src="{{ $profile->latest_sermon->video_url }}"
                                    class="w-full"
                                    style="aspect-ratio: 16/9;"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen></iframe>
                        </div>
                    @endif
                    <div class="p-6">
                        <h3 class="text-2xl font-semibold mb-2">{{ $profile->latest_sermon->title }}</h3>
                        <p class="text-gray-600 mb-4">{{ $profile->latest_sermon->description }}</p>
                        <div class="flex items-center text-sm text-church-burgundy">
                            <span class="mr-4">
                                <i class="fas fa-user mr-2"></i>
                                {{ $profile->latest_sermon->speaker }}
                            </span>
                            <span>
                                <i class="fas fa-calendar mr-2"></i>
                                {{ $profile->latest_sermon->date }}
                            </span>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
        }
        /* Make background image less intrusive behind text */
        .hero-overlay { background: linear-gradient(to bottom, rgba(0,0,0,.45), rgba(0,0,0,.2), rgba(0,0,0,.65)); }
        
        /* Clamp utilities for text overflow */
        .clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .clamp-3 { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
        
        /* Better focus styles for accessibility */
        .church-button:focus-visible { outline: 2px solid #D4AF37; outline-offset: 2px; }
    </style>
</head>
<body class="min-h-screen bg-church-cream font-montserrat">
    <!-- Hero Section with Background -->
    <div class="vcard-one__banner relative w-full overflow-hidden h-64 sm:h-80 md:h-[420px]">
        <!-- Background Image -->
        <div class="absolute inset-0 z-0">
            <!-- Fallback base gradient background -->
            <div class="absolute inset-0 church-gradient"></div>
            @if($profile->background_image)
                <img src="{{ Storage::disk('public')->url($profile->background_image) }}"
                     alt="Background image of {{ $profile->display_name ?: $user->name }}"
                     class="w-full h-full object-cover object-center"
                     loading="lazy" decoding="async">
            @endif

            <!-- Language Selector -->
            <div class="absolute top-0 right-0 p-4 z-10">
                <div class="language">
                    <ul class="text-decoration-none">
                        <li class="dropdown1 dropdown lang-list">
                            <a class="dropdown-toggle lang-head text-decoration-none text-white" data-toggle="dropdown"
                               role="button"
                               aria-haspopup="true" aria-expanded="false">
                                <i class="fa-solid fa-language me-2"></i>Language</a>
                            <ul class="dropdown-menu start-0 lang-hover-list">
                                <li><img src="{{asset('assets/img/vcard1/english.png')}}" width="25px" height="20px" class="me-3"><a href="#">English</a></li>
                                <li><img src="{{asset('assets/img/vcard1/spain.png')}}" width="25px" height="20px" class="me-3"><a href="#">Spanish</a></li>
                                <li><img src="{{asset('assets/img/vcard1/france.png')}}" width="25px" height="20px" class="me-3"><a href="#">French</a></li>
                                <li><img src="{{asset('assets/img/vcard1/arabic.svg')}}" width="25px" height="20px" class="me-3"><a href="#">Arabic</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Dark overlay for readability -->
            <div class="absolute inset-0 hero-overlay"></div>
        </div>
        
        <!-- Profile Section -->
        <div class="vcard-one__profile relative z-10">
            <div class="avatar absolute left-1/2 transform -translate-x-1/2 -bottom-12">
                <div class="profile-image-border">
                    <img src="{{ $profile->profile_photo ? Storage::disk('public')->url($profile->profile_photo) : asset('assets/images/default-avatar.png') }}"
                         alt="Profile Photo"
                         class="w-24 h-24 sm:w-32 sm:h-32 rounded-full object-cover"
                         loading="lazy"/>
                </div>
            </div>
        </div>

        <!-- Church Details -->
        <div class="vcard-one__profile-details text-center text-white relative z-10 pt-8">
            <h1 class="text-3xl sm:text-4xl font-cormorant font-bold mb-2">{{ $profile->display_name ?: $user->name }}</h1>
            @if($profile->tagline)
                <p class="text-lg font-montserrat mb-4">{{ $profile->tagline }}</p>
            @endif
            <div class="max-w-2xl mx-auto px-4">
                <p class="font-montserrat text-sm sm:text-base opacity-90">{{ $profile->bio }}</p>
            </div>
        </div>
        
        <!-- Service Times -->
        <div class="service-times mt-8 max-w-2xl mx-auto p-6 rounded-lg">
            <h2 class="text-2xl font-cormorant font-bold text-center mb-4 text-church-navy">Service Times</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @if($profile->service_times)
                    @foreach($profile->service_times as $service)
                    <div class="p-4 bg-white rounded-lg shadow-sm">
                        <h3 class="font-montserrat font-semibold text-lg">{{ $service->name }}</h3>
                        <p class="text-gray-600">{{ $service->time }}</p>
                        @if($service->description)
                            <p class="text-sm text-gray-500 mt-2">{{ $service->description }}</p>
                        @endif
                    </div>
                    @endforeach
                @endif
            </div>
        </div>
        
        <!-- Decorative Pattern -->
        <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath d=\'M54.627 0l.83.828-1.415 1.415L51.8 0h2.827zM5.373 0l-.83.828L5.96 2.243 8.2 0H5.374zM48.97 0l3.657 3.657-1.414 1.414L46.143 0h2.828zM11.03 0L7.372 3.657 8.787 5.07 13.857 0H11.03zm32.284 0L49.8 6.485 48.384 7.9l-7.9-7.9h2.83zM16.686 0L10.2 6.485 11.616 7.9l7.9-7.9h-2.83zM22.343 0L13.8 8.544 15.214 9.96l9.9-9.9h-2.77zM32 0l-3.657 3.657 1.414 1.414L32 2.828l2.243 2.243 1.414-1.414L32 0zm2.828 0l8.544 8.544-1.414 1.414-9.9-9.9h2.77zm5.657 0l6.485 6.485-1.414 1.414-7.9-7.9h2.83zm5.657 0l3.657 3.657-1.414 1.414L45.143 0h2.828zM39.88 6.485l4.243 4.243-4.243-4.243zm-5.657 5.657l4.243 4.243-4.243-4.243zm-5.657 5.657l4.243 4.243-4.243-4.243zm-5.657 5.657l4.243 4.243-4.243-4.243zm-5.657 5.657l4.243 4.243-4.243-4.243zm-5.657 5.657l4.243 4.243-4.243-4.243zm-5.657 5.657l4.243 4.243-4.243-4.243z\' fill=\'%23D4AF37\' fill-opacity=\'1\' fill-rule=\'evenodd\'/%3E%3C/svg%3E');"></div>

        <!-- Profile Image -->
        <div class="absolute left-1/2 bottom-0 -mb-16 md:-mb-24 transform -translate-x-1/2 z-20">
            <div class="profile-image-border inline-block shadow-2xl">
                <img src="{{ $profile->profile_image ? Storage::disk('public')->url($profile->profile_image) : asset('images/default-profile.jpg') }}"
                     alt="Profile photo of {{ $profile->display_name ?: $user->name }}"
                     class="w-32 h-32 sm:w-40 sm:h-40 md:w-48 md:h-48 rounded-full object-cover"
                     loading="lazy" decoding="async">
            </div>
        </div>
    </div>

    <div class="relative min-h-screen flex flex-col items-center justify-start p-4 z-10 mt-24 md:mt-32">
        <div class="w-full max-w-2xl space-y-6">
            <!-- Profile Header -->
            <div class="church-card rounded-3xl p-8 text-center relative overflow-hidden animate-fade-in">

                <!-- Name and Title -->
                <h1 class="font-cormorant text-2xl sm:text-3xl font-bold text-church-navy mb-1 sm:mb-2 animate-slide-up clamp-2">
                    {{ $profile->display_name ?: $user->name }}
                </h1>

                @if($profile->profession)
                    <p class="text-church-burgundy font-medium mb-4 animate-slide-up" style="animation-delay: 0.1s">
                        {{ $profile->profession }}
                    </p>
                @endif

                @if($profile->bio)
                    <p class="text-gray-700 text-sm leading-relaxed mb-5 sm:mb-6 animate-slide-up clamp-3" style="animation-delay: 0.2s">
                        {{ $profile->bio }}
                    </p>
                @endif

                <!-- Quick Action Buttons -->
                <div class="grid grid-cols-2 gap-3 sm:gap-4 mb-5 sm:mb-6">
                    @if($profile->phone)
                        <a href="tel:{{ $profile->phone }}"
                           class="church-button text-white px-6 py-3 rounded-xl font-semibold text-sm transition-all duration-300 flex items-center justify-center">
                            <i class="fas fa-phone mr-2"></i>
                            Call
                        </a>
                    @endif

                    @if($user->email)
                        <a href="mailto:{{ $user->email }}"
                           class="church-button text-white px-6 py-3 rounded-xl font-semibold text-sm transition-all duration-300 flex items-center justify-center">
                            <i class="fas fa-envelope mr-2"></i>
                            Email
                        </a>
                    @endif
                </div>
            </div>

            <!-- Contact Information -->
            <div class="church-card rounded-3xl p-5 sm:p-6 animate-slide-in-left">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 church-gradient rounded-xl flex items-center justify-center mr-3">
                        <i class="fas fa-address-card text-white"></i>
                    </div>
                    <h2 class="font-cormorant text-xl font-bold text-church-navy">Contact Information</h2>
                </div>

                <div class="space-y-3 sm:space-y-4">
                    @if($user->email)
                        <a href="mailto:{{ $user->email }}"
                           class="flex items-center p-4 bg-white/50 rounded-xl hover:bg-white/80 transition-all duration-300">
                            <div class="w-8 h-8 bg-church-burgundy rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-envelope text-white text-sm"></i>
                            </div>
                            <div>
                                <p class="text-church-navy font-medium">Email</p>
                                <p class="text-gray-600 text-sm">{{ $user->email }}</p>
                            </div>
                        </a>
                    @endif

                    @if($profile->phone)
                        <a href="tel:{{ $profile->phone }}"
                           class="flex items-center p-4 bg-white/50 rounded-xl hover:bg-white/80 transition-all duration-300">
                            <div class="w-8 h-8 bg-church-gold rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-phone text-white text-sm"></i>
                            </div>
                            <div>
                                <p class="text-church-navy font-medium">Phone</p>
                                <p class="text-gray-600 text-sm">{{ $profile->phone }}</p>
                            </div>
                        </a>
                    @endif

                    @if($profile->location)
                        <a href="https://maps.google.com/?q={{ urlencode($profile->location) }}" target="_blank"
                           class="flex items-center p-4 bg-white/50 rounded-xl hover:bg-white/80 transition-all duration-300">
                            <div class="w-8 h-8 bg-church-navy rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-map-marker-alt text-white text-sm"></i>
                            </div>
                            <div>
                                <p class="text-church-navy font-medium">Location</p>
                                <p class="text-gray-600 text-sm">{{ $profile->location }}</p>
                            </div>
                        </a>
                    @endif
                </div>
            </div>

            <!-- Social Media Links -->
            @if($socialLinks->count() > 0)
                <div class="church-card rounded-3xl p-6 animate-slide-in-right">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 church-gradient rounded-xl flex items-center justify-center mr-3">
                            <i class="fas fa-share-alt text-white"></i>
                        </div>
                        <h2 class="font-cormorant text-xl font-bold text-church-navy">Connect With Us</h2>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        @foreach($socialLinks as $link)
                            <a href="{{ $link->url }}" target="_blank"
                               class="flex items-center p-3 bg-white/50 rounded-xl hover:bg-white/80 transition-all duration-300">
                                <div class="w-8 h-8 {{ $link->platform_color }} rounded-lg flex items-center justify-center mr-3">
                                    <i class="{{ $link->platform_icon }} text-white text-sm"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-church-navy font-medium text-sm">{{ ucfirst($link->platform) }}</p>
                                    <p class="text-gray-600 text-xs truncate">{{ $link->display_name ?: 'Visit Profile' }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Gallery / Portfolio -->
            @if($galleryItems->count() > 0)
                <div class="church-card rounded-3xl p-5 sm:p-6 animate-fade-in" style="animation-delay: 0.4s">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 church-gradient rounded-xl flex items-center justify-center mr-3">
                            <i class="fas fa-images text-white"></i>
                        </div>
                        <h2 class="font-cormorant text-xl font-bold text-church-navy">Our Gallery</h2>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        @foreach($galleryItems->take(6) as $item)
                            <div class="relative group overflow-hidden rounded-xl cursor-pointer animate-slide-up"
                                 style="animation-delay: {{ $loop->index * 0.1 }}s"
                                 onclick="openImageViewer('{{ Storage::disk('public')->url($item->image_path) }}', {{ $loop->index }})">
                                <img src="{{ Storage::disk('public')->url($item->image_path) }}"
                                     alt="{{ $item->title }}"
                                     class="w-full h-32 object-cover transition-transform duration-500 group-hover:scale-110 gallery-image">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100">
                                        <i class="fas fa-search-plus text-white text-xl"></i>
                                    </div>
                                </div>
                                @if($item->title)
                                    <div class="absolute bottom-0 left-0 right-0 p-2 translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                                        <p class="text-white text-xs font-medium">{{ $item->title }}</p>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Save Contact Button -->
            <!-- Sticky mobile Save Contact CTA -->
            <div class="fixed bottom-4 left-4 right-4 z-40 md:static md:z-auto">
                <button onclick="downloadVCard()"
                        class="church-button w-full py-3 sm:py-4 px-6 rounded-2xl text-white font-bold text-base sm:text-lg flex items-center justify-center shadow-lg">
                    <i class="fas fa-download mr-2 sm:mr-3"></i>
                    Save Contact
                </button>
            </div>

            <!-- Footer -->
            <div class="text-center py-4 animate-fade-in" style="animation-delay: 0.7s">
                <p class="text-gray-500 text-xs">
                    Powered by Whiteray Smart Tag
                </p>
            </div>
        </div>
    </div>

    <!-- Image Viewer Modal -->
    <div id="imageViewer" class="fixed inset-0 bg-black/90 z-50 hidden">
        <button onclick="closeImageViewer()" class="absolute top-4 right-4 text-white text-3xl hover:text-gray-300 z-10">
            <i class="fas fa-times"></i>
        </button>
        <button id="prevImage" class="absolute left-4 top-1/2 -translate-y-1/2 text-white text-3xl hover:text-gray-300 z-10">
            <i class="fas fa-chevron-left"></i>
        </button>
        <button id="nextImage" class="absolute right-4 top-1/2 -translate-y-1/2 text-white text-3xl hover:text-gray-300 z-10">
            <i class="fas fa-chevron-right"></i>
        </button>
        <div class="w-full h-full flex items-center justify-center p-4">
            <img id="fullImage" src="" alt="Full size image" class="max-h-full max-w-full object-contain">
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Image Viewer
        let currentImageIndex = 0;
        let galleryImages = [];

        function openImageViewer(imageUrl, index) {
            const viewer = document.getElementById('imageViewer');
            const fullImage = document.getElementById('fullImage');
            
            // Get all gallery images if not already loaded
            if (galleryImages.length === 0) {
                galleryImages = Array.from(document.querySelectorAll('.gallery-image')).map(img => img.src);
            }
            
            currentImageIndex = index;
            fullImage.src = imageUrl;
            viewer.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeImageViewer() {
            const viewer = document.getElementById('imageViewer');
            viewer.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function showNextImage() {
            currentImageIndex = (currentImageIndex + 1) % galleryImages.length;
            document.getElementById('fullImage').src = galleryImages[currentImageIndex];
        }

        function showPrevImage() {
            currentImageIndex = (currentImageIndex - 1 + galleryImages.length) % galleryImages.length;
            document.getElementById('fullImage').src = galleryImages[currentImageIndex];
        }

        document.getElementById('prevImage').addEventListener('click', showPrevImage);
        document.getElementById('nextImage').addEventListener('click', showNextImage);

        // Handle keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (document.getElementById('imageViewer').classList.contains('hidden')) return;
            
            if (e.key === 'Escape') closeImageViewer();
            if (e.key === 'ArrowLeft') showPrevImage();
            if (e.key === 'ArrowRight') showNextImage();
        });

        // vCard Download Function
        function downloadVCard() {
            // Create a more detailed vCard format
            const vcard = `BEGIN:VCARD
VERSION:3.0
FN:{{ $profile->display_name ?: $user->name }}
N:{{ implode(';', array_pad(explode(' ', $user->name), 5, '')) }}
@if($profile->profession)TITLE:{{ $profile->profession }}
ORG:{{ $profile->profession }}@endif
@if($user->email)EMAIL;type=INTERNET;type=HOME:{{ $user->email }}@endif
@if($profile->phone)TEL;type=CELL:{{ $profile->phone }}@endif
@if($profile->website)URL:{{ $profile->website }}@endif
@if($profile->location)ADR;type=HOME:;;{{ $profile->location }};;;;
LABEL;type=HOME:{{ $profile->location }}@endif
@if($profile->bio)NOTE:{{ $profile->bio }}@endif
REV:{{ now()->format('Y-m-d\THis\Z') }}
END:VCARD`;

            // Create Blob with UTF-8 encoding and proper MIME type
            const blob = new Blob([vcard], { 
                type: 'text/vcard;charset=utf-8' 
            });

            // Check if it's a mobile device
            const isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);

            if (isMobile) {
                // For mobile devices, use a direct download that triggers the native contact save
                const url = window.URL.createObjectURL(blob);
                window.location.href = url;
                setTimeout(() => {
                    window.URL.revokeObjectURL(url);
                }, 1000);
            } else {
                // For desktop devices, use the traditional download approach
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = '{{ Str::slug($profile->display_name ?: $user->name) }}-contact.vcf';
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                window.URL.revokeObjectURL(url);
            }
        }
    </script>
</body>
</html>
