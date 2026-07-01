<?php
/**
 * 固定ページテンプレート
 *
 * @package Portfolio
 */

get_header();

while ( have_posts() ) :
    the_post();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="page-hero">
        <div class="container">
            <h1 class="page-hero-title"><?php the_title(); ?></h1>
        </div>
    </div>

    <div class="page-content">
        <div class="container" style="max-width: 900px;">
            <?php if ( has_post_thumbnail() ) : ?>
            <div style="margin-bottom:40px; border-radius:var(--border-radius); overflow:hidden;">
                <?php the_post_thumbnail( 'full', array( 'alt' => get_the_title() ) ); ?>
            </div>
            <?php endif; ?>

            <div class="entry-content">
                <?php
                the_content();
                wp_link_pages( array(
                    'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'portfolio' ),
                    'after'  => '</div>',
                ) );
                ?>
            </div>
        </div>
    </div>
</article>

<?php
endwhile;

get_footer();
?>
