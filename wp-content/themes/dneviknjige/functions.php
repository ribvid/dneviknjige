<?php

use Illuminate\Support\Str;
use Roots\Acorn\Application;

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| our theme. We will simply require it into the script here so that we
| don't have to worry about manually loading any of our classes later on.
|
*/

if ( ! file_exists( $composer = __DIR__ . '/vendor/autoload.php' ) ) {
    wp_die( __( 'Error locating autoloader. Please run <code>composer install</code>.', 'sage' ) );
}

require $composer;

/*
|--------------------------------------------------------------------------
| Register The Bootloader
|--------------------------------------------------------------------------
|
| The first thing we will do is schedule a new Acorn application container
| to boot when WordPress is finished loading the theme. The application
| serves as the "glue" for all the components of Laravel and is
| the IoC container for the system binding all of the various parts.
|
*/

Application::configure()
           ->withProviders( [
               App\Providers\ThemeServiceProvider::class,
           ] )
           ->boot();

/*
|--------------------------------------------------------------------------
| Register Sage Theme Files
|--------------------------------------------------------------------------
|
| Out of the box, Sage ships with categorically named theme files
| containing common functionality and setup to be bootstrapped with your
| theme. Simply add (or remove) files from the array below to change what
| is registered alongside Sage.
|
*/

collect( [ 'setup', 'filters' ] )
    ->each( function ( $file ) {
        if ( ! locate_template( $file = "app/{$file}.php", true, true ) ) {
            wp_die(
            /* translators: %s is replaced with the relative file path */
                sprintf( __( 'Error locating <code>%s</code> for inclusion.', 'sage' ), $file )
            );
        }
    } );

// Disable Gutenberg
add_filter( 'use_block_editor_for_post', '__return_false', 10 );
add_filter( 'use_widgets_block_editor', '__return_false' );
add_filter( 'gutenberg_use_widgets_block_editor', '__return_false', 100 );

// Close comments on the front-end
add_filter( 'comments_open', '__return_false', 20, 2 );
add_filter( 'pings_open', '__return_false', 20, 2 );

// Google Analytics, favicon and OG tags
add_action( 'wp_head', function () {
    ?>
    <!-- Google tag (gtag.js) -->


    <!-- Favicons -->
    <link rel="icon" href="/favicon.ico" sizes="32x32">
    <link rel="icon" href="<?php echo esc_url( asset( 'resources/images/icon.svg' ) ) ?>" type="image/svg+xml">

    <?php
    display_og_tags();
} );

function display_og_tags(): void {
    global $wp;

    $title       = esc_attr( get_bloginfo( "name" ) );
    $url         = home_url( $wp->request );
    $image       = esc_url( asset( 'resources/images/og-image.jpg' ) );
    $description = __( '', 'sage' );

    if ( is_singular() && ! is_front_page() && ! is_home() ) {
        $title = get_the_title();
        $url   = get_permalink();
        if ( has_post_thumbnail() ) {
            $image = get_the_post_thumbnail_url();
        }
        $description = get_the_excerpt();
    }

    echo '<meta property="og:type" content="website" />';
    echo '<meta property="og:title" content="' . esc_attr( $title ) . '" />';
    echo '<meta property="og:url" content="' . esc_url( $url ) . '" />';
    echo '<meta property="og:image" content="' . esc_url( $image ) . '" />';
    echo '<meta property="og:description" content="' . esc_attr( $description ) . '" />';
    echo '<meta property="twitter:card" content="summary_large_image" />';
    echo '<meta property="twitter:title" content="' . esc_attr( $title ) . '" />';
    echo '<meta property="twitter:url" content="' . esc_url( $url ) . '" />';
    echo '<meta property="twitter:image" content="' . esc_url( $image ) . '" />';
    echo '<meta property="twitter:description" content="' . esc_attr( $description ) . '" />';
}

