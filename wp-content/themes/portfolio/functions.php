<?php
/**
 * Portfolio Theme Functions
 *
 * @package Portfolio
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// ==========================================
// Theme Setup
// ==========================================

function portfolio_theme_setup() {
    load_theme_textdomain( 'portfolio', get_template_directory() . '/languages' );

    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ) );
    add_theme_support( 'custom-background', array(
        'default-color' => 'ffffff',
    ) );
    add_theme_support( 'customize-selective-refresh-widgets' );
    add_theme_support( 'custom-logo', array(
        'height'      => 60,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ) );

    // Register navigation menus
    register_nav_menus( array(
        'primary' => __( 'プライマリーメニュー', 'portfolio' ),
        'footer'  => __( 'フッターメニュー', 'portfolio' ),
    ) );

    // Add image sizes
    add_image_size( 'portfolio-thumbnail', 800, 500, true );
    add_image_size( 'portfolio-card',      600, 375, true );
    add_image_size( 'portfolio-hero',      1600, 600, true );
}
add_action( 'after_setup_theme', 'portfolio_theme_setup' );

// ==========================================
// Content Width
// ==========================================

function portfolio_content_width() {
    $GLOBALS['content_width'] = 1200;
}
add_action( 'after_setup_theme', 'portfolio_content_width', 0 );

// ==========================================
// Enqueue Scripts & Styles
// ==========================================

function portfolio_scripts() {
    // Google Fonts
    wp_enqueue_style(
        'portfolio-google-fonts',
        'https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700&family=Noto+Serif+JP:wght@700&display=swap',
        array(),
        null
    );

    // Main stylesheet
    wp_enqueue_style(
        'portfolio-style',
        get_stylesheet_uri(),
        array( 'portfolio-google-fonts' ),
        wp_get_theme()->get( 'Version' )
    );

    // Main JavaScript
    wp_enqueue_script(
        'portfolio-main',
        get_template_directory_uri() . '/assets/js/main.js',
        array(),
        wp_get_theme()->get( 'Version' ),
        true
    );

    // Pass data to JS
    wp_localize_script( 'portfolio-main', 'portfolioData', array(
        'ajaxUrl' => admin_url( 'admin-ajax.php' ),
        'nonce'   => wp_create_nonce( 'portfolio_nonce' ),
        'siteUrl' => get_site_url(),
    ) );
}
add_action( 'wp_enqueue_scripts', 'portfolio_scripts' );

// ==========================================
// Register Widgets
// ==========================================

function portfolio_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'サイドバー', 'portfolio' ),
        'id'            => 'sidebar-1',
        'description'   => __( 'ウィジェットをここに追加してください。', 'portfolio' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

    register_sidebar( array(
        'name'          => __( 'フッターウィジェット', 'portfolio' ),
        'id'            => 'footer-1',
        'description'   => __( 'フッターエリアのウィジェット', 'portfolio' ),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4>',
        'after_title'   => '</h4>',
    ) );
}
add_action( 'widgets_init', 'portfolio_widgets_init' );

// ==========================================
// Register Custom Post Type: Portfolio
// ==========================================

function portfolio_register_post_types() {
    $labels = array(
        'name'               => __( 'ポートフォリオ', 'portfolio' ),
        'singular_name'      => __( 'ポートフォリオ', 'portfolio' ),
        'menu_name'          => __( 'ポートフォリオ', 'portfolio' ),
        'name_admin_bar'     => __( 'ポートフォリオ', 'portfolio' ),
        'add_new'            => __( '新規追加', 'portfolio' ),
        'add_new_item'       => __( '新しいポートフォリオを追加', 'portfolio' ),
        'new_item'           => __( '新しいポートフォリオ', 'portfolio' ),
        'edit_item'          => __( 'ポートフォリオを編集', 'portfolio' ),
        'view_item'          => __( 'ポートフォリオを表示', 'portfolio' ),
        'all_items'          => __( 'すべてのポートフォリオ', 'portfolio' ),
        'search_items'       => __( 'ポートフォリオを検索', 'portfolio' ),
        'not_found'          => __( 'ポートフォリオが見つかりません', 'portfolio' ),
        'not_found_in_trash' => __( 'ゴミ箱にポートフォリオが見つかりません', 'portfolio' ),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'portfolio' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-portfolio',
        'supports'           => array(
            'title',
            'editor',
            'author',
            'thumbnail',
            'excerpt',
            'custom-fields',
            'revisions',
        ),
        'show_in_rest'       => true,
    );

    register_post_type( 'portfolio', $args );
}
add_action( 'init', 'portfolio_register_post_types' );

// ==========================================
// Register Taxonomy: Portfolio Category
// ==========================================

function portfolio_register_taxonomies() {
    $labels = array(
        'name'              => __( 'ポートフォリオカテゴリー', 'portfolio' ),
        'singular_name'     => __( 'カテゴリー', 'portfolio' ),
        'search_items'      => __( 'カテゴリーを検索', 'portfolio' ),
        'all_items'         => __( 'すべてのカテゴリー', 'portfolio' ),
        'parent_item'       => __( '親カテゴリー', 'portfolio' ),
        'parent_item_colon' => __( '親カテゴリー:', 'portfolio' ),
        'edit_item'         => __( 'カテゴリーを編集', 'portfolio' ),
        'update_item'       => __( 'カテゴリーを更新', 'portfolio' ),
        'add_new_item'      => __( '新しいカテゴリーを追加', 'portfolio' ),
        'new_item_name'     => __( '新しいカテゴリー名', 'portfolio' ),
        'menu_name'         => __( 'カテゴリー', 'portfolio' ),
    );

    register_taxonomy( 'portfolio_category', array( 'portfolio' ), array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'portfolio-category' ),
        'show_in_rest'      => true,
    ) );

    // Portfolio skill tags
    register_taxonomy( 'portfolio_skill', array( 'portfolio' ), array(
        'hierarchical'      => false,
        'labels'            => array(
            'name'          => __( 'スキル・技術', 'portfolio' ),
            'singular_name' => __( 'スキル', 'portfolio' ),
            'menu_name'     => __( 'スキル', 'portfolio' ),
        ),
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'skill' ),
        'show_in_rest'      => true,
    ) );
}
add_action( 'init', 'portfolio_register_taxonomies' );

// ==========================================
// Custom Meta Boxes for Portfolio
// ==========================================

function portfolio_add_meta_boxes() {
    add_meta_box(
        'portfolio_details',
        __( 'ポートフォリオ詳細', 'portfolio' ),
        'portfolio_details_meta_box',
        'portfolio',
        'side',
        'high'
    );
}
add_action( 'add_meta_boxes', 'portfolio_add_meta_boxes' );

function portfolio_details_meta_box( $post ) {
    wp_nonce_field( 'portfolio_save_details', 'portfolio_details_nonce' );

    $client_name  = get_post_meta( $post->ID, '_portfolio_client', true );
    $project_url  = get_post_meta( $post->ID, '_portfolio_url', true );
    $project_date = get_post_meta( $post->ID, '_portfolio_date', true );
    $project_role = get_post_meta( $post->ID, '_portfolio_role', true );
    ?>
    <p>
        <label for="portfolio_client"><strong><?php esc_html_e( 'クライアント', 'portfolio' ); ?></strong></label>
        <input type="text" id="portfolio_client" name="portfolio_client"
               value="<?php echo esc_attr( $client_name ); ?>" class="widefat">
    </p>
    <p>
        <label for="portfolio_url"><strong><?php esc_html_e( 'プロジェクトURL', 'portfolio' ); ?></strong></label>
        <input type="url" id="portfolio_url" name="portfolio_url"
               value="<?php echo esc_attr( $project_url ); ?>" class="widefat" placeholder="https://">
    </p>
    <p>
        <label for="portfolio_date"><strong><?php esc_html_e( '制作年月', 'portfolio' ); ?></strong></label>
        <input type="month" id="portfolio_date" name="portfolio_date"
               value="<?php echo esc_attr( $project_date ); ?>" class="widefat">
    </p>
    <p>
        <label for="portfolio_role"><strong><?php esc_html_e( '担当役割', 'portfolio' ); ?></strong></label>
        <input type="text" id="portfolio_role" name="portfolio_role"
               value="<?php echo esc_attr( $project_role ); ?>" class="widefat"
               placeholder="<?php esc_attr_e( 'デザイン・開発', 'portfolio' ); ?>">
    </p>
    <?php
}

function portfolio_save_details( $post_id ) {
    if ( ! isset( $_POST['portfolio_details_nonce'] ) ) {
        return;
    }
    if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['portfolio_details_nonce'] ) ), 'portfolio_save_details' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    $fields = array(
        'portfolio_client' => '_portfolio_client',
        'portfolio_url'    => '_portfolio_url',
        'portfolio_date'   => '_portfolio_date',
        'portfolio_role'   => '_portfolio_role',
    );

    foreach ( $fields as $field_name => $meta_key ) {
        if ( isset( $_POST[ $field_name ] ) ) {
            update_post_meta(
                $post_id,
                $meta_key,
                sanitize_text_field( wp_unslash( $_POST[ $field_name ] ) )
            );
        }
    }
}
add_action( 'save_post_portfolio', 'portfolio_save_details' );

// ==========================================
// Helper Functions
// ==========================================

/**
 * Get portfolio categories for a post
 */
