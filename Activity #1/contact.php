<?php
// Include the reusable header component
include 'includes/header.php';
?>

<!-- Page Banner -->
<section class="page-banner">
    <div class="page-banner-content">
        <h1 class="page-title">Contact Us</h1>
        <div class="breadcrumb">
            <a href="index.php">Home</a>
            <i class="fa-solid fa-chevron-right" style="font-size: 0.75rem; align-self: center;"></i>
            <span>Contact</span>
        </div>
    </div>
</section>

<!-- Contact Form and Details Section -->
<section class="section">
    <div class="container contact-grid">
        <!-- Contact Details Column -->
        <div class="contact-card-info">
            <div>
                <span class="section-subtitle">Get In Touch</span>
                <h2 class="section-title" style="font-size: 2.2rem; margin-bottom: 1.5rem;">We'd Love to Hear From You</h2>
                <p style="margin-bottom: 1rem;">
                    For bookings, corporate inquiries, customized packages, or private events, feel free to reach out using our details or by sending a direct message. Our concierge team is available 24/7.
                </p>
            </div>
            
            <div class="contact-detail-item">
                <div class="contact-detail-icon">
                    <i class="fa-solid fa-location-dot"></i>
                </div>
                <div class="contact-detail-content">
                    <h4>Resort Location</h4>
                    <p>Pulilan, Bulacan, Philippines</p>
                </div>
            </div>

            <div class="contact-detail-item">
                <div class="contact-detail-icon">
                    <i class="fa-solid fa-phone"></i>
                </div>
                <div class="contact-detail-content">
                    <h4>Phone Numbers</h4>
                    <p>+63 912 345 6789 (Reservations)<br>+63 998 765 4321 (Events & Sales)</p>
                </div>
            </div>

            <div class="contact-detail-item">
                <div class="contact-detail-icon">
                    <i class="fa-solid fa-envelope"></i>
                </div>
                <div class="contact-detail-content">
                    <h4>Email Address</h4>
                    <p>info@deguzmanresort.com<br>booking@deguzmanresort.com</p>
                </div>
            </div>

            <div class="contact-detail-item">
                <div class="contact-detail-icon">
                    <i class="fa-solid fa-clock"></i>
                </div>
                <div class="contact-detail-content">
                    <h4>Operational Hours</h4>
                    <p>Front Desk & Concierge: 24/7<br>Check-in: 2:00 PM | Check-out: 12:00 PM</p>
                </div>
            </div>
        </div>

        <!-- Contact Form Column -->
        <div class="contact-form-wrapper">
            <h3 style="font-family: var(--font-heading); font-size: 1.75rem; color: var(--color-primary); margin-bottom: 1.5rem;">Send Us a Message</h3>
            
            <form id="contact-form">
                <div class="form-grid-2">
                    <div class="form-group">
                        <label for="contact-name">Full Name</label>
                        <input type="text" id="contact-name" class="form-control" placeholder="John Doe" required>
                    </div>
                    <div class="form-group">
                        <label for="contact-email">Email Address</label>
                        <input type="email" id="contact-email" class="form-control" placeholder="john@example.com" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="contact-subject">Subject</label>
                    <input type="text" id="contact-subject" class="form-control" placeholder="Booking Inquiry / Feedback / Event Planning" required>
                </div>

                <div class="form-group">
                    <label for="contact-message">Message</label>
                    <textarea id="contact-message" class="form-control" placeholder="Write your message here..." required></textarea>
                </div>

                <button type="button" class="btn btn-primary" style="width: 100%; justify-content: center; cursor: default;">Send Message</button>
            </form>
        </div>
    </div>
</section>


<?php
// Include the reusable footer component
include 'includes/footer.php';
?>
