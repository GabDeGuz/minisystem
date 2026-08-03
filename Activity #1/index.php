<?php
// Include the reusable header component
include 'includes/header.php';
?>

<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <div class="hero-content">
            <span class="hero-tagline">Welcome to De Guzman Resort</span>
            <h1 class="hero-title">
                A Sanctuary of <span>Pure Serenity & Luxury</span>
            </h1>
            <p class="hero-desc">
                Immerse yourself in a world of refined tropical luxury. Indulge in private swimming pools, cozy dining, and serene views in Pulilan, Bulacan.
            </p>
            <div class="hero-btns">
                <a href="javascript:void(0)" class="btn btn-white" style="cursor: default;">Explore Suites</a>
                <a href="javascript:void(0)" class="btn btn-secondary" style="border-color: #ffffff; color: #ffffff; cursor: default;">Our Story</a>
            </div>
        </div>
    </div>
</section>

<!-- Floating Booking Widget -->
<div class="booking-widget-wrapper" id="book-form">
    <div class="container">
        <div class="booking-widget">
            <form id="booking-form" class="booking-form-grid">
                <!-- Check In -->
                <div class="booking-field">
                    <label for="check-in">Check In</label>
                    <input type="date" id="check-in" required>
                </div>
                
                <!-- Check Out -->
                <div class="booking-field">
                    <label for="check-out">Check Out</label>
                    <input type="date" id="check-out" required>
                </div>
                
                <!-- Guests -->
                <div class="booking-field">
                    <label for="guests">Guests</label>
                    <select id="guests" required>
                        <option value="1">1 Guest</option>
                        <option value="2" selected>2 Guests</option>
                        <option value="3">3 Guests</option>
                        <option value="4">4 Guests</option>
                        <option value="5+">5+ Guests</option>
                    </select>
                </div>
                
                <!-- Room Type -->
                <div class="booking-field">
                    <label for="room-type">Room Type</label>
                    <select id="room-type" required>
                        <option value="Deluxe Suite">Deluxe Suite</option>
                        <option value="Executive Lagoon Villa">Executive Lagoon Villa</option>
                        <option value="Family Dormitory Room">Family Dormitory Room</option>
                    </select>
                </div>
                
                <!-- Submit -->
                <div class="booking-field">
                    <button type="button" class="btn btn-primary btn-search" style="cursor: default;">Check Space</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- About Teaser Section -->
<section class="section" id="about">
    <div class="container about-teaser-grid">
        <div class="about-teaser-content">
            <span class="section-subtitle">Discover Paradise</span>
            <h2 class="section-title">An Unforgettable Island Luxury Resort Experience</h2>
            <div class="about-teaser-text">
                <p>
                    Nestled in the peaceful countryside of Pulilan, Bulacan, De Guzman Resort stands as a private getaway sanctuary. Offering premium comfort coupled with clean, relaxing surroundings, we provide a getaway that refreshes your body and uplifts your soul.
                </p>
                <p>
                    From curated modern luxury villas designed to offer maximum isolation, to leisure activities and sensory culinary journeys, every detail of your stay is hand-designed to provide unparalleled tranquility.
                </p>
            </div>
            <div class="teaser-features">
                <div class="teaser-feat-item">
                    <i class="fa-solid fa-circle-check"></i> Lush Tropical Gardens
                </div>
                <div class="teaser-feat-item">
                    <i class="fa-solid fa-circle-check"></i> 24/7 Personal Butler Service
                </div>
                <div class="teaser-feat-item">
                    <i class="fa-solid fa-circle-check"></i> High-Speed Wireless Fiber
                </div>
                <div class="teaser-feat-item">
                    <i class="fa-solid fa-circle-check"></i> Exclusive Private Pool Access
                </div>
            </div>
            <a href="javascript:void(0)" class="btn btn-primary" style="cursor: default;">Learn Our Heritage</a>
        </div>

        <div class="about-teaser-images">
            <img src="assets/img/pool.jpg" alt="De Guzman Resort Sunset View">
        </div>
    </div>
</section>

<!-- Amenities Section -->
<section class="section section-bg-light" id="amenities">
    <div class="container">
        <div class="section-header">
            <span class="section-subtitle">Exquisite Amenities</span>
            <h2 class="section-title">Designed for Your Utmost Relaxation</h2>
            <p class="section-desc">We offer a wide array of premium facilities and curated amenities to ensure your escape is comfortable, active, and fully restorative.</p>
        </div>
        
        <div class="features-grid">
            <!-- Amenity 1 -->
            <div class="feature-card">
                <div class="feature-icon-wrapper">
                    <i class="fa-solid fa-water"></i>
                </div>
                <h3 class="feature-title">Infinity Pool</h3>
                <p>Enjoy a refreshing swim with panoramic views of the ocean blending seamlessly into the horizon.</p>
            </div>
            
            <!-- Amenity 2 -->
            <div class="feature-card">
                <div class="feature-icon-wrapper">
                    <i class="fa-solid fa-spa"></i>
                </div>
                <h3 class="feature-title">Wellness Spa</h3>
                <p>Indulge in organic therapies, soothing oil massages, and custom skin treatments designed by specialists.</p>
            </div>
            
            <!-- Amenity 3 -->
            <div class="feature-card">
                <div class="feature-icon-wrapper">
                    <i class="fa-solid fa-utensils"></i>
                </div>
                <h3 class="feature-title">Gourmet Dining</h3>
                <p>Taste fresh local catch and culinary art crafted by award-winning chefs overlooking the sea breeze.</p>
            </div>
            
            <!-- Amenity 4 -->
            <div class="feature-card">
                <div class="feature-icon-wrapper">
                    <i class="fa-solid fa-umbrella-beach"></i>
                </div>
                <h3 class="feature-title">Private Shore</h3>
                <p>Wander along our secured white-sand shore, fully equipped with luxury loungers and private cabanas.</p>
            </div>
        </div>
    </div>
