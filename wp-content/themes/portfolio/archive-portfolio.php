<?php
/**
 * ポートフォリオ一覧テンプレート
 *
 * @package Portfolio
 */

get_header();

$queried_object = get_queried_object();
$current_category = '';
if ( $queried_object instanceof WP_Term ) {
    $current_category = $queried_object->slug;
}
?>

<section class="single-portfolio-hero">
    <div class="container">
        <?php if ( is_tax( 'portfolio_category' ) && $queried_object ) : ?>
            <h1 class="single-portfolio-title">
                <?php echo esc_html( $queried_object->name ); ?>
            </h1>
            <?php if ( $queried_object->description ) : ?>
            <p style="color:rgba(255,255,255,0.75); margin-top:12px;">
                <?php echo esc_html( $queried_object->description ); ?>
            </p>
            <?php endif; ?>
        <?php elseif ( is_tax( 'portfolio_skill' ) && $queried_object ) : ?>
            <p class="hero-eyebrow"><?php esc_html_e( 'SKILL', 'portfolio' ); ?></p>
            <h1 class="single-portfolio-title">
                <?php echo esc_html( $queried_object->name ); ?>
            </h1>
        <?php else : ?>
            <p class="hero-eyebrow"><?php esc_html_e( 'WORKS', 'portfolio' ); ?></p>
            <h1 class="single-portfolio-title">
                <?php esc_html_e( 'ポートフォリオ一覧', 'portfolio' ); ?>
            </h1>
            <p style="color:rgba(255,255,255,0.75); margin-top:12px;">
                <?php esc_html_e( 'これまでに手がけた作品をご覧ください。', 'portfolio' ); ?>
            </p>
        <?php endif; ?>
    </div>
</section>

<div class="section">
    <div class="container">
        <?php
        // Category filter
        $categories = get_terms( array(
            'taxonomy'   => 'portfolio_category',
            'hide_empty' => true,
        ) );
        if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) :
        ?>
        <div class="portfolio-filter" role="group" aria-label="<?php esc_attr_e( 'カテゴリーフィルター', 'portfolio' ); ?>">
            <a href="<?php echo esc_url( get_post_type_archive_link( 'portfolio' ) ); ?>"
               class="filter-btn <?php echo ! $current_category ? 'active' : ''; ?>">
                <?php esc_html_e( 'すべて', 'portfolio' ); ?>
            </a>
            <?php foreach ( $categories as $cat ) : ?>
            <a href="<?php echo esc_url( get_term_link( $cat ) ); ?>"
               class="filter-btn <?php echo ( $current_category === $cat->slug ) ? 'active' : ''; ?>">
                <?php echo esc_html( $cat->name ); ?>
            </a>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <?php if ( have_posts() ) : ?>

        <div class="portfolio-grid">
            <?php while ( have_posts() ) : the_post(); ?>
                <?php get_template_part( 'template-parts/portfolio', 'card' ); ?>
            <?php endwhile; ?>
        </div>

        <nav class="portfolio-pagination" aria-label="<?php esc_attr_e( 'ページナビゲーション', 'portfolio' ); ?>">
            <?php
            echo wp_kses_post( paginate_links( array(
                'prev_text' => '&laquo;',
                'next_text' => '&raquo;',
            ) ) );
            ?>
        </nav>

        <?php else : ?>

        <div class="no-results">
            <h2><?php esc_html_e( '作品が見つかりませんでした。', 'portfolio' ); ?></h2>
            <p><?php esc_html_e( '別のカテゴリーをお試しください。', 'portfolio' ); ?></p>
            <a href="<?php echo esc_url( get_post_type_archive_link( 'portfolio' ) ); ?>" class="btn btn-primary">
                <?php esc_html_e( '全作品を見る', 'portfolio' ); ?>
            </a>
        </div>

        <?php endif; ?>
    </div>
</div>

<?php get_footer(); ?>
