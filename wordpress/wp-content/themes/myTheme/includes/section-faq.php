<?php

$args = array(
    'post_type' => 'faq',
    'posts_per_page' => -1,
);

$faqs_query = new WP_Query($args);

if ($faqs_query->have_posts()): ?>


    <div class="section6 container container-section">
        <div class="header-container">
            <h3 class="text-center">Frequently Asked Questions</h3>
            <br>
        </div>

        <div class="accordion accordion-flush" id="accordionExample">
            <?php $faq_count = 0;
            while ($faqs_query->have_posts()):
                $faqs_query->the_post();
                $faq_count++; ?>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button <?php echo $faq_count === 1 ? '' : 'collapsed'; ?>" type="button"
                            data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $faq_count; ?>"
                            aria-expanded="<?php echo $faq_count === 1 ? 'true' : 'false'; ?>"
                            aria-controls="collapse<?php echo $faq_count; ?>">
                            <?php the_title(); ?>
                        </button>
                    </h2>
                    <div id="collapse<?php echo $faq_count; ?>"
                        class="accordion-collapse collapse <?php echo $faq_count === 1 ? 'show' : ''; ?>"
                        data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <?php the_content(); ?>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
    <?php wp_reset_postdata();
else: ?>
    <p><?php esc_html_e('No FAQs found.', 'textdomain'); ?></p>
<?php endif;

