</main>
    <a href="<?php echo get_home_url(); ?>" class="logo">Base Window</a>
    <nav class="nav">
        <ul class="nav__list">
            <li class="nav__item"><button class="trigger trigger--exhibitions">Index</button></li>
            <li class="nav__item"><button class="trigger trigger--info">The Gallery</button></li>
        </ul>
    </nav>

    <div class="newsletter">
        <div class="newsletter__label">Get notified about our events</div>
        <!-- <div class="newsletter__label">Keep up to date with the latest events</div> -->
        <div class="newsletter__form">
            <input type="text">
            <button>Submit</button>
        </div>
        <button class="close-newsletter"></button>
    </div>

    <div class="window-info">
        <button class="close-window"></button>
        <div class="window__wrapper">
            <div>
                <?php echo get_field('about_base_window', 'options'); ?>
            </div>
        </div>
    </div>

    <?php get_template_part( 'template-parts/event-list'); ?>

    <div class="screen-bounds-exhibitions"></div>

    <?php wp_footer(); ?>

</body>

</html>