// Custom post types
add_action( 'init', function () {
    register_post_type( 'festival', [
        'label'       => 'Letnik',
        'labels'      => [
            'name'               => 'Letniki',
            'singular_name'      => 'Letnik',
            'add_new'            => 'Dodaj letnik',
            'add_new_item'       => 'Dodaj letnik',
            'edit_item'          => 'Uredi letnik',
            'new_item'           => 'Nov letnik',
            'view_item'          => 'Poglej letnik',
            'view_items'         => 'Poglej letnike',
            'search_items'       => 'Poišči letnik',
            'not_found'          => 'Ni najdenih letnikov',
            'not_found_in_trash' => 'Ni najdenih letnikov',
            'all_items'          => 'Vsi letniki',
            'items_list'         => 'Seznam letnikov',
        ],
        'public'      => true,
        'supports'    => [
            'title',
        ],
        'has_archive' => 'arhiv',
        'rewrite'     => [
            'slug' => 'leto',
        ],
    ] );

    register_post_type( 'programme', [
        'label'       => 'Program',
        'labels'      => [
            'name'               => 'Programi',
            'singular_name'      => 'Program',
            'add_new'            => 'Dodaj program',
            'add_new_item'       => 'Dodaj program',
            'edit_item'          => 'Uredi program',
            'new_item'           => 'Nov program',
            'view_item'          => 'Poglej program',
            'view_items'         => 'Poglej programe',
            'search_items'       => 'Poišči program',
            'not_found'          => 'Ni najdenih programov',
            'not_found_in_trash' => 'Ni najdenih programov',
            'all_items'          => 'Vsi programi',
            'items_list'         => 'Seznam programov',
        ],
        'public'      => true,
        'supports'    => [
            'title',
        ],
        'has_archive' => 'program',
        'rewrite'     => [
            'slug' => 'program',
        ],
    ] );

    register_post_type( 'city', [
        'label'       => 'Partnersko mesto',
        'labels'      => [
            'name'               => 'Partnerska mesta',
            'singular_name'      => 'Partnersko mesto',
            'add_new'            => 'Dodaj partnersko mesto',
            'add_new_item'       => 'Dodaj partnersko mesto',
            'edit_item'          => 'Uredi partnersko mesto',
            'new_item'           => 'Novo partnersko mesto',
            'view_item'          => 'Poglej partnersko mesto',
            'view_items'         => 'Poglej partnersko mesto',
            'search_items'       => 'Poišči partnerska mesta',
            'not_found'          => 'Ni najdenih partnerskih mest',
            'not_found_in_trash' => 'Ni najdenih partnerskih mest',
            'all_items'          => 'Vsa partnerska mesta',
            'items_list'         => 'Seznam partnerskih mest',
        ],
        'public'      => true,
        'supports'    => [
            'title',
        ],
        'has_archive' => 'partnerska-mesta',
        'rewrite'     => [
            'slug' => 'partnersko-mesto',
        ],
    ] );
} );

// Options pages
add_action( 'acf/init', function () {
    if ( function_exists( 'acf_add_options_page' ) ) {
        acf_add_options_page( [
            'page_title'  => 'Aktivni letnik',
            'menu_title'  => 'Aktivni letnik',
            'menu_slug'   => 'active-festival',
            'parent_slug' => 'edit.php?post_type=festival',
            'capability'  => 'edit_posts',
            'redirect'    => false
        ] );

        acf_add_options_page( [
            'page_title' => 'Financerji',
            'menu_title' => 'Financerji',
            'menu_slug'  => 'funders',
            'position'   => 30,
            'capability' => 'edit_posts',
            'redirect'   => false
        ] );
    }
} );

/**
 * Custom permalink structure for Programme custom post type
 * Format: /{festival_slug}/program/d/m with numeric suffix for duplicates
 */

