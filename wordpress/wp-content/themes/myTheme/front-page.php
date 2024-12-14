<?php get_header(); ?>

<div class="container-section">
    <div class="section1 ">
        <div class="container ">
            <div class="row">
                <div class="col-md-6">
                    <h1>Lorem ipsum dolor sit amet consectetur adipisicing.</h1>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Distinctio architecto corrupti quas
                        aliquid
                        dolore accusamus, voluptas inventore voluptatibus incidunt ad.</p>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Iste ratione, consequuntur modi ullam
                        exercitationem temporibus accusantium accusamus quisquam quibusdam saepe?</p>
                    <br>
                    <button class="blue-btn">Learn More</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="section2 container-section">
    <div class="container ">
        <div class="text-center header-container">
            <h2>Resources</h2>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing.</p>
            <br>
        </div>
        <?php get_template_part('includes/section', 'resources'); ?>
    </div>
</div>

<div class="section3 text-center container-section">
    <div class="container">
        <div class="header-container">
            <h2>Achivements</h2>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing.</p>
            <br>
        </div>
        <div class="row ">
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">

                        <div>

                            <img src="<?php echo get_template_directory_uri(); ?>/Images/card1.png " class=" img-fluid"
                                alt="...">
                        </div>
                        <h5 class="card-title">60%</h5>
                        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Accusamus, exercitationem.</p>



                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">

                        <div>
                            <img src="<?php echo get_template_directory_uri(); ?>/Images/card2.png " class="img-fluid"
                                alt="...">
                        </div>
                        <h5 class="card-title">135</h5>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat, tempora?</p>



                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">

                        <div>
                            <img src="<?php echo get_template_directory_uri(); ?>/Images/card3.png " class="img-fluid"
                                alt="...">
                        </div>
                        <h5 class="card-title">2x</h5>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Provident, reprehenderit.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="section4 container-section ">
    <div class="container">
        <div class="text-center header-container">
            <h2>Featured Courses</h2>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing.</p>
            <br>
        </div>
        <div class="courses ">
            <?php get_template_part('includes/section', 'courses'); ?>
        </div>
    </div>
</div>


<div class="container section5  container-section">
    <div class="header-container text-center">

        <h2>Latest Blog Posts</h2>

        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Similique id hic asperiores neque molestias eius.
        </p>
        <br>
    </div>
    <div><?php get_template_part('includes/section', 'content'); ?></div>



</div>
<div><?php get_template_part('includes/section', 'faq'); ?></div>


<?php get_template_part('subscribe-to-our-newsletter'); ?>
<?php get_footer(); ?>