<?php get_header(); ?>


<div class="container-section container">
    <div class="about-banner ">

        <div class="row">
            <div class="col-md-5 content">
                <h2>About US</h2>
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Aperiam laudantium quasi optio officiis
                    explicabo
                    doloremque? Dicta aliquid vitae nostrum voluptatem, explicabo perspiciatis facilis quos cumque!
                </p>
                <button>Learn More</button>
            </div>

        </div>
    </div>
</div>
<div class="section3 text-center container-section">
    <div class="container">

        <div class="row ">
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">

                        <div>

                            <img src="<?php echo get_template_directory_uri(); ?>/Images/card1.png " class=" img-fluid"
                                alt="...">
                        </div>
                        <h5 class="card-title">Mission</h5>
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
                        <h5 class="card-title">Vision</h5>
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
                        <h5 class="card-title">Goals</h5>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Provident, reprehenderit.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="container-section">
    <div class="header-container text-center">
        <h3>Meet the team</h3>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut, accusantium?</p>
        <br>
    </div>


    <?php get_template_part('includes/section', 'about'); ?>


    <div class="container text-center">
        <?php if (get_previous_posts_link()): ?>
            <button class="btn btn-primary"><?php previous_posts_link(); ?></button>
        <?php endif; ?>

        <?php if (get_next_posts_link()): ?>
            <button class="btn btn-primary"><?php next_posts_link(); ?></button>
        <?php endif; ?>
    </div>
</div>


<div class="section3 text-center container-section">
    <div class="container">
        <div class="header-container">

            <h2>Advocacy</h2>
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

<div class="container header-container text-center">
    <h3>Our Comunity</h3>
    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Explicabo, eligendi?</p>
    <br>
</div>

<div class="container-section">
    <div class="comunity-banner ">

        <div class="container">
            <div class="row">
                <div class="col-md-4 content">
                    <h3>Develop your skills in a new unique way</h3>
                    <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Aperiam laudantium quasi optio officiis
                        explicabo
                        doloremque? Dicta aliquid vitae nostrum voluptatem, explicabo perspiciatis facilis quos cumque!
                    </p>
                    <button>Joun Our Comunity</button>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="container-section">
    <div class="container header-container text-center">
        <h3>Testimonials</h3>
        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Explicabo, eligendi?</p>
        <br>
    </div>
    <?php get_template_part('includes/section', 'testimonials'); ?>

</div>
<?php get_template_part('subscribe-to-our-newsletter'); ?>
<?php get_footer(); ?>