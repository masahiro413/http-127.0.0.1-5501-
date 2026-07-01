    </main>

    <footer class="site-footer" role="contentinfo">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <p class="site-title">
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                            <?php bloginfo( 'name' ); ?>
                        </a>
                    </p>
                    <p class="footer-description">
                        <?php bloginfo( 'description' ); ?>
                    </p>
                    <div class="social-links" aria-label="<?php esc_attr_e( 'ソーシャルリンク', 'portfolio' ); ?>">
                        <?php
                        $github = get_theme_mod( 'portfolio_social_github', '' );
                        $twitter = get_theme_mod( 'portfolio_social_twitter', '' );
                        $linkedin = get_theme_mod( 'portfolio_social_linkedin', '' );

                        if ( $github ) :
                        ?>
                            <a href="<?php echo esc_url( $github ); ?>" class="social-link" target="_blank" rel="noopener noreferrer" aria-label="GitHub">
                                GH
                            </a>
                        <?php endif; ?>
                        <?php if ( $twitter ) : ?>
                            <a href="<?php echo esc_url( $twitter ); ?>" class="social-link" target="_blank" rel="noopener noreferrer" aria-label="Twitter/X">
                                TW
                            </a>
                        <?php endif; ?>
                        <?php if ( $linkedin ) : ?>
                            <a href="<?php echo esc_url( $linkedin ); ?>" class="social-link" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn">
                                LI
                            </a>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="footer-widget">
                    <h4><?php esc_html_e( 'ナビゲーション', 'portfolio' ); ?></h4>
                    <?php
                    wp_nav_menu( array(
                        'theme_location' => 'footer',
                        'menu_class'     => 'footer-nav',
                        'container'      => false,
                        'depth'          => 1,
                        'fallback_cb'    => false,
                    ) );
                    ?>
                </div>

                <div class="footer-widget">
                    <h4><?php esc_html_e( 'カテゴリー', 'portfolio' ); ?></h4>
                    <ul class="footer-nav">
                        <?php
                        $categories = get_terms( array(
                            'taxonomy' => 'portfolio_category',
                            'hide_empty' => true,
                            'number'     => 6,
                        ) );
                        if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) :
                            foreach ( $categories as $cat ) :
                        ?>
                            <li>
                                <a href="<?php echo esc_url( get_term_link( $cat ) ); ?>">
                                    <?php echo esc_html( $cat->name ); ?>
                                </a>
                            </li>
                        <?php
                            endforeach;
                        endif;
                        ?>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <p>
                    &copy; <?php echo esc_html( gmdate( 'Y' ) ); ?>
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <?php bloginfo( 'name' ); ?>
                    </a>
                    <?php esc_html_e( 'All Rights Reserved.', 'portfolio' ); ?>
                </p>
                <p>
                    <?php
                    printf(
                        /* translators: %s: WordPress link */
                        esc_html__( 'Powered by %s', 'portfolio' ),
                        '<a href="https://wordpress.org" target="_blank" rel="noopener noreferrer">WordPress</a>'
                    );
                    ?>
                </p>
            </div>
        </div>
    </footer>
</div>

<button class="scroll-to-top" id="scrollToTop" aria-label="<?php esc_attr_e( 'ページトップへ', 'portfolio' ); ?>">
    &#8679;
</button>

<?php wp_footer(); ?>
</body>
</html>
