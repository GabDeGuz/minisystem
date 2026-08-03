    <!-- Footer Section -->
    <footer class="main-footer">
        <div class="container footer-grid">
            <!-- Column 1: About -->
            <div class="footer-col footer-about">
                <a href="index.php" class="footer-logo">
                    <span class="logo-accent">DE GUZMAN</span> RESORT
                </a>
                <p class="footer-desc">
                    Nestled in the heart of Pulilan, Bulacan, De Guzman Resort offers a private sanctuary designed for relaxation, rejuvenation, and unforgettable experiences.
                </p>
                <div class="footer-social">
                    <a href="#" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" aria-label="Twitter"><i class="fa-brands fa-twitter"></i></a>
                    <a href="#" aria-label="YouTube"><i class="fa-brands fa-youtube"></i></a>
                </div>
            </div>

            <!-- Column 2: Quick Links -->
            <div class="footer-col">
                <h3 class="footer-title">Quick Links</h3>
                <ul class="footer-links">
                    <li><a href="index.php"><i class="fa-solid fa-chevron-right"></i> Home</a></li>
                    <li><a href="about.php"><i class="fa-solid fa-chevron-right"></i> About Us</a></li>
                    <li><a href="rooms.php"><i class="fa-solid fa-chevron-right"></i> Rooms & Suites</a></li>
                    <li><a href="contact.php"><i class="fa-solid fa-chevron-right"></i> Contact Us</a></li>
                </ul>
            </div>

            <!-- Column 3: Contact Info -->
            <div class="footer-col">
                <h3 class="footer-title">Contact Info</h3>
                <ul class="footer-contact">
                    <li>
                        <i class="fa-solid fa-location-dot"></i>
                        <span>Pulilan, Bulacan, Philippines</span>
                    </li>
                    <li>
                        <i class="fa-solid fa-phone"></i>
                        <span>+63 912 345 6789<br>+63 998 765 4321</span>
                    </li>
                    <li>
                        <i class="fa-solid fa-envelope"></i>
                        <span>info@deguzmanresort.com<br>booking@deguzmanresort.com</span>
                    </li>
                </ul>
            </div>

            <!-- Column 4: Newsletter -->
            <div class="footer-col">
                <h3 class="footer-title">Newsletter</h3>
                <p class="footer-desc">Subscribe to receive exclusive offers, updates, and tropical travel inspiration.</p>
                <form class="newsletter-form" id="newsletter-form" onsubmit="event.preventDefault(); alert('Thank you for subscribing!'); this.reset();">
                    <div class="input-group">
                        <input type="email" placeholder="Your Email Address" required class="form-control">
                        <button type="submit" class="btn btn-primary btn-subscribe" aria-label="Subscribe">
                            <i class="fa-solid fa-paper-plane"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Copyright Bar -->
        <div class="copyright-bar">
            <div class="container copyright-content">
                <p>&copy; <?php echo date('Y'); ?> De Guzman Resort. All rights reserved.</p>
                <div class="footer-legal">
                    <a href="#">Privacy Policy</a>
                    <a href="#">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