// 1. Register the rewrite rule for the Programme custom post type
add_action( 'init', function () {
    add_rewrite_rule(
        '(\d{4})/program/(\d{1,2})/(\d{1,2})(/(\d+))?/?$',
        'index.php?post_type=programme&festival_slug=$matches[1]&day=$matches[2]&monthnum=$matches[3]&programme_number=$matches[5]',
        'top'
    );

    add_rewrite_tag( '%programme_number%', '([0-9]+)' );
} );

// 2. Register custom query vars
add_filter( 'query_vars', function ( $query_vars ) {
    $query_vars[] = 'programme_number';

    return $query_vars;
} );

// 3. Modify the permalink structure for Programme posts
add_filter( 'post_type_link', function ( $permalink, $post ) {
    if ( $post->post_type !== 'programme' || $permalink === '' ) {
        return $permalink;
    }

    // Get the programme date
    $date = get_field( 'date', $post->ID, false );
    if ( ! $date ) {
        return $permalink;
    }

    $festival = get_field( 'festival', $post->ID );
    if ( ! $festival || ! isset( $festival->post_name ) ) {
        return $permalink;
    }

    // Check for duplicate dates and append suffix if needed
    $suffix = get_programme_date_suffix( $post->ID );

    // Build the URL
    $reformatted_date = DateTime::createFromFormat( 'Ymd', $date );
    $day_and_month    = $reformatted_date->format( 'd/m' );
    $url              = home_url( "$festival->post_name/program/$day_and_month/" );

    // Add suffix if needed
    if ( $suffix !== null ) {
        $url .= "$suffix/";
    }

    return $url;
}, 10, 2 );

/**
 * Get the appropriate suffix for programmes with identical dates
 */
function get_programme_date_suffix( int $current_post_id ): string|null {
    $date     = get_field( 'date', $current_post_id, false );
    $festival = get_field( 'festival', $current_post_id );

    // Find all programmes with the same date
    $args = [
        'post_type'      => 'programme',
        'posts_per_page' => - 1,
        'meta_query'     => [
            'relation' => 'AND',
            [
                'key'     => 'date',
                'value'   => $date,
                'compare' => 'LIKE'
            ],
            [
                'key'     => 'festival',
                'value'   => $festival->ID,
                'compare' => '='
            ]
        ],
        'orderby'        => 'ID',
        'order'          => 'ASC',
        'fields'         => 'ids',
    ];

    $programme_ids = get_posts( $args );

    // If there's only one programme with this date, no suffix needed
    if ( count( $programme_ids ) <= 1 ) {
        return null;
    }

    // Find position of current post in the collection
    $position = array_search( $current_post_id, $programme_ids );

    // Return appropriate suffix based on position
    // First post with the date gets no suffix, others get suffix number
    return ( $position > 0 ) ? (string) $position : null;
}

/**
 * Ensure WordPress recognizes our custom URL structure
 * This function tells WordPress how to parse our custom URL format
 */
add_action( 'parse_request', function ( $wp ) {
    // Check if this is a potential programme URL
    if ( ! isset( $wp->query_vars['post_type'] ) ||
         $wp->query_vars['post_type'] !== 'programme' ||
         ! isset( $wp->query_vars['festival_slug'] ) ||
         ! isset( $wp->query_vars['monthnum'] ) ||
         ! isset( $wp->query_vars['day'] ) ) {
        return;
    }

    $festivals = get_posts( [
        'name'           => $wp->query_vars['festival_slug'],
        'post_type'      => 'festival',
        'post_status'    => 'publish',
        'posts_per_page' => 1
    ] );

    if ( empty( $festivals ) ) {
        return;
    }

    $festival = $festivals[0];
    $month    = $wp->query_vars['monthnum'];
    $day      = $wp->query_vars['day'];

    // Get programme number (suffix) if it exists
    $programme_number = isset( $wp->query_vars['programme_number'] )
        ? intval( $wp->query_vars['programme_number'] )
        : 0;

    // Build query to find matching programme
    $args = [
        'post_type'      => 'programme',
        'posts_per_page' => - 1,
        'meta_query'     => [
//            'relation' => 'AND',
            [
                'key'     => 'festival',
                'value'   => $festival->ID,
                'compare' => '='
            ],
            [
                'key'     => 'date',
                'value'   => sprintf( '%02d%02d', $month, $day ),
                'compare' => 'LIKE'
            ]
        ],
        'orderby'        => 'ID',
        'order'          => 'ASC',
    ];

    $programmes = get_posts( $args );

    // If we found matching programmes
    if ( ! empty( $programmes ) ) {
        // Get the programme based on suffix
        $position = $programme_number;

        if ( isset( $programmes[ $position ] ) ) {
            // Set query to display the specific post
            $wp->query_vars = [
                'post_type' => 'programme',
                'p'         => $programmes[ $position ]->ID,
                'page'      => '',
                'posts'     => '',
                'pagename'  => '',
            ];
        }
    }
} );

