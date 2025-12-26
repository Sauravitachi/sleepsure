@extends('layouts.app')

@section('title', 'Premium Mattress & Sleep Solutions')

@section('content')
 <!-- Page Header -->
    <div class="page-header" style="margin: 60px 0;">
        <div class="container">
            <h1 class="page-title">Join the SleepSure Team</h1>
            <p class="page-subtitle">Help us revolutionize sleep technology while building an amazing career</p>
        </div>
    </div>

    <div class="container-fluid">
        <!-- Hero Section -->
        <div class="hero-section">
            <div class="hero-content">
                <h2 class="hero-title">Build Your Career While Helping People Sleep Better</h2>
                <p class="hero-description">At SleepSure, we're passionate about improving sleep quality through innovative products and exceptional customer experiences. Join our growing team and make a real difference in people's lives.</p>
                <p class="hero-description">We're looking for talented, passionate individuals who share our commitment to quality, innovation, and customer satisfaction.</p>
                <a href="#open-positions" class="btn btn-primary">
                    <i class="fas fa-briefcase"></i> View Open Positions
                </a>
            </div>
            <div class="hero-image">
                <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" alt="SleepSure Team">
            </div>
        </div>

        <!-- Stats Section -->
        <div class="stats-section">
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-number">150+</div>
                    <div class="stat-label">Team Members</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">98%</div>
                    <div class="stat-label">Employee Satisfaction</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">25+</div>
                    <div class="stat-label">Countries Served</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">4.8★</div>
                    <div class="stat-label">Customer Rating</div>
                </div>
            </div>
        </div>

        <!-- Benefits Section -->
        <div class="benefits-section">
            <h2 class="section-title">Why Work at SleepSure?</h2>
            <div class="benefits-grid">
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <i class="fas fa-heartbeat"></i>
                    </div>
                    <h3 class="benefit-title">Health & Wellness</h3>
                    <p>Comprehensive medical, dental, and vision insurance for you and your family.</p>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h3 class="benefit-title">Learning & Development</h3>
                    <p>$5,000 annual budget for professional development and continuous learning.</p>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <i class="fas fa-home"></i>
                    </div>
                    <h3 class="benefit-title">Flexible Work</h3>
                    <p>Hybrid work model and flexible hours to support work-life balance.</p>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <i class="fas fa-umbrella-beach"></i>
                    </div>
                    <h3 class="benefit-title">Time Off</h3>
                    <p>Unlimited PTO, paid parental leave, and 12 company holidays.</p>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <i class="fas fa-bed"></i>
                    </div>
                    <h3 class="benefit-title">Sleep Products</h3>
                    <p>Free SleepSure mattress and bedding products for your home.</p>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <i class="fas fa-dumbbell"></i>
                    </div>
                    <h3 class="benefit-title">Fitness & Wellness</h3>
                    <p>Gym membership reimbursement and weekly wellness activities.</p>
                </div>
            </div>
        </div>

       

        <!-- Culture Section -->
        <div class="culture-section">
            <h2 class="culture-title">Our Culture</h2>
            <p class="culture-description">At SleepSure, we believe that well-rested employees do their best work. Our culture is built on collaboration, innovation, and work-life balance.</p>
            
            <div class="culture-features">
                <div class="culture-feature">
                    <i class="fas fa-users"></i>
                    <h3>Collaborative</h3>
                    <p>We work together across teams to solve complex challenges</p>
                </div>
                <div class="culture-feature">
                    <i class="fas fa-lightbulb"></i>
                    <h3>Innovative</h3>
                    <p>We encourage creative thinking and new approaches</p>
                </div>
                <div class="culture-feature">
                    <i class="fas fa-hand-holding-heart"></i>
                    <h3>Supportive</h3>
                    <p>We prioritize employee wellbeing and mental health</p>
                </div>
                <div class="culture-feature">
                    <i class="fas fa-chart-line"></i>
                    <h3>Growth-Oriented</h3>
                    <p>We invest in our employees' professional development</p>
                </div>
            </div>
        </div>

        <!-- Application Process -->
        <div class="process-section">
            <h2 class="section-title">Our Hiring Process</h2>
            <div class="process-steps">
                <div class="process-step">
                    <div class="step-number">1</div>
                    <h3 class="step-title">Application</h3>
                    <p>Submit your application and resume</p>
                </div>
                <div class="process-step">
                    <div class="step-number">2</div>
                    <h3 class="step-title">Screening</h3>
                    <p>Initial phone call with our talent team</p>
                </div>
                <div class="process-step">
                    <div class="step-number">3</div>
                    <h3 class="step-title">Interviews</h3>
                    <p>Meet the team and complete skills assessment</p>
                </div>
                <div class="process-step">
                    <div class="step-number">4</div>
                    <h3 class="step-title">Offer</h3>
                    <p>Receive your offer and join the team!</p>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="cta-section">
            <h2 class="cta-title">Ready to Join Our Team?</h2>
            <p class="cta-description">Don't see the perfect role? We're always looking for talented people. Send us your resume and we'll contact you when a matching position opens.</p>
            <a href="#" class="btn btn-primary">
                <i class="fas fa-paper-plane"></i> Submit General Application
            </a>
        </div>
    </div>

@endsection