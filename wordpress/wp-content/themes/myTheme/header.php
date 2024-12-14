<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://kit.fontawesome.com/00a523a723.js" crossorigin="anonymous"></script>

    <?php wp_head(); ?>
</head>

<body>
    <!-- Desktop Header -->
    <header class="d-none d-lg-block">
        <div class="container d-flex justify-content-between py-3">
            <div>
                <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                <a href="#"><i class="fa-brands fa-facebook"></i></a>
                <a href="#"><i class="fa-brands fa-youtube"></i></a>
                <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
            </div>

            <div>
                <img src="<?php echo get_template_directory_uri(); ?>/Images/logo.png" alt="logo">
            </div>

            <div>
                <?php if (is_user_logged_in()): ?>
                    <a href="<?php echo wp_logout_url(home_url()); ?>">
                        <button class="button">Logout</button>
                    </a>
                <?php else: ?>
                    <a href="<?php echo home_url('/my-account'); ?>">
                        <button class="button">Member Login</button>
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <div class="container">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'nav-bar',
                'menu_class' => 'nav',
            ));
            ?>
        </div>
    </header>

    <!-- Mobile Header -->
    <header class="d-lg-none">
        <div class="container d-flex justify-content-between align-items-center py-3">
            <div>
                <img src="<?php echo get_template_directory_uri(); ?>/Images/logo.png" alt="logo">
            </div>
            <div>
                <button id="burger-icon" class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#mobileMenu" aria-controls="mobileMenu" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"><i class="fa-solid fa-bars"></i></span>
                </button>
            </div>
        </div>

        <div class="collapse" id="mobileMenu">
            <div class="container">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'nav-bar',
                    'menu_class' => 'mobile-nav-items navbar-nav',
                ));
                ?>
            </div>
        </div>
    </header>