<?php
/**
 * メインインデックステンプレート
 *
 * @package Portfolio
 */

get_header();
?>

<div class="section">
    <div class="container">

        <?php if ( is_home() && ! is_front_page() ) : ?>
        <header class="section-header" style="text-align:left;">
            <h1 class="section-title"><?php single_post_title(); ?></h1>
        </header>
        <?php endif; ?>

        <?php if ( have_posts() ) : ?>

        <div class="portfolio-grid">
            <?php while ( have_posts() ) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class( 'portfolio-card' ); ?>>
                <?php if ( has_post_thumbnail() ) : ?>
                <div class="portfolio-card-image">
                    <a href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
                        <?php the_post_thumbnail( 'portfolio-card', array( 'alt' => get_the_title() ) ); ?>
                    </a>
                </div>
                <?php endif; ?>
                <div class="portfolio-card-body">
                    <span class="portfolio-card-category">
                        <?php
                        $cats = get_the_category();
                        if ( $cats ) {
                            echo esc_html( $cats[0]->name );
                        }
                        ?>
                    </span>
                    <h2 class="portfolio-card-title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h2>
                    <div class="portfolio-card-excerpt">
                        <?php the_excerpt(); ?>
                    </div>
                </div>
            </article>
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
            <h2><?php esc_html_e( '記事が見つかりませんでした。', 'portfolio' ); ?></h2>
            <p><?php esc_html_e( '検索条件に一致する記事はありませんでした。', 'portfolio' ); ?></p>
        </div>

        <?php endif; ?>

    </div>
</div>

<?php get_footer(); ?>
