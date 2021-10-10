<?php
/**
 * Wp Plugin Skeleton settings page
 *
 * @package wp-plugin-skeleton 
 */

?>

<div class="wrap wp-plugin-skeleton-page">
    <h2><?php esc_html_e( 'Wp Plugin Skeleton', 'wp-plugin-skeleton' ); ?></h2>

    <?php settings_errors(); ?>

    <form method="post" action="options.php">
        <?php
        settings_fields( 'wp_plugin_skeleton_fields' );
        do_settings_sections( 'wp_plugin_skeleton_fields' );
        submit_button();

        ?>
    </form>
</div>

