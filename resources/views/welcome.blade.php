<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SafeHer Bangladesh - Women Safety Platform</title>
    <link rel="preconnect" href="https://fonts.bunny.net">

    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
            * { 
                margin: 0; 
                padding: 0; 
                box-sizing: border-box; 
            }
            
            body { 
                font-family: 'Instrument Sans', -apple-system, BlinkMacSystemFont, sans-serif; 
                line-height: 1.6; 
                color: #333; 
                overflow-x: hidden;
            }

            /* Modern Scrollbar */
            ::-webkit-scrollbar {
                width: 8px;
            }
            ::-webkit-scrollbar-track {
                background: #f1f1f1;
            }
            ::-webkit-scrollbar-thumb {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                border-radius: 4px;
            }
            ::-webkit-scrollbar-thumb:hover {
                background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
            }

            /* Navigation */
            .navbar {
                position: fixed;
                top: 0;
                width: 100%;
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(20px);
                -webkit-backdrop-filter: blur(20px);
                border-bottom: 1px solid rgba(255, 255, 255, 0.2);
                z-index: 1000;
                transition: all 0.3s ease;
            }
            
            .navbar.scrolled {
                background: rgba(255, 255, 255, 0.98);
                box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            }

            .nav-container {
                max-width: 1200px;
                margin: 0 auto;
                padding: 0 2rem;
                display: flex;
                justify-content: space-between;
                align-items: center;
                height: 80px;
            }

            .logo {
                font-size: 1.8rem;
                font-weight: 700;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }

            .nav-links {
                display: flex;
                gap: 2rem;
                align-items: center;
            }

            .nav-links a {
                color: #333;
                text-decoration: none;
                font-weight: 500;
                transition: all 0.3s ease;
                position: relative;
            }

            .nav-links a:hover {
                color: #667eea;
            }

            .nav-links a::after {
                content: '';
                position: absolute;
                bottom: -5px;
                left: 0;
                width: 0;
                height: 2px;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                transition: width 0.3s ease;
            }

            .nav-links a:hover::after {
                width: 100%;
            }

            .btn {
                padding: 12px 28px;
                border: none;
                border-radius: 50px;
                text-decoration: none;
                font-weight: 600;
                transition: all 0.3s ease;
                position: relative;
                overflow: hidden;
                cursor: pointer;
            }

            .btn-primary {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
            }

            .btn-primary:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
            }

            .btn-secondary {
                background: transparent;
                color: #667eea;
                border: 2px solid #667eea;
            }

            .btn-secondary:hover {
                background: #667eea;
                color: white;
                transform: translateY(-2px);
            }

            /* Hero Section */
            .hero {
                min-height: 100vh;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
                display: flex;
                align-items: center;
                justify-content: center;
                position: relative;
                overflow: hidden;
            }

            .hero::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><defs><pattern id="grid" width="50" height="50" patternUnits="userSpaceOnUse"><path d="M 50 0 L 0 0 0 50" fill="none" stroke="rgba(255,255,255,0.05)" stroke-width="1"/></pattern></defs><rect width="100%" height="100%" fill="url(%23grid)"/></svg>');
                animation: float 20s ease-in-out infinite;
            }

            @keyframes float {
                0%, 100% { transform: translate(0, 0) rotate(0deg); }
                33% { transform: translate(30px, -30px) rotate(120deg); }
                66% { transform: translate(-20px, 20px) rotate(240deg); }
            }

            .hero-content {
                text-align: center;
                color: white;
                z-index: 2;
                position: relative;
                max-width: 800px;
                padding: 0 2rem;
            }

            .hero h1 {
                font-size: 4rem;
                font-weight: 700;
                margin-bottom: 1.5rem;
                opacity: 0;
                animation: slideUp 1s ease forwards 0.5s;
            }

            .hero p {
                font-size: 1.3rem;
                margin-bottom: 3rem;
                opacity: 0.9;
                opacity: 0;
                animation: slideUp 1s ease forwards 0.7s;
            }

            .hero-buttons {
                display: flex;
                gap: 1.5rem;
                justify-content: center;
                flex-wrap: wrap;
                opacity: 0;
                animation: slideUp 1s ease forwards 0.9s;
            }

            @keyframes slideUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            /* Floating Elements */
            .floating-shapes {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                overflow: hidden;
                z-index: 1;
            }

            .shape {
                position: absolute;
                background: rgba(255, 255, 255, 0.1);
                border-radius: 50%;
                animation: floatShape 6s ease-in-out infinite;
            }

            .shape:nth-child(1) {
                width: 80px;
                height: 80px;
                top: 20%;
                left: 10%;
                animation-delay: 0s;
            }

            .shape:nth-child(2) {
                width: 120px;
                height: 120px;
                top: 60%;
                right: 10%;
                animation-delay: 2s;
            }

            .shape:nth-child(3) {
                width: 60px;
                height: 60px;
                bottom: 20%;
                left: 20%;
                animation-delay: 4s;
            }

            @keyframes floatShape {
                0%, 100% { transform: translateY(0px) rotate(0deg); }
                50% { transform: translateY(-20px) rotate(180deg); }
            }

            /* Features Section */
            .features {
                padding: 120px 0;
                background: linear-gradient(180deg, #f8fafc 0%, #e2e8f0 100%);
                position: relative;
            }

            .container {
                max-width: 1200px;
                margin: 0 auto;
                padding: 0 2rem;
            }

            .section-header {
                text-align: center;
                margin-bottom: 80px;
            }

            .section-title {
                font-size: 3rem;
                font-weight: 700;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
                margin-bottom: 1rem;
            }

            .section-subtitle {
                font-size: 1.2rem;
                color: #64748b;
                max-width: 600px;
                margin: 0 auto;
            }

            .features-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
                gap: 40px;
                margin-top: 80px;
            }

            .feature-card {
                background: rgba(255, 255, 255, 0.8);
                backdrop-filter: blur(20px);
                -webkit-backdrop-filter: blur(20px);
                padding: 40px;
                border-radius: 24px;
                text-align: center;
                border: 1px solid rgba(255, 255, 255, 0.2);
                box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
                transition: all 0.3s ease;
                position: relative;
                overflow: hidden;
            }

            .feature-card::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                height: 4px;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                opacity: 0;
                transition: opacity 0.3s ease;
            }

            .feature-card:hover {
                transform: translateY(-8px);
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            }

            .feature-card:hover::before {
                opacity: 1;
            }

            .feature-icon {
                font-size: 3.5rem;
                margin-bottom: 24px;
                display: block;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }

            .feature-card h3 {
                font-size: 1.5rem;
                font-weight: 600;
                margin-bottom: 16px;
                color: #1e293b;
            }

            .feature-card p {
                color: #64748b;
                line-height: 1.6;
            }

            /* Stats Section */
            .stats {
                padding: 120px 0;
                background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
                color: white;
                text-align: center;
                position: relative;
            }

            .stats::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="1" fill="rgba(255,255,255,0.1)"/></svg>');
                animation: twinkle 3s ease-in-out infinite;
            }

            @keyframes twinkle {
                0%, 100% { opacity: 0.3; }
                50% { opacity: 1; }
            }

            .stats h2 {
                font-size: 3rem;
                font-weight: 700;
                margin-bottom: 80px;
                position: relative;
                z-index: 2;
            }

            .stats-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                gap: 60px;
                position: relative;
                z-index: 2;
            }

            .stat-item {
                text-align: center;
            }

            .stat-number {
                font-size: 4rem;
                font-weight: 700;
                background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
                display: block;
                margin-bottom: 16px;
            }

            .stat-label {
                font-size: 1.2rem;
                opacity: 0.9;
            }

            /* CTA Section */
            .cta {
                padding: 120px 0;
                background: linear-gradient(180deg, #f8fafc 0%, #e2e8f0 100%);
                text-align: center;
            }

            .cta h2 {
                font-size: 3rem;
                font-weight: 700;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
                margin-bottom: 24px;
            }

            .cta p {
                font-size: 1.2rem;
                color: #64748b;
                margin-bottom: 48px;
                max-width: 600px;
                margin-left: auto;
                margin-right: auto;
            }

            /* Footer */
            .footer {
                background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
                color: white;
                padding: 80px 0 40px;
            }

            .footer-content {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                gap: 60px;
                margin-bottom: 60px;
            }

            .footer-section h3 {
                font-size: 1.3rem;
                font-weight: 600;
                margin-bottom: 24px;
                background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }

            .footer-section p,
            .footer-section a {
                color: #cbd5e1;
                text-decoration: none;
                line-height: 1.8;
                transition: color 0.3s ease;
            }

            .footer-section a:hover {
                color: #f093fb;
            }

            .footer-bottom {
                border-top: 1px solid #475569;
                padding-top: 40px;
                text-align: center;
                color: #94a3b8;
            }

            /* Mobile Responsive */
            @media (max-width: 768px) {
                .nav-links {
                    display: none;
                }
                
                .hero h1 {
                    font-size: 2.5rem;
                }
                
                .hero-buttons {
                    flex-direction: column;
                    align-items: center;
                }
                
                .features-grid {
                    grid-template-columns: 1fr;
                }
                
                .stats-grid {
                    grid-template-columns: repeat(2, 1fr);
                    gap: 40px;
                }
                
                .section-title {
                    font-size: 2.5rem;
                }
                
                .cta h2 {
                    font-size: 2.5rem;
                }
            }

            @media (max-width: 480px) {
                .hero h1 {
                    font-size: 2rem;
                }
                
                .hero p {
                    font-size: 1.1rem;
                }
                
                .stats-grid {
                    grid-template-columns: 1fr;
                }
                
                .feature-card {
                    padding: 30px 20px;
                }
                
                .container {
                    padding: 0 1rem;
                }
            }

            /* Smooth scroll behavior */
            html {
                scroll-behavior: smooth;
            }

            /* Loading animation */
            .fade-in {
                opacity: 0;
                animation: fadeIn 0.8s ease forwards;
            }

            @keyframes fadeIn {
                to {
                    opacity: 1;
                }
            }

        </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar" id="navbar">
        <div class="nav-container">
            <div class="logo">SafeHer Bangladesh</div>
            <div class="nav-links">
                @if (Route::has('login'))
                    <a href="{{ route('login') }}">Login</a>
                @endif
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn btn-primary">Sign Up</a>
                @endif
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="floating-shapes">
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
        </div>
        <div class="hero-content">
            <h1>SafeHer Bangladesh</h1>
            <p>Empowering women with cutting-edge safety technology, community support, and emergency resources across Bangladesh. Together, we create safer spaces for everyone.</p>
            <div class="hero-buttons">
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn btn-primary">Get Started</a>
                @endif
                <a href="#features" class="btn btn-secondary">Learn More</a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Our Features</h2>
                <p class="section-subtitle">Comprehensive safety solutions designed specifically for women's security and empowerment in Bangladesh.</p>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <i class="fas fa-shield-alt feature-icon"></i>
                    <h3>SOS Emergency</h3>
                    <p>Instant emergency alerts with location sharing to trusted contacts and local authorities. One-tap emergency button for immediate help when you need it most.</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-route feature-icon"></i>
                    <h3>Safe Routes</h3>
                    <p>Community-driven safe route mapping. Find well-lit, populated routes and report safety concerns to help others stay safe throughout their journey.</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-users feature-icon"></i>
                    <h3>Community Forum</h3>
                    <p>Connect with other women, share experiences, and get support from a caring community. Anonymous posting available for sensitive discussions.</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-robot feature-icon"></i>
                    <h3>Safety Chatbot</h3>
                    <p>24/7 AI-powered safety assistant providing instant guidance, resources, and emergency contacts whenever you need help or support.</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-bell feature-icon"></i>
                    <h3>Real-time Alerts</h3>
                    <p>Stay informed about safety incidents in your area. Receive notifications about potential risks and important safety updates in real-time.</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-mobile-alt feature-icon"></i>
                    <h3>Personal Safety</h3>
                    <p>Comprehensive safety tools including check-ins, location sharing, emergency contact management, and personal safety tracking.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section class="stats">
        <div class="container">
            <h2>Our Impact</h2>
            <div class="stats-grid">
                <div class="stat-item">
                    <span class="stat-number">15,000+</span>
                    <span class="stat-label">Active Users</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">800+</span>
                    <span class="stat-label">Safe Routes</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">2,500+</span>
                    <span class="stat-label">Emergency Responses</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">64+</span>
                    <span class="stat-label">Cities Covered</span>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
        <div class="container">
            <h2>Join Our Safety Community</h2>
            <p>Be part of the movement to make Bangladesh safer for women. Together, we can create a secure environment where every woman feels empowered and protected.</p>
            <div class="hero-buttons">
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn btn-primary">Create Account</a>
                @endif
                @if (Route::has('login'))
                    <a href="{{ route('login') }}" class="btn btn-secondary">Login</a>
                @endif
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>SafeHer Bangladesh</h3>
                    <p>Empowering women through technology and community support. Building a safer tomorrow, together with innovation and compassion.</p>
                </div>
                <div class="footer-section">
                    <h3>Quick Links</h3>
                    <p><a href="#features">Features</a></p>
                    <p><a href="#about">About Us</a></p>
                    <p><a href="#contact">Contact</a></p>
                    <p><a href="#privacy">Privacy Policy</a></p>
                </div>
                <div class="footer-section">
                    <h3>Emergency Contacts</h3>
                    <p>National Emergency: 999</p>
                    <p>Police: 100</p>
                    <p>Fire Service: 102</p>
                    <p>Medical Emergency: 103</p>
                </div>
                <div class="footer-section">
                    <h3>Support</h3>
                    <p><a href="#help">Help Center</a></p>
                    <p><a href="#safety-tips">Safety Tips</a></p>
                    <p><a href="#community">Community Guidelines</a></p>
                    <p><a href="#feedback">Feedback</a></p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} SafeHer Bangladesh. All rights reserved. Made with ❤️ for women's safety and empowerment.</p>
            </div>
        </div>
    </footer>

    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Intersection Observer for animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('fade-in');
                }
            });
        }, observerOptions);

        // Observe all feature cards
        document.querySelectorAll('.feature-card, .stat-item').forEach(el => {
            observer.observe(el);
        });
    </script>
</body>
</html>