// Add a "festival" column to the "programme" posts list
add_filter( 'manage_programme_posts_columns', function ( $columns ) {
    return [
        'cb'           => $columns['cb'],
        'title'        => $columns['title'],
        'acf_festival' => 'Letnik',
        'date'         => $columns['date'],
    ];
} );

// Add a "festival" column to the "city" posts list
add_filter( 'manage_city_posts_columns', function ( $columns ) {
    return [
        'cb'           => $columns['cb'],
        'title'        => $columns['title'],
        'acf_festival' => 'Letnik',
        'date'         => $columns['date'],
    ];
} );

// Populate the "festival" column with data
add_action( 'manage_programme_posts_custom_column', function ( $column, $post_id ) {
    if ( $column === 'acf_festival' ) {
        $festival_post = get_field( 'festival', $post_id );

        if ( $festival_post ) {
            echo get_the_title( $festival_post );
        }
    }
}, 10, 2 );

add_action( 'manage_city_posts_custom_column', function ( $column, $post_id ) {
    if ( $column === 'acf_festival' ) {
        $festival_post = get_field( 'festival', $post_id );

        if ( $festival_post ) {
            echo get_the_title( $festival_post );
        }
    }
}, 10, 2 );

// Make the festival column sortable
add_action( 'manage_edit-programme_sortable_columns', function ( $columns ) {
    $columns['acf_festival'] = 'festival';

    return $columns;
} );

add_action( 'manage_edit-city_sortable_columns', function ( $columns ) {
    $columns['acf_festival'] = 'festival';

    return $columns;
} );

// Add the logic to sort by the "festival" field
add_action( 'pre_get_posts', function ( $query ) {
    if ( ! is_admin() || ! $query->is_main_query() ) {
        return;
    }

    $orderby = $query->get( 'orderby' );

    if ( $orderby === 'acf_festival' ) {
        $query->set( 'meta_key', 'festival' );
        $query->set( 'orderby', 'meta_value_num' );
    }
} );

// Add filtering capability
add_action( 'restrict_manage_posts', function ( $post_type ) {
    if ( $post_type === "programme" || $post_type === "city" ) {
        $festivals = get_posts( [
            'post_type'      => 'festival',
            'posts_per_page' => - 1,
            'orderby'        => 'title',
            'order'          => 'DESC',
        ] );

        if ( $festivals ) {
            // Get the currently selected festival (if any)
            $selected_festival = $_GET['acf_festival_filter'] ?? '';

            // Start the dropdown
            echo '<select name="acf_festival_filter">';
            echo '<option value="">' . __( 'Vsi letniki', 'sage' ) . '</option>';

            // Add all festivals to the dropdown
            foreach ( $festivals as $festival ) {
                $selected = selected( $selected_festival, $festival->ID, false );
                echo "<option value='$festival->ID' $selected>Leto $festival->post_title</option>";
            }

            echo '</select>';
        }
    }
} );

