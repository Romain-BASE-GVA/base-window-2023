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
        <!-- Begin Mailchimp Signup Form -->
        <div id="mc_embed_signup">
            <form action="https://basedesign.us19.list-manage.com/subscribe/post?u=620f3999692622f666c30b23d&amp;id=dda62484d5&amp;f_id=00a7bfe4f0" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
                
                    <div class="mc-field-group newsletter__field-group">
                        <input type="email" value="" placeholder="Your Email" name="EMAIL" class="required email" id="mce-EMAIL" required>
                        <div style="position: absolute; left: -5000px;" aria-hidden="true" class="newsletter__no-input">
                            <input type="text" name="b_620f3999692622f666c30b23d_dda62484d5" tabindex="-1" value="">
                        </div>
                        <input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="btn">
                    </div>
                    <div id="mce-responses" class="clear">
                        <div class="response response--error" id="mce-error-response" style="display:none"></div>
                        <div class="response response--success" id="mce-success-response" style="display:none"></div>
                    </div>
                
            </form>
        </div>
        <script type='text/javascript' src='//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'></script>
        <script type='text/javascript'>
            (function($) {
                window.fnames = new Array();
                window.ftypes = new Array();
                fnames[0] = 'EMAIL';
                ftypes[0] = 'email';
            }(jQuery));
            var $mcj = jQuery.noConflict(true);
        </script>
        <!--End mc_embed_signup-->
    </div>
    <button class="close-newsletter"></button>
</div>

<div class="window-info">
    <button class="close-window"></button>
    <div class="window__wrapper">
        <span class="window-info__item window-info__item--address">Rue de Monthoux 12 <br>1201 Genève</span>
        <a href="mailto:info@basewindow.ch" class="window-info__item window-info__item--mail">info@basewindow.ch</a>
        <a href="https://www.instagram.com/base_window/" target="_blank" title="BaseWindow Instagram" class="window-info__item window-info__item--ig">Instagram</a>
        <a href="#" class="window-info__item window-info__item--nl" title="Get notified about our events">Newsletter</a>
        <div>
            <?php echo get_field('about_base_window', 'options'); ?>
        </div>
    </div>
</div>

<?php get_template_part('template-parts/event-list'); ?>

<div class="screen-bounds-exhibitions"></div>
<div class="screen-bounds-infos"></div>

<?php wp_footer(); ?>

</body>

</html>