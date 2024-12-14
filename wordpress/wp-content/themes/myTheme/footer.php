<?php wp_footer(); ?>

<footer>

    <div class="container">
        <div class="footer-mobile">
            <div><img src="" alt=""></div>

            <div>
                <ul>
                    <li>Learn More</li>
                </ul>

                <?php
                wp_nav_menu(array('theme_location' => 'footer-menu', 'menu_class' => 'footer', 'container' => false));
                ?>


            </div>

            <div>
                <ul>
                    <li>Company</li>
                </ul>
                <ul>
                    <li><a href="">Tearms and Conditions</a></li>
                    <li><a href="">Privacy Policy</a></li>
                </ul>
            </div>

            <div>
                <ul>
                    <li>Constact Us:</li>
                </ul>
                <ul>
                    <li>Email:info@example.com</li>
                    <li>Phone:(123) 456-7890</li>
                    <li>Address: 123 Street Name</li>
                </ul>

            </div>

            <div>
                <ul>
                    <li>Social</li>
                </ul>
                <ul>
                    <li><a href="#"><i class="fa-brands fa-facebook-f first-fa"></i></a>
                        <a href="#"><i class="fa-brands fa-instagram"></i></a><a href="#"><i
                                class="fa-brands fa-youtube"></i></a><a href="#"><i
                                class="fa-brands fa-linkedin-in"></i></a>
                    </li>
                </ul>

            </div>
        </div>
    </div>
    <div class="copyright">
        <p>©2024, Learning Curve. All rights reserved.</p>
    </div>
</footer>

</body>

</html>