<?php

/*
Template Name:Home
*/ ?>

<?php get_header(); ?>


<div class="section1">
    <div class="container ">
        <div class="row">
            <div class="col-6">
                <h1>Lorem ipsum dolor sit amet consectetur adipisicing.</h1>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Distinctio architecto corrupti quas aliquid
                    dolore accusamus, voluptas inventore voluptatibus incidunt ad.</p>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Iste ratione, consequuntur modi ullam
                    exercitationem temporibus accusantium accusamus quisquam quibusdam saepe?</p>
            </div>
        </div>
    </div>
</div>

<div class="section2 text-center">
    <div class="container">
        <h2>Resources</h2>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing.</p>
        <br>
        <div class="row ">
            <div class="col-4">
                <div class="card text-center" style="width: 23rem;">
                    <div class="card-body">
                        <h5 class="card-title">Special title treatment</h5>
                        <div>
                            <img src="https://picsum.photos/200" class="img-fluid" alt="...">
                        </div>

                        <a href="#" class="btn btn-primary btn100width">Go somewhere</a>

                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card text-center" style="width: 23rem;">
                    <div class="card-body">
                        <h5 class="card-title">Special title treatment</h5>
                        <div>
                            <img src="https://picsum.photos/200" class="img-fluid" alt="...">
                        </div>

                        <a href="#" class="btn btn-primary btn100width">Go somewhere</a>

                    </div>
                </div>
            </div>

            <div class="col-4">
                <div class="card text-center" style="width: 23rem;">
                    <div class="card-body">
                        <h5 class="card-title">Special title treatment</h5>
                        <div>
                            <img src="https://picsum.photos/200" class="img-fluid" alt="...">
                        </div>

                        <a href="#" class="btn btn-primary btn100width">Go somewhere</a>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="section3 text-center">
    <div class="container">
        <h2>Achivements</h2>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing.</p>
        <br>
        <div class="row ">
            <div class="col-4">
                <div class="card text-center" style="width: 23rem;">
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
            <div class="col-4">
                <div class="card text-center" style="width: 23rem;">
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

            <div class="col-4">
                <div class="card text-center" style="width: 23rem;">
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

<div class="section4 text-center">
    <div class="container">
        <h2>Featured Courses</h2>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing.</p>
        <br>
        <div class="row ">
            <div class="col-4">
                <div class="card text-center" style="width: 23rem;">
                    <div class="card-body">
                        <h5 class="card-title">Special title treatment</h5>
                        <div>
                            <img src="https://picsum.photos/200" class="img-fluid" alt="...">
                        </div>

                        <a href="#" class="btn btn-primary btn100width">Go somewhere</a>

                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card text-center" style="width: 23rem;">
                    <div class="card-body">
                        <h5 class="card-title">Special title treatment</h5>
                        <div>
                            <img src="https://picsum.photos/200" class="img-fluid" alt="...">
                        </div>

                        <a href="#" class="btn btn-primary btn100width">Go somewhere</a>

                    </div>
                </div>
            </div>

            <div class="col-4">
                <div class="card text-center" style="width: 23rem;">
                    <div class="card-body">
                        <h5 class="card-title">Special title treatment</h5>
                        <div>
                            <img src="https://picsum.photos/200" class="img-fluid" alt="...">
                        </div>

                        <a href="#" class="btn btn-primary btn100width">Go somewhere</a>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<div class="container section5 text-center">

    <h2>Latest Blog Posts</h2>

    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Similique id hic asperiores neque molestias eius.</p>
    <br>
    <div><?php get_template_part('includes/section', 'content'); ?></div>



</div>

<?php get_footer(); ?>