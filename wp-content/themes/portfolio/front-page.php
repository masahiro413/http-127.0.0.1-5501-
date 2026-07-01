<?php
/**
 * フロントページテンプレート
 *
 * @package Portfolio
 */

get_header();
?>

<!-- ===== Hero Section ===== -->
<section class="hero-section" role="banner">
    <div class="hero-content">
        <p class="hero-eyebrow"><?php echo esc_html( get_theme_mod( 'portfolio_hero_eyebrow', 'Welcome to My Portfolio' ) ); ?></p>
        <h1 class="hero-title">
            <?php echo wp_kses_post( get_theme_mod( 'portfolio_hero_title', bloginfo( 'name' ) ) ); ?>
        </h1>
        <p class="hero-description">
            <?php echo wp_kses_post( get_theme_mod( 'portfolio_hero_description', get_bloginfo( 'description' ) ) ); ?>
        </p>
        <div class="hero-actions">
            <a href="<?php echo esc_url( get_post_type_archive_link( 'portfolio' ) ); ?>" class="btn btn-primary">
                <?php esc_html_e( '作品を見る', 'portfolio' ); ?>
            </a>
            <a href="#contact" class="btn btn-outline">
                <?php esc_html_e( 'お問い合わせ', 'portfolio' ); ?>
            </a>
        </div>
    </div>
</section>

<!-- ===== Stats Section ===== -->
<section class="section section-alt" aria-label="<?php esc_attr_e( '実績数', 'portfolio' ); ?>">
    <div class="container">
        <div class="stats-grid">
            <?php
            $portfolio_count = wp_count_posts( 'portfolio' )->publish;
            $stats = array(
                array(
                    'number' => $portfolio_count ?: get_theme_mod( 'portfolio_stat_projects', '20' ),
                    'label'  => __( '制作実績', 'portfolio' ),
                ),
                array(
                    'number' => get_theme_mod( 'portfolio_stat_clients', '15' ),
                    'label'  => __( 'クライアント', 'portfolio' ),
                ),
                array(
                    'number' => get_theme_mod( 'portfolio_stat_experience', '5' ),
                    'label'  => __( '経験年数', 'portfolio' ),
                ),
                array(
                    'number' => get_theme_mod( 'portfolio_stat_skills', '10' ),
                    'label'  => __( '使用技術', 'portfolio' ),
                ),
            );
            foreach ( $stats as $stat ) :
            ?>
            <div class="stat-item">
                <div class="stat-number"><?php echo esc_html( $stat['number'] ); ?>+</div>
                <div class="stat-label"><?php echo esc_html( $stat['label'] ); ?></div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ===== Portfolio Section ===== -->
<section class="section" id="works" aria-label="<?php esc_attr_e( 'ポートフォリオ', 'portfolio' ); ?>">
    <div class="container">
        <header class="section-header">
            <span class="section-eyebrow"><?php esc_html_e( 'WORKS', 'portfolio' ); ?></span>
            <h2 class="section-title"><?php esc_html_e( '制作実績', 'portfolio' ); ?></h2>
            <p class="section-desc"><?php esc_html_e( 'これまでに手がけた作品の一部をご紹介します。', 'portfolio' ); ?></p>
        </header>

        <?php
        // Portfolio category filter buttons
        $categories = get_terms( array(
            'taxonomy'   => 'portfolio_category',
            'hide_empty' => true,
        ) );
        if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) :
        ?>
        <div class="portfolio-filter" role="group" aria-label="<?php esc_attr_e( 'カテゴリーフィルター', 'portfolio' ); ?>">
            <button class="filter-btn active" data-filter="all">
                <?php esc_html_e( 'すべて', 'portfolio' ); ?>
            </button>
            <?php foreach ( $categories as $cat ) : ?>
            <button class="filter-btn" data-filter="<?php echo esc_attr( $cat->slug ); ?>">
                <?php echo esc_html( $cat->name ); ?>
            </button>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <?php
        $portfolio_query = portfolio_get_posts( 6 );
        if ( $portfolio_query->have_posts() ) :
        ?>
        <div class="portfolio-grid" id="portfolio-grid">
            <?php while ( $portfolio_query->have_posts() ) : $portfolio_query->the_post(); ?>
                <?php get_template_part( 'template-parts/portfolio', 'card' ); ?>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>

        <div style="text-align:center; margin-top:48px;">
            <a href="<?php echo esc_url( get_post_type_archive_link( 'portfolio' ) ); ?>" class="btn btn-primary">
                <?php esc_html_e( 'すべての作品を見る', 'portfolio' ); ?>
            </a>
        </div>

        <?php else : ?>
        <p style="text-align:center; color: var(--color-text-muted);">
            <?php esc_html_e( 'まだポートフォリオが登録されていません。', 'portfolio' ); ?>
        </p>
        <?php endif; ?>
    </div>
</section>

