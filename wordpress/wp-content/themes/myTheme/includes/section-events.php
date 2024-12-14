<div class="section-events">
    <div class="row mb-4">
        <?php
        $events_query = new WP_Query(array(
            'post_type' => 'events',
            'posts_per_page' => 6,
        ));

        if ($events_query->have_posts()):
            $post_counter = 0;
            while ($events_query->have_posts()):
                $events_query->the_post();

                // Get custom fields (Date, Time, Place)
                $event_date = get_post_meta(get_the_ID(), '_event_date', true);
                $event_time = get_post_meta(get_the_ID(), '_event_time', true);
                $event_place = get_post_meta(get_the_ID(), '_event_place', true);

                // Format the date to separate day and month
                if ($event_date) {
                    $date_object = DateTime::createFromFormat('Y-m-d', $event_date);
                    $day = $date_object->format('d');
                    $month = $date_object->format('F');
                }

                // Assign alternating color classes
                $color_class = ($post_counter % 3 == 0) ? 'card-dark-blue' : (($post_counter % 3 == 1) ? 'card-pink' : 'card-blue');

                if ($post_counter % 3 == 0 && $post_counter != 0) {
                    echo '</div><div class="row mb-4">';
                }
                ?>
                <div class="col-md-4">
                    <div class="card event-card <?php echo $color_class; ?>">
                        <div class="card-body">
                            <div class="datecontainer mb-3">
                                <p>
                                    <span class="event-day  fw-bold"><?php echo esc_html($day); ?></span>
                                    <span class="event-month  fw-bold d-block"><?php echo esc_html($month); ?></span>
                                </p>
                            </div>
                            <p class="card-title fs-4 text mb-1"><?php the_title(); ?>
                            <p>
                            <p class="event-time"><?php echo esc_html($event_time); ?></p>
                            <p class="event-place"><?php echo esc_html($event_place); ?></p>
                            <br>
                            <a href="<?php the_permalink(); ?>" class="classic-link" style="color:white">Learn More</a>
                        </div>
                    </div>
                </div>
                <?php
                $post_counter++;
            endwhile;
            wp_reset_postdata();
        else:
            echo '<p>No events found.</p>';
        endif;
        ?>
    </div>
</div>