    <footer id="site-footer" role="contentinfo">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12 col-md-4">

                  <?php if( is_active_sidebar( 'footer_content_left' ) ) : ?>
                      <aside class="widgetized-page-before-content-widget-area">
                        <?php dynamic_sidebar( 'footer_content_left' ); ?>
                      </aside>
                  <?php endif; ?>

                </div>
                <div class="col-12 col-md-4">

                  <?php if( is_active_sidebar( 'footer_content' ) ) : ?>
                      <aside class="widgetized-page-before-content-widget-area">
                        <?php dynamic_sidebar( 'footer_content' ); ?>
                      </aside>
                  <?php endif; ?>

                </div>
                <div class="col-12 col-md-4">

                  <?php if( is_active_sidebar( 'footer_content_right' ) ) : ?>
                      <aside class="widgetized-page-before-content-widget-area">
                        <?php dynamic_sidebar( 'footer_content_right' ); ?>
                      </aside>
                  <?php endif; ?>

                </div>
            </div>
        </div>
    </footer>

    <?php wp_footer(); ?>

    </body>
</html>
