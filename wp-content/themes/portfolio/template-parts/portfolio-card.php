<?php
/**
 * ポートフォリオカードテンプレートパーツ
 *
 * @package Portfolio
 */

$post_id     = get_the_ID();
$categories  = portfolio_get_categories( $post_id );
$skills      = portfolio_get_skills( $post_id );
$project_url = get_post_meta( $post_id, '_portfolio_url', true );
$cat_slugs   = array();

if ( $categories && ! is_wp_error( $categories ) ) {
    foreach ( $categories as $cat ) {
        $cat_slugs[] = $cat->slug;
    }
}
?>
<article id="portfolio-<?php the_ID(); ?>"
         <?php post_class( 'portfolio-card' ); ?>
         data-category="<?php echo esc_attr( implode( ' ', $cat_slugs ) ); ?>">

    <div class="portfolio-card-image">
        <?php if ( has_post_thumbnail() ) : ?>
            <?php the_post_thumbnail( 'portfolio-card', array( 'alt' => get_the_title() ) ); ?>
        <?php else : ?>
            <div style="width:100%;height:100%;background:linear-gradient(135deg,#2c3e50,#3498db);"></div>
        <?php endif; ?>

        <div class="portfolio-card-overlay" aria-hidden="true">
            <a href="<?php the_permalink(); ?>" class="btn" tabindex="-1">
                <?php esc_html_e( '詳細を見る', 'portfolio' ); ?>
            </a>
        </div>
    </div>

    <div class="portfolio-card-body">
        <?php portfolio_the_category( $post_id ); ?>

        <h2 class="portfolio-card-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h2>

        <div class="portfolio-card-excerpt">
            <?php
            $excerpt = get_the_excerpt();
            echo esc_html( wp_trim_words( $excerpt, 30, '…' ) );
            ?>
        </div>

        <div class="portfolio-card-footer">
            <div class="portfolio-card-tags">
                <?php portfolio_the_skills( $post_id ); ?>
            </div>
            <?php if ( $project_url ) : ?>
            <a href="<?php echo esc_url( $project_url ); ?>"
               target="_blank" rel="noopener noreferrer"
               class="tag"
               aria-label="<?php echo esc_attr( get_the_title() ) . ' ' . esc_attr__( 'サイトを見る', 'portfolio' ); ?>">
                &#8599;
            </a>
            <?php endif; ?>
        </div>
    </div>
</article>
