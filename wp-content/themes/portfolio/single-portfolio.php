<?php
/**
 * ポートフォリオ詳細テンプレート
 *
 * @package Portfolio
 */

get_header();

while ( have_posts() ) :
    the_post();

    $post_id      = get_the_ID();
    $client       = get_post_meta( $post_id, '_portfolio_client', true );
    $project_url  = get_post_meta( $post_id, '_portfolio_url', true );
    $project_date = get_post_meta( $post_id, '_portfolio_date', true );
    $project_role = get_post_meta( $post_id, '_portfolio_role', true );
    $categories   = portfolio_get_categories( $post_id );
    $skills       = portfolio_get_skills( $post_id );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <!-- Hero -->
    <section class="single-portfolio-hero">
        <div class="container">
            <nav class="portfolio-breadcrumb" aria-label="<?php esc_attr_e( 'パンくずリスト', 'portfolio' ); ?>">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'ホーム', 'portfolio' ); ?></a>
                &rsaquo;
                <a href="<?php echo esc_url( get_post_type_archive_link( 'portfolio' ) ); ?>">
                    <?php esc_html_e( 'ポートフォリオ', 'portfolio' ); ?>
                </a>
                &rsaquo;
                <?php the_title(); ?>
            </nav>

            <?php if ( $categories && ! is_wp_error( $categories ) ) : ?>
            <p class="hero-eyebrow"><?php echo esc_html( $categories[0]->name ); ?></p>
            <?php endif; ?>

            <h1 class="single-portfolio-title"><?php the_title(); ?></h1>

            <div class="single-portfolio-meta">
                <?php if ( $client ) : ?>
                <span>
                    <span aria-hidden="true">&#128188;</span>
                    <?php echo esc_html( $client ); ?>
                </span>
                <?php endif; ?>
                <?php if ( $project_date ) : ?>
                <span>
                    <span aria-hidden="true">&#128197;</span>
                    <?php echo esc_html( $project_date ); ?>
                </span>
                <?php endif; ?>
                <?php if ( $project_role ) : ?>
                <span>
                    <span aria-hidden="true">&#128736;</span>
                    <?php echo esc_html( $project_role ); ?>
                </span>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Content -->
    <div class="single-portfolio-content">
        <div class="container">
            <?php if ( has_post_thumbnail() ) : ?>
            <div class="portfolio-featured-image">
                <?php the_post_thumbnail( 'portfolio-thumbnail', array( 'alt' => get_the_title() ) ); ?>
            </div>
            <?php endif; ?>

            <div class="portfolio-info-grid">
                <div class="portfolio-description entry-content">
                    <?php the_content(); ?>
                </div>

                <aside class="portfolio-sidebar-card" aria-label="<?php esc_attr_e( 'プロジェクト情報', 'portfolio' ); ?>">
                    <h3><?php esc_html_e( 'プロジェクト情報', 'portfolio' ); ?></h3>
                    <ul class="portfolio-detail-list">
                        <?php if ( $client ) : ?>
                        <li>
                            <span class="detail-label"><?php esc_html_e( 'クライアント', 'portfolio' ); ?></span>
                            <span class="detail-value"><?php echo esc_html( $client ); ?></span>
                        </li>
                        <?php endif; ?>
                        <?php if ( $project_date ) : ?>
                        <li>
                            <span class="detail-label"><?php esc_html_e( '制作年月', 'portfolio' ); ?></span>
                            <span class="detail-value"><?php echo esc_html( $project_date ); ?></span>
                        </li>
                        <?php endif; ?>
                        <?php if ( $project_role ) : ?>
                        <li>
                            <span class="detail-label"><?php esc_html_e( '担当役割', 'portfolio' ); ?></span>
                            <span class="detail-value"><?php echo esc_html( $project_role ); ?></span>
                        </li>
                        <?php endif; ?>
                        <?php if ( $categories && ! is_wp_error( $categories ) ) : ?>
                        <li>
                            <span class="detail-label"><?php esc_html_e( 'カテゴリー', 'portfolio' ); ?></span>
                            <span class="detail-value">
                                <?php
                                $cat_links = array();
                                foreach ( $categories as $cat ) {
                                    $cat_links[] = '<a href="' . esc_url( get_term_link( $cat ) ) . '">' . esc_html( $cat->name ) . '</a>';
                                }
                                echo implode( '、', $cat_links ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                ?>
                            </span>
                        </li>
                        <?php endif; ?>
                    </ul>

                    <?php if ( $skills && ! is_wp_error( $skills ) ) : ?>
                    <div>
                        <span class="detail-label" style="display:block; margin-bottom:12px;">
                            <?php esc_html_e( '使用技術', 'portfolio' ); ?>
                        </span>
                        <div class="portfolio-card-tags">
                            <?php foreach ( $skills as $skill ) : ?>
                            <a href="<?php echo esc_url( get_term_link( $skill ) ); ?>" class="tag">
                                <?php echo esc_html( $skill->name ); ?>
                            </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if ( $project_url ) : ?>
                    <a href="<?php echo esc_url( $project_url ); ?>"
                       class="btn btn-primary"
                       target="_blank" rel="noopener noreferrer"
                       style="margin-top:24px; display:block; text-align:center;">
                        <?php esc_html_e( 'サイトを見る', 'portfolio' ); ?>
                        &#8599;
                    </a>
                    <?php endif; ?>
                </aside>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <div class="section section-alt">
        <div class="container">
            <nav class="post-navigation" aria-label="<?php esc_attr_e( '前後の作品', 'portfolio' ); ?>"
                 style="display:flex; justify-content:space-between; gap:24px;">
                <?php
                $prev_post = get_previous_post( false, '', 'portfolio_category' );
                $next_post = get_next_post( false, '', 'portfolio_category' );
                ?>
                <div>
                    <?php if ( $prev_post ) : ?>
                    <a href="<?php echo esc_url( get_permalink( $prev_post ) ); ?>"
                       style="font-size:0.9rem; color:var(--color-text-muted);">
                        &larr; <?php echo esc_html( get_the_title( $prev_post ) ); ?>
                    </a>
                    <?php endif; ?>
                </div>
                <div style="text-align:right;">
                    <?php if ( $next_post ) : ?>
                    <a href="<?php echo esc_url( get_permalink( $next_post ) ); ?>"
                       style="font-size:0.9rem; color:var(--color-text-muted);">
                        <?php echo esc_html( get_the_title( $next_post ) ); ?> &rarr;
                    </a>
                    <?php endif; ?>
                </div>
            </nav>
        </div>
    </div>

</article>

<?php
endwhile;

get_footer();
?>