<!-- ===== About Section ===== -->
<section class="section section-alt" id="about" aria-label="<?php esc_attr_e( '自己紹介', 'portfolio' ); ?>">
    <div class="container">
        <div class="about-grid">
            <div class="about-image">
                <?php
                $about_image = get_theme_mod( 'portfolio_about_image', '' );
                if ( $about_image ) :
                ?>
                    <img src="<?php echo esc_url( $about_image ); ?>"
                         alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
                <?php else : ?>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/about-placeholder.jpg' ); ?>"
                         alt="<?php esc_attr_e( 'プロフィール写真', 'portfolio' ); ?>">
                <?php endif; ?>
            </div>
            <div class="about-content">
                <span class="section-eyebrow"><?php esc_html_e( 'ABOUT', 'portfolio' ); ?></span>
                <h2 class="section-title">
                    <?php echo esc_html( get_theme_mod( 'portfolio_about_title', __( '自己紹介', 'portfolio' ) ) ); ?>
                </h2>
                <p>
                    <?php echo wp_kses_post( get_theme_mod( 'portfolio_about_text',
                        __( 'Webデザイン・開発を中心にフリーランスとして活動しています。UX/UIデザインからフロントエンド・バックエンド開発まで幅広く対応いたします。', 'portfolio' )
                    ) ); ?>
                </p>
                <?php
                $skills_str = get_theme_mod( 'portfolio_skills', 'HTML/CSS,JavaScript,PHP,WordPress,React,Figma' );
                $skills = array_filter( array_map( 'trim', explode( ',', $skills_str ) ) );
                if ( ! empty( $skills ) ) :
                ?>
                <ul class="skills-list" aria-label="<?php esc_attr_e( 'スキル一覧', 'portfolio' ); ?>">
                    <?php foreach ( $skills as $skill ) : ?>
                    <li><span class="skill-tag"><?php echo esc_html( $skill ); ?></span></li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- ===== Contact Section ===== -->
<section class="section" id="contact" aria-label="<?php esc_attr_e( 'お問い合わせ', 'portfolio' ); ?>">
    <div class="container">
        <header class="section-header">
            <span class="section-eyebrow"><?php esc_html_e( 'CONTACT', 'portfolio' ); ?></span>
            <h2 class="section-title"><?php esc_html_e( 'お問い合わせ', 'portfolio' ); ?></h2>
            <p class="section-desc">
                <?php esc_html_e( 'お仕事のご依頼・ご相談はこちらからお気軽にどうぞ。', 'portfolio' ); ?>
            </p>
        </header>

        <div class="contact-form-wrapper">
            <?php
            // Use Contact Form 7 shortcode if available, otherwise show a basic form
            if ( shortcode_exists( 'contact-form-7' ) ) {
                $cf7_id = get_theme_mod( 'portfolio_cf7_id', '' );
                if ( $cf7_id ) {
                    echo do_shortcode( '[contact-form-7 id="' . absint( $cf7_id ) . '"]' );
                } else {
                    echo '<p>' . esc_html__( 'Contact Form 7フォームのIDをカスタマイザーで設定してください。', 'portfolio' ) . '</p>';
                }
            } else {
                ?>
                <form class="portfolio-contact-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" novalidate>
                    <?php wp_nonce_field( 'portfolio_contact_form', 'portfolio_contact_nonce' ); ?>
                    <input type="hidden" name="action" value="portfolio_contact">

                    <div class="form-group">
                        <label for="contact-name">
                            <?php esc_html_e( 'お名前', 'portfolio' ); ?>
                            <span class="required" aria-label="<?php esc_attr_e( '必須', 'portfolio' ); ?>">*</span>
                        </label>
                        <input type="text" id="contact-name" name="contact_name"
                               required autocomplete="name"
                               placeholder="<?php esc_attr_e( '山田 太郎', 'portfolio' ); ?>">
                    </div>

                    <div class="form-group">
                        <label for="contact-email">
                            <?php esc_html_e( 'メールアドレス', 'portfolio' ); ?>
                            <span class="required" aria-label="<?php esc_attr_e( '必須', 'portfolio' ); ?>">*</span>
                        </label>
                        <input type="email" id="contact-email" name="contact_email"
                               required autocomplete="email"
                               placeholder="<?php esc_attr_e( 'example@email.com', 'portfolio' ); ?>">
                    </div>

                    <div class="form-group">
                        <label for="contact-subject">
                            <?php esc_html_e( '件名', 'portfolio' ); ?>
                        </label>
                        <input type="text" id="contact-subject" name="contact_subject"
                               placeholder="<?php esc_attr_e( 'お問い合わせ件名', 'portfolio' ); ?>">
                    </div>

                    <div class="form-group">
                        <label for="contact-message">
                            <?php esc_html_e( 'メッセージ', 'portfolio' ); ?>
                            <span class="required" aria-label="<?php esc_attr_e( '必須', 'portfolio' ); ?>">*</span>
                        </label>
                        <textarea id="contact-message" name="contact_message" required
                                  placeholder="<?php esc_attr_e( 'お問い合わせ内容をご記入ください。', 'portfolio' ); ?>"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width:100%">
                        <?php esc_html_e( '送信する', 'portfolio' ); ?>
                    </button>
                </form>
                <?php
            }
            ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>
