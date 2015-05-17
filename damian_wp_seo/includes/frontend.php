<?php

/* 
 * The frontend part
 */

function manipulate_wp_head() {
    global $post;
    if (is_home()) {
        // generate meta description from bloginfo
        echo '<meta name="description" content="' . wp_strip_all_tags(get_bloginfo ( "description" )) . '"/>';
        // generate meta description from all tags
        echo '<meta name="keywords" content="';
        $tags = get_tags();
        $is_first_tag = true;
        if ($tags) {
            foreach ($tags as $tag) {
                if(!$is_first_tag) {
                    echo ',';
                };
                echo $tag->name;
                if($is_first_tag) {
                    $is_first_tag = false;
                };
            };
        };
        echo '"/>';
    };
    if (is_singular()) {
        // generate meta description from content
        $post_excerpt = $post->post_excerpt;
        $post_content = $post->post_content;
        echo '<meta name="description" content="';
        if($post_excerpt) { 
            echo wp_strip_all_tags($post_excerpt);
        } else {
            if($post_content) {
                echo wp_strip_all_tags($post_content);
            };
        };
        echo '"/>';
        
        // generate meta keywords from tags
        echo '<meta name="keywords" content="';
        $tags = wp_get_post_tags($post->ID);
        $is_first_tag = true;
        foreach ($tags as $tag) {
            if(!$is_first_tag) {
                echo ',';
            };
            echo $tag->name;
            if($is_first_tag) {
                $is_first_tag = false;
            };
        };
        echo '"/>';
    }
    if (is_archive()) {
        // WP_Query arguments
        $cat_id = get_query_var('cat');
        // generate meta description for category
        $category_description = category_description( $cat_id );
        if( $category_description ) {
            echo '<meta name="description" content="' . wp_strip_all_tags($category_description) . '"/>';
        } else {
            echo '<meta name="description" content="' . wp_strip_all_tags(get_bloginfo ( "description" )) . '"/>';
        };
        $args = array (
            'cat' => $cat_id,
        );

        // The Query
        $query = new WP_Query( $args );
        
        // The Loop
        if ( $query->have_posts() ) {
            $posts_in_cat = $query->posts;
            $posts_ids = array();
            $posts_tags = array();
            foreach ($posts_in_cat as $post_in_cat) {
                array_push($posts_ids, $post_in_cat->ID);
            }
            foreach ($posts_ids as $post_id) {
                $current_post = get_post($post_id);
                $current_tags = wp_get_post_tags($post_id);
                foreach ($current_tags as $every_tag) {
                    if (!in_array($every_tag->name, $posts_tags)) {
                        array_push($posts_tags, $every_tag->name);
                    };
                };
            };
            
            // generate meta keywords from tags
            echo '<meta name="keywords" content="';
            $is_first_tag = true;
            foreach ($posts_tags as $tag) {
                if(!$is_first_tag) {
                    echo ',';
                };
                echo $tag;
                if($is_first_tag) {
                    $is_first_tag = false;
                };
            };
            echo '"/>';
        } else {
            // no posts found
        };

        // Restore original Post Data
        wp_reset_postdata();
    };
};

?>