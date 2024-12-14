<?php

/*
Template Name:Learning
*/ ?>
<?php get_header(); ?>


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


<div class="container header-container text-center">
    <h3>Courses</h3>
    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Explicabo, eligendi?</p>
    <br>
</div>
<div class="courses container-section">
    <?php get_template_part('includes/section', 'courses'); ?>
</div>

<div class="container header-container text-center">
    <h3>Guides</h3>
    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Explicabo, eligendi?</p>
    <br>
</div>
<div class="guides container container-section">
    <?php get_template_part('includes/section', 'guides'); ?>
</div>

<div class="container header-container text-center">
    <h3>Resources</h3>
    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Explicabo, eligendi?</p>
    <br>
</div>
<div class="resources container container-section">
    <?php get_template_part('includes/section', 'resources'); ?>
</div>

<?php get_template_part('subscribe-to-our-newsletter'); ?>
<?php get_footer(); ?>