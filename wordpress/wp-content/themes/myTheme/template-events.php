<?php

/*
Template Name:Events
*/ ?>
<?php get_header(); ?>

<div class="container-section container">
    <div class="about-banner events-main-banner ">

        <div class="row">
            <div class="col-md-6 content">
                <h2>Lorem ipsum dolor sit amet consectetur.</h2>
                <p class="mobile-none">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Aperiam laudantium
                    quasi optio officiis
                    explicabo
                    doloremque? Dicta aliquid vitae nostrum voluptatem, explicabo perspiciatis facilis quos cumque!
                </p>
                <button>Become a Member</button>
            </div>

        </div>
    </div>
</div>

<div class="container header-container text-center">
    <h3>Upcoming Events</h3>
    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Explicabo, eligendi?</p>
    <br>
</div>
<div class="events container container-section">
    <?php get_template_part('includes/section', 'events'); ?>
</div>
<div class="container header-container text-center">
    <h3>Co-horts</h3>
    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Explicabo, eligendi?</p>
    <br>
</div>
<div class="cohorts container container-section">
    <?php get_template_part('includes/section', 'cohorts'); ?>
</div>
<div class="container header-container text-center">
    <h3>Conference</h3>
    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Explicabo, eligendi?</p>
    <br>
</div>
<div class="container-section">
    <?php get_template_part('includes/section', 'confrence'); ?>
</div>

<?php get_template_part('subscribe-to-our-newsletter'); ?>
<?php get_footer(); ?>