</section>

<!-- Rooms Section -->
<section class="section" id="rooms">
    <div class="container">
        <div class="section-header">
            <span class="section-subtitle">Our Accommodations</span>
            <h2 class="section-title">Rooms & Premium Suites</h2>
            <p class="section-desc">Discover the perfect haven tailored for your comfort. All options are designed to provide stunning views and premium amenities.</p>
        </div>

        <div class="rooms-grid">
            <!-- Room 1 -->
            <div class="room-card">
                <div class="room-img-wrapper">
                    <img src="assets/img/lobby.jpg" alt="Deluxe Suite">
                    <span class="room-badge">Popular Choice</span>
                </div>
                <div class="room-content">
                    <h3 class="room-title">Deluxe Suite</h3>
                    <p class="room-desc">A spacious suite featuring high-ceiling design, elegant furniture, a private lounge area, and tall windows that bathe the room in natural light.</p>
                    <div class="room-amenities">
                        <div class="room-amenity"><i class="fa-solid fa-maximize"></i> 55 m²</div>
                        <div class="room-amenity"><i class="fa-solid fa-bed"></i> King Bed</div>
                        <div class="room-amenity"><i class="fa-solid fa-eye"></i> Resort View</div>
                    </div>
                    <div class="room-footer">
                        <div class="room-price">
                            <span class="room-price-val">₱12,500</span>
                            <span class="room-price-period">/ night</span>
                        </div>
                        <a href="javascript:void(0)" class="btn btn-secondary" style="padding: 0.5rem 1.25rem; font-size: 0.75rem; cursor: default;">View Details</a>
                    </div>
                </div>
            </div>

            <!-- Room 2 -->
            <div class="room-card">
                <div class="room-img-wrapper">
                    <img src="assets/img/villa.jpg" alt="Executive Lagoon Villa">
                    <span class="room-badge">Exclusive Access</span>
                </div>
                <div class="room-content">
                    <h3 class="room-title">Executive Lagoon Villa</h3>
                    <p class="room-desc">Built in a charming tropical cottage design, this premium villa offers immediate deck access to the lush garden lawns and pools.</p>
                    <div class="room-amenities">
                        <div class="room-amenity"><i class="fa-solid fa-maximize"></i> 85 m²</div>
                        <div class="room-amenity"><i class="fa-solid fa-bed"></i> King + Twin</div>
                        <div class="room-amenity"><i class="fa-solid fa-eye"></i> Gardens</div>
                    </div>
                    <div class="room-footer">
                        <div class="room-price">
                            <span class="room-price-val">₱18,900</span>
                            <span class="room-price-period">/ night</span>
                        </div>
                        <a href="javascript:void(0)" class="btn btn-secondary" style="padding: 0.5rem 1.25rem; font-size: 0.75rem; cursor: default;">View Details</a>
                    </div>
                </div>
            </div>

            <!-- Room 3 -->
            <div class="room-card">
                <div class="room-img-wrapper">
                    <img src="assets/img/dorm.jpg" alt="Family Dormitory Room">
                    <span class="room-badge">Group Friendly</span>
                </div>
                <div class="room-content">
                    <h3 class="room-title">Family Dormitory Room</h3>
                    <p class="room-desc">Perfect for larger families, barkada getaways, and group retreats. Features comfortable bunk configurations and full air-conditioning.</p>
                    <div class="room-amenities">
                        <div class="room-amenity"><i class="fa-solid fa-maximize"></i> 60 m²</div>
                        <div class="room-amenity"><i class="fa-solid fa-bed"></i> 4 Bunk Beds</div>
                        <div class="room-amenity"><i class="fa-solid fa-eye"></i> Gardens</div>
                    </div>
                    <div class="room-footer">
                        <div class="room-price">
                            <span class="room-price-val">₱28,000</span>
                            <span class="room-price-period">/ night</span>
                        </div>
                        <a href="javascript:void(0)" class="btn btn-secondary" style="padding: 0.5rem 1.25rem; font-size: 0.75rem; cursor: default;">View Details</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call To Action Section -->
<section class="section" style="background-image: linear-gradient(rgba(7, 22, 37, 0.7), rgba(7, 22, 37, 0.7)), url('assets/img/hall.jpg'); background-size: cover; background-position: center; background-attachment: fixed; text-align: center; color: var(--color-white);">
    <div class="container" style="max-width: 800px;">
        <span class="section-subtitle" style="color: var(--color-accent);">Your Paradise Awaits</span>
        <h2 class="section-title" style="color: var(--color-white); font-size: 3rem; margin-bottom: 1.5rem;">Ready to Create Unforgettable Memories?</h2>
        <p style="font-size: 1.15rem; margin-bottom: 3rem; color: rgba(255,255,255,0.85);">
            Book direct today to receive our exclusive best-rate guarantee, complimentary welcome cocktails, and flexible cancellation options.
        </p>
        <a href="javascript:void(0)" class="btn btn-primary" style="padding: 1.1rem 2.5rem; cursor: default;">Secure Your Booking</a>
    </div>
</section>

<?php
// Include the reusable footer component
include 'includes/footer.php';
?>
