<?php get_header(); ?>
<div class=" container-section">
    <div class="guides-banner ">

        <div class="container">
            <div class="row">
                <div class="col-md-6 content">

                    <h2>EXPERT <br> GUIDANCE</h2>


                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nesciunt quia labore nihil, modi
                        ducimus minima.</p>
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nesciunt quia labore nihil, modi
                        ducimus minima.</p>
                </div>
                <div class="col-md-6 content">
                    <div class="guides-form">
                        <form action="#" method="POST">
                            <!-- First Name and Last Name -->
                            <div class="form-row row">
                                <div class="form-group col-md-6">
                                    <label for="first_name">First Name</label>
                                    <input type="text" id="first_name" name="first_name" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="last_name">Last Name</label>
                                    <input type="text" id="last_name" name="last_name" required>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" id="email" name="email" required>
                            </div>

                            <!-- Company Name -->
                            <div class="form-group">
                                <label for="company_name">Company Name</label>
                                <input type="text" id="company_name" name="company_name">
                            </div>

                            <!-- Subscribe Checkbox -->
                            <div class="form-group checkbox-group">

                                <input class="checkbox" type="checkbox" id="subscribe" name="subscribe">

                                <label for="subscribe">Subscribe to our newsletter</label>
                            </div>

                            <!-- Submit Button -->
                            <div class="form-group">
                                <button type="submit" class="red-submit-btn">Sign Up</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container container-section">

    <?php
    $featured_brands = get_post_meta(get_the_ID(), 'guide_featured_brands', true);
    $featured_brands = !empty($featured_brands) ? json_decode($featured_brands, true) : [];
    ?>

    <?php if (!empty($featured_brands)): ?>
        <div class="top-brands-section">
            <div class="header-container text-center">
                <h3>Featuring Experts From</h3>

            </div>
            <div class="top-brands-logos">
                <?php foreach ($featured_brands as $brand):
                    if (!empty($brand['image'])): ?>
                        <div class="brand-logo">
                            <img src="<?php echo esc_url($brand['image']); ?>" alt="Brand Logo" loading="lazy">
                        </div>
                    <?php endif;
                endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<div class="container container-section">
    <div class="header-container text-center">
        <h3>What Will You Learn</h3>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut, accusantium?</p>
        <br>
    </div>

    <?php
    // Retrieve the learning points meta field from the current guide post
    $learning_points = get_post_meta(get_the_ID(), '_guide_learning_points', true);
    $learning_points = !empty($learning_points) ? json_decode($learning_points, true) : [];
    ?>

    <?php if (!empty($learning_points)): ?>
        <div class="learning-points-section">
            <h2>What Will You Learn</h2>
            <div class="row">
                <?php
                // Define the background color classes in the desired order
                $bg_colors = array('bg-grey', 'bg-light-blue', 'bg-pink');

                foreach ($learning_points as $index => $point):
                    if (!empty($point['title']) && !empty($point['image'])):
                        // Determine the background color class based on the index
                        $bg_class = $bg_colors[$index % count($bg_colors)];
                        ?>
                        <div class="col-md-4 mb-4">
                            <div class="card learning-point-card <?php echo esc_attr($bg_class); ?>">
                                <div class="card-body ">
                                    <!-- Image Container -->
                                    <div class="learning-point-image mr-3">
                                        <img src="<?php echo esc_url($point['image']); ?>"
                                            alt="<?php echo esc_attr($point['title']); ?>" class="img-fluid"
                                            style="width: 50%; height: auto;">
                                        <br>
                                    </div>

                                    <!-- Text Container -->
                                    <div class="learning-point-content">
                                        <h3 class="card-title mb-2"><?php echo esc_html($point['title']); ?></h3>
                                        <p class="card-text"><?php echo esc_html($point['description']); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    endif;
                endforeach;
                ?>
            </div>
        </div>
    <?php else: ?>
        <p>No learning points available.</p>
    <?php endif; ?>

</div>

<div class="container container-section">
    <div class="header-container text-center">
        <h3>Learn From The Best</h3>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut, accusantium?</p>
        <br>
    </div>
    <?php
    // Retrieve the mentors meta field from the current guide post
    $mentors = get_post_meta(get_the_ID(), '_guide_mentors', true);
    $mentors = !empty($mentors) ? json_decode($mentors, true) : [];

    if (!empty($mentors)): ?>
        <div class="mentors-section">

            <div class="row">
                <?php foreach ($mentors as $mentor): ?>
                    <div class="col-md-4">
                        <div class="card" style="overflow:hidden">
                            <!-- Mentor Image -->
                            <?php if (!empty($mentor['image'])): ?>
                                <img src="<?php echo esc_url($mentor['image']); ?>" class="card-img-top"
                                    alt="<?php echo esc_attr($mentor['name']); ?>">
                            <?php endif; ?>

                            <div class="card-body">
                                <h3 class="card-title mb-3"><?php echo esc_html($mentor['name']); ?></h3>
                                <p class="card-text mb-3"><?php echo esc_html($mentor['title']); ?></p>
                                <div class="card-text mb-3"><?php echo esc_html($mentor['description']); ?></div>
                            </div>

                            <div class="row">
                                <div class="col-6"></div>
                                <div class="col-6">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/line-red.png" alt="line">
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php else: ?>
        <p>No mentors available.</p>
    <?php endif; ?>

</div>

<div class="guides-banner ">

    <div class="container">
        <div class="row">
            <div class="col-md-6 content">

                <h2>EXPERT <br> GUIDANCE</h2>


                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nesciunt quia labore nihil, modi
                    ducimus minima.</p>
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nesciunt quia labore nihil, modi
                    ducimus minima.</p>
            </div>
            <div class="col-md-6 content">
                <div class="guides-form">
                    <form action="#" method="POST">
                        <!-- First Name and Last Name -->
                        <div class="form-row row">
                            <div class="form-group col-md-6">
                                <label for="first_name">First Name</label>
                                <input type="text" id="first_name" name="first_name" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="last_name">Last Name</label>
                                <input type="text" id="last_name" name="last_name" required>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email" required>
                        </div>

                        <!-- Company Name -->
                        <div class="form-group">
                            <label for="company_name">Company Name</label>
                            <input type="text" id="company_name" name="company_name">
                        </div>

                        <!-- Subscribe Checkbox -->
                        <div class="form-group checkbox-group">

                            <input class="checkbox" type="checkbox" id="subscribe" name="subscribe">

                            <label for="subscribe">Subscribe to our newsletter</label>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group">
                            <button type="submit" class="red-submit-btn">Sign Up</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>