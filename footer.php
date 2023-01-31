</main>
    <a href="<?php echo get_home_url(); ?>" class="logo">Base Window</a>
    <nav class="nav">
        <ul class="nav__list">
            <li class="nav__item"><button class="trigger trigger--exhibitions">What's on</button></li>
            <li class="nav__item"><button class="trigger trigger--info">Informations</button></li>
        </ul>
    </nav>

    <div class="newsletter newsletter--is-open">
        <div class="newsletter__label">Get notified about our events</div>
        <!-- <div class="newsletter__label">Keep up to date with the latest events</div> -->
        <div class="newsletter__form">
            <input type="text">
            <button>Submit</button>
        </div>
        <button class="close-newsletter">x</button>
    </div>

    <div class="window window--info">
        <button class="close-window">x</button>
        <div class="window__wrapper">
            <div>
                <?php echo get_field('about_base_window', 'options'); ?>
            </div>
        </div>
    </div>

    <?php get_template_part( 'template-parts/event-list'); ?>

    <?php wp_footer(); ?>

</body>

</html>