// Process the filter
add_action( 'parse_query', function ( $query ) {
    global $pagenow;

    if ( is_admin() && in_array( $query->get( 'post_type' ), [ 'programme', 'city' ] ) && $pagenow === 'edit.php' ) {
        $selected_festival_id = $_GET['acf_festival_filter'] ?? '';

        if ( $selected_festival_id ) {
            // Add meta query to filter posts
            $query->query_vars['meta_key']     = 'festival';
            $query->query_vars['meta_value']   = $selected_festival_id;
            $query->query_vars['meta_compare'] = '=';
        }
    }
} );

/**
 * Custom permalink structure for City custom post type
 * Format: /{festival_slug}/mesto/{slug} with numeric suffix for duplicates
 */

// 1. Register the rewrite rule for the City custom post type
add_action( 'init', function () {
    add_rewrite_rule(
        '([^/]+)/mesto/([^/]+)(/(\d+))?/?$',
        'index.php?post_type=city&festival_slug=$matches[1]&city_name=$matches[2]&city_number=$matches[4]',
        'top'
    );

    add_rewrite_tag( '%festival_slug%', '([^/]+)' );
    add_rewrite_tag( '%city_name%', '([^/]+)' );
    add_rewrite_tag( '%city_number%', '([0-9]+)' );
} );

// 2. Register custom query vars
add_filter( 'query_vars', function ( $query_vars ) {
    $query_vars[] = 'festival_slug';
    $query_vars[] = 'city_name';
    $query_vars[] = 'city_number';

    return $query_vars;
} );

// 3. Modify the permalink structure for City posts
add_filter( 'post_type_link', function ( $permalink, $post ) {
    if ( $post->post_type !== 'city' || $permalink === '' ) {
        return $permalink;
    }

    // Get the festival post object
    $festival_obj = get_field( 'festival', $post->ID );
    if ( ! $festival_obj || ! isset( $festival_obj->post_name ) ) {
        return $permalink; // Return default if no date is set
    }

    // Check for duplicate cities and append suffix if needed
    $suffix = get_city_suffix( $post->ID );

    // Build the URL
    $city_slug = Str::slug( $post->post_title );
    $url       = home_url( "/$festival_obj->post_name/mesto/$city_slug/" );

    // Add suffix if needed
    if ( $suffix !== null ) {
        $url .= "$suffix/";
    }

    return $url;
}, 10, 2 );

/**
 * Get the appropriate suffix for cities with identical festivals
 */
function get_city_suffix( int $current_post_id ): string|null {
    $festival = get_field( 'festival', $current_post_id );

    // Find all programmes with the same date
    $args = [
        'post_type'      => 'city',
        'posts_per_page' => - 1,
        'title'          => get_the_title( $current_post_id ),
        'meta_query'     => [
            [
                'key'     => 'festival',
                'value'   => $festival->ID,
                'compare' => '='
            ]
        ],
        'orderby'        => 'ID',
        'order'          => 'ASC',
        'fields'         => 'ids',
    ];

    $city_ids = get_posts( $args );

    // If there's only one city with this festival, no suffix needed
    if ( count( $city_ids ) <= 1 ) {
        return null;
    }

    // Find position of current post in the collection
    $position = array_search( $current_post_id, $city_ids );

    // Return appropriate suffix based on position
    // First post with the date gets no suffix, others get suffix number
    return ( $position > 0 ) ? (string) $position : null;
}

/**
 * Ensure WordPress recognizes our custom URL structure
 * This function tells WordPress how to parse our custom URL format
 */
