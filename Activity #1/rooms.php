<?php
// Include the reusable header component
include 'includes/header.php';
?>

<!-- Page Banner -->
<section class="page-banner">
    <div class="page-banner-content">
        <h1 class="page-title">Rooms & Suites</h1>
        <div class="breadcrumb">
            <a href="index.php">Home</a>
            <i class="fa-solid fa-chevron-right" style="font-size: 0.75rem; align-self: center;"></i>
            <span>Accommodations</span>
        </div>
    </div>
</section>

<!-- Rooms Detailed Section -->
<section class="section">
    <div class="container">
        <div class="section-header">
            <span class="section-subtitle">Luxury Shelters</span>
            <h2 class="section-title">Find Your Perfect Sanctuary</h2>
            <p class="section-desc">Each of our spacious accommodations is designed to merge premium modern comforts with stunning views of the surrounding Pulilan, Bulacan landscape.</p>
        </div>

        <div class="rooms-grid" style="grid-template-columns: 1fr; gap: 4rem;">
            <!-- Suite 1 (Horizontal layout for detail page) -->
            <div class="room-card" style="display: flex; flex-direction: row; flex-wrap: wrap;">
                <div class="room-img-wrapper" style="flex: 1 1 450px; height: 350px;">
                    <img src="assets/img/lobby.jpg" alt="Deluxe Suite" style="height: 100%; width: 100%; object-fit: cover;">
                    <span class="room-badge">Popular Choice</span>
                </div>
                <div class="room-content" style="flex: 1 1 450px; display: flex; flex-direction: column; justify-content: center; padding: 3rem;">
                    <span style="color: var(--color-accent); font-weight: 700; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.5rem; display: block;">Resort & Garden View</span>
                    <h3 class="room-title" style="font-size: 2rem; margin-bottom: 1rem;">Deluxe Suite</h3>
                    <p class="room-desc" style="margin-bottom: 1.5rem;">
                        This spacious suite features high-ceiling architecture, elegant furnishings, a private lounge, and large windows offering beautiful views of the resort landscape. Perfect for couples seeking style and comfort.
                    </p>
                    <div class="room-amenities" style="margin-bottom: 1.5rem;">
                        <div class="room-amenity"><i class="fa-solid fa-maximize"></i> 55 m²</div>
                        <div class="room-amenity"><i class="fa-solid fa-bed"></i> King Bed</div>
                        <div class="room-amenity"><i class="fa-solid fa-wifi"></i> Free Wifi</div>
                        <div class="room-amenity"><i class="fa-solid fa-wind"></i> AC</div>
                    </div>
                    <div class="room-footer" style="margin-top: auto; border-top: 1px solid var(--color-border); padding-top: 1.5rem;">
                        <div class="room-price">
                            <span class="room-price-val">₱12,500</span>
                            <span class="room-price-period">/ night</span>
                        </div>
                        <a href="javascript:void(0)" class="btn btn-primary" style="cursor: default;">Book Now</a>
                    </div>
                </div>
            </div>

            <!-- Suite 2 (Horizontal layout for detail page) -->
            <div class="room-card" style="display: flex; flex-direction: row-reverse; flex-wrap: wrap;">
                <div class="room-img-wrapper" style="flex: 1 1 450px; height: 350px;">
                    <img src="assets/img/villa.jpg" alt="Executive Lagoon Villa" style="height: 100%; width: 100%; object-fit: cover;">
                    <span class="room-badge">Exclusive Access</span>
                </div>
                <div class="room-content" style="flex: 1 1 450px; display: flex; flex-direction: column; justify-content: center; padding: 3rem;">
                    <span style="color: var(--color-accent); font-weight: 700; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.5rem; display: block;">Garden & Pool Access</span>
                    <h3 class="room-title" style="font-size: 2rem; margin-bottom: 1rem;">Executive Lagoon Villa</h3>
                    <p class="room-desc" style="margin-bottom: 1.5rem;">
                        Built in a charming tropical cottage design, this premium villa offers immediate deck access to the lush garden lawns and pools. Perfect for families looking for an authentic and comfortable stay.
                    </p>
                    <div class="room-amenities" style="margin-bottom: 1.5rem;">
                        <div class="room-amenity"><i class="fa-solid fa-maximize"></i> 85 m²</div>
                        <div class="room-amenity"><i class="fa-solid fa-bed"></i> King + Twin</div>
                        <div class="room-amenity"><i class="fa-solid fa-wifi"></i> Free Wifi</div>
                        <div class="room-amenity"><i class="fa-solid fa-bath"></i> Soaking Tub</div>
                    </div>
                    <div class="room-footer" style="margin-top: auto; border-top: 1px solid var(--color-border); padding-top: 1.5rem;">
                        <div class="room-price">
                            <span class="room-price-val">₱18,900</span>
                            <span class="room-price-period">/ night</span>
                        </div>
                        <a href="javascript:void(0)" class="btn btn-primary" style="cursor: default;">Book Now</a>
                    </div>
                </div>
            </div>

            <!-- Suite 3 (Horizontal layout for detail page) -->
            <div class="room-card" style="display: flex; flex-direction: row; flex-wrap: wrap;">
                <div class="room-img-wrapper" style="flex: 1 1 450px; height: 350px;">
                    <img src="assets/img/dorm.jpg" alt="Family Dormitory Room" style="height: 100%; width: 100%; object-fit: cover;">
                    <span class="room-badge">Group Friendly</span>
                </div>
                <div class="room-content" style="flex: 1 1 450px; display: flex; flex-direction: column; justify-content: center; padding: 3rem;">
                    <span style="color: var(--color-accent); font-weight: 700; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.5rem; display: block;">Group Retreat</span>
                    <h3 class="room-title" style="font-size: 2rem; margin-bottom: 1rem;">Family Dormitory Room</h3>
                    <p class="room-desc" style="margin-bottom: 1.5rem;">
                        Our flagship group accommodation. Features comfortable multi-bunk configurations, air conditioning, and a layout designed for group outings, retreats, and family barkada getaways.
                    </p>
                    <div class="room-amenities" style="margin-bottom: 1.5rem;">
                        <div class="room-amenity"><i class="fa-solid fa-maximize"></i> 60 m²</div>
                        <div class="room-amenity"><i class="fa-solid fa-bed"></i> 4 Bunk Beds</div>
                        <div class="room-amenity"><i class="fa-solid fa-wifi"></i> Free Wifi</div>
                        <div class="room-amenity"><i class="fa-solid fa-wind"></i> AC</div>
                    </div>
                    <div class="room-footer" style="margin-top: auto; border-top: 1px solid var(--color-border); padding-top: 1.5rem;">
                        <div class="room-price">
                            <span class="room-price-val">₱28,000</span>
                            <span class="room-price-period">/ night</span>
                        </div>
                        <a href="javascript:void(0)" class="btn btn-primary" style="cursor: default;">Book Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
// Include the reusable footer component
include 'includes/footer.php';
?>