function portfolio_get_categories( $post_id ) {
    return get_the_terms( $post_id, 'portfolio_category' );
}

/**
 * Get portfolio skills for a post
 */
function portfolio_get_skills( $post_id ) {
    return get_the_terms( $post_id, 'portfolio_skill' );
}

/**
 * Render category badge
 */
function portfolio_the_category( $post_id = null ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }
    $terms = portfolio_get_categories( $post_id );
    if ( $terms && ! is_wp_error( $terms ) ) {
        $first = reset( $terms );
        echo '<span class="portfolio-card-category">' . esc_html( $first->name ) . '</span>';
    }
}

/**
 * Render skill tags
 */
function portfolio_the_skills( $post_id = null ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }
    $skills = portfolio_get_skills( $post_id );
    if ( $skills && ! is_wp_error( $skills ) ) {
        foreach ( $skills as $skill ) {
            echo '<span class="tag">' . esc_html( $skill->name ) . '</span>';
        }
    }
}

/**
 * Query recent portfolio items
 */
function portfolio_get_posts( $count = 6, $category = '' ) {
    $args = array(
        'post_type'      => 'portfolio',
        'posts_per_page' => $count,
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
    );

    if ( $category ) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'portfolio_category',
                'field'    => 'slug',
                'terms'    => $category,
            ),
        );
    }

    return new WP_Query( $args );
}

// ==========================================
// Fallback Navigation Menu
// ==========================================

function portfolio_fallback_menu() {
    echo '<ul class="nav-menu">';
    echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'ホーム', 'portfolio' ) . '</a></li>';
    echo '<li><a href="' . esc_url( get_post_type_archive_link( 'portfolio' ) ) . '">' . esc_html__( 'ポートフォリオ', 'portfolio' ) . '</a></li>';
    echo '</ul>';
}

// ==========================================
// Flush Rewrite Rules on Theme Activation
// ==========================================

function portfolio_flush_rewrite_rules() {
    portfolio_register_post_types();
    portfolio_register_taxonomies();
    flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'portfolio_flush_rewrite_rules' );
