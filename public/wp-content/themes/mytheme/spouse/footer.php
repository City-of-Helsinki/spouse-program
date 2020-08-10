    <footer id="site-footer">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12 col-md-4">

                  <?php if( is_active_sidebar( 'footer_content_left' ) ) : ?>
                      <div class="widgetized-page-before-content-widget-area">
                        <?php dynamic_sidebar( 'footer_content_left' ); ?>
                      </div>
                  <?php endif; ?>

                </div>
                <div class="col-12 col-md-4">

                  <?php if( is_active_sidebar( 'footer_content' ) ) : ?>
                      <div class="widgetized-page-before-content-widget-area">
                        <?php dynamic_sidebar( 'footer_content' ); ?>
                      </div>
                  <?php endif; ?>

                </div>
                <div class="col-12 col-md-4">

                  <?php if( is_active_sidebar( 'footer_content_right' ) ) : ?>
                      <div class="widgetized-page-before-content-widget-area">
                        <?php dynamic_sidebar( 'footer_content_right' ); ?>
                      </div>
                  <?php endif; ?>

                </div>
            </div>
        </div>
    </footer>

    <?php wp_footer(); ?>

    </body>
</html>