add_action( 'parse_request', function ( $wp ) {
    // Check if this is a potential programme URL
    if ( ! isset( $wp->query_vars['post_type'] ) ||
         $wp->query_vars['post_type'] !== 'city' ||
         ! isset( $wp->query_vars['city_name'] ) ||
         ! isset( $wp->query_vars['festival_slug'] ) ) {
        return;
    }

    $festival_slug = $wp->query_vars['festival_slug'];
    $city_slug     = $wp->query_vars['city_name'];

    $festivals = get_posts( [
        'name'           => $festival_slug,
        'post_type'      => 'festival',
        'post_status'    => 'publish',
        'posts_per_page' => 1
    ] );

    if ( empty( $festivals ) ) {
        return;
    }

    $festival = $festivals[0];

    // Get city number (suffix) if it exists
    $city_number = isset( $wp->query_vars['city_number'] )
        ? intval( $wp->query_vars['city_number'] )
        : 0;

    // Build query to find matching programme
    $args = [
        'post_type'      => 'city',
        'posts_per_page' => - 1,
        'meta_query'     => [
            [
                'key'     => 'festival',
                'value'   => $festival->ID,
                'compare' => '='
            ],
        ],
        'orderby'        => 'ID',
        'order'          => 'ASC',
    ];

    $cities = array_values( array_filter( get_posts( $args ), fn( $city ) => Str::slug( $city->post_title ) === $city_slug ) );

    // If we found matching cities
    if ( ! empty( $cities ) ) {
        // Get the city based on suffix
        $position = $city_number;

        if ( isset( $cities[ $position ] ) ) {
            // Set query to display the specific post
            $wp->query_vars = [
                'post_type' => 'city',
                'p'         => $cities[ $position ]->ID,
                'page'      => '',
                'posts'     => '',
                'pagename'  => '',
            ];
        }
    }
} );

/** Filter past events from "Programme" and "City" archive */
add_action( 'pre_get_posts', function ( $query ) {
    if ( is_admin() || ! $query->is_main_query() ) {
        return;
    }

    if ( ! is_post_type_archive( 'city' ) && ! is_post_type_archive( 'programme' ) ) {
        return;
    }

    $query->set( 'posts_per_page', - 1 );

    $active_festival = get_field( 'active_festival', 'option' );

    if ( ! $active_festival ) {
        // Force no posts to be returned
        $query->set( 'post__in', [ 0 ] );

        return;
    }

    $query->set( 'meta_query', [
        [
            'key'     => 'festival',
            'compare' => '=',
            'value'   => $active_festival,
        ],
    ] );

    if ( is_post_type_archive( 'programme' ) ) {
        $query->set( 'orderby', 'meta_value_num' );
        $query->set( 'meta_key', 'date' );
        $query->set( 'order', 'ASC' );
    }
} );

/** Remove active festival from the "Festival" archive */
add_action( 'pre_get_posts', function ( $query ) {
    if ( is_admin() || ! $query->is_main_query() ) {
        return;
    }

    if ( ! is_post_type_archive( 'festival' ) ) {
        return;
    }

    $active_festival = get_field( 'active_festival', 'option' );

    if ( $active_festival ) {
        $query->set( 'post__not_in', [ $active_festival ] );
    }
} );

// Allow svg and path tags in acf fields
add_filter( 'wp_kses_allowed_html', function ( $tags, $context ) {
    if ( $context === 'acf' ) {
        $tags['svg']  = [
            'xmlns'       => true,
            'fill'        => true,
            'viewbox'     => true,
            'role'        => true,
            'aria-hidden' => true,
            'aria-label'  => true,
            'focusable'   => true,
        ];
        $tags['path'] = [
            'd'               => true,
            'fill'            => true,
            'stroke'          => true,
            'stroke-width'    => true,
            'stroke-linecap'  => true,
            'stroke-linejoin' => true,
        ];
    }

    return $tags;
}, 10, 2 );

// Display icons in the social networks and other projects navigations
add_filter( 'wp_nav_menu_objects', function ( $items, $args ) {
    foreach ( $items as &$item ) {
        $icon = get_field( 'icon', $item );

        if ( $icon ) {
            $item->title = $icon;
        }
    }

    return $items;
}, 10, 2 );

// Set the page <title> for the festivals
add_filter('pre_get_document_title', function ($title) {
    if (get_post_type() === 'festival') {
        return "Festival " . get_the_title();
    }
});
