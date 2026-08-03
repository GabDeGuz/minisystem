<?php
// Get the current page filename to dynamically set active classes
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>De Guzman Resort | Luxury Tropical Getaway</title>
    <meta name="description" content="Experience the ultimate luxury tropical getaway at De Guzman Resort. Enjoy pristine swimming pools, deluxe suites, wellness spas, and exquisite dining.">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">
    
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <!-- Main Navigation Header -->
    <header class="main-header">
        <div class="container header-container">
            <a href="index.php" class="logo">
                <span class="logo-accent">DE GUZMAN</span> RESORT
            </a>
            
            <!-- Desktop Nav -->
            <nav class="desktop-nav">
                <ul class="nav-menu">
                    <li><a href="index.php" class="nav-link <?php echo ($current_page == 'index.php' || $current_page == '') ? 'active' : ''; ?>">Home</a></li>
                    <li><a href="about.php" class="nav-link <?php echo ($current_page == 'about.php') ? 'active' : ''; ?>">About</a></li>
                    <li><a href="rooms.php" class="nav-link <?php echo ($current_page == 'rooms.php') ? 'active' : ''; ?>">Rooms</a></li>
                    <li><a href="contact.php" class="nav-link <?php echo ($current_page == 'contact.php') ? 'active' : ''; ?>">Contact</a></li>
                </ul>
            </nav>

            <div class="nav-actions">
                <a href="#book-form" class="btn btn-primary btn-book-now">Book Now</a>
            </div>
        </div>
    </header>
