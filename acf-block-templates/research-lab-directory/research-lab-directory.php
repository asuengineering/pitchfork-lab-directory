<?php
/**
 * Research Lab Directory block render template.
 *
 * @package Pitchfork_Lab_Directory
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( function_exists( 'pfld_enqueue_research_lab_directory_assets' ) ) {
	pfld_enqueue_research_lab_directory_assets();
}

$show_area_filters = get_field( 'pfld_show_research_area_filters' );
$show_area_filters = null === $show_area_filters ? true : (bool) $show_area_filters;

$show_recruiting_filter = get_field( 'pfld_show_recruiting_filter' );
$show_recruiting_filter = null === $show_recruiting_filter ? true : (bool) $show_recruiting_filter;

$show_search = get_field( 'pfld_show_search' );
$show_search = null === $show_search ? true : (bool) $show_search;

$block_attr = array( 'pfld-directory', 'wp-block-pfld-research-lab-directory' );
if ( ! empty( $block['className'] ) ) {
	$block_attr = array_merge( $block_attr, preg_split( '/\s+/', $block['className'] ) );
}

$spacing = '';
if ( function_exists( 'pitchfork_blocks_acf_calculate_spacing' ) ) {
	$spacing = pitchfork_blocks_acf_calculate_spacing( $block );
}

$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
	$anchor = ' id="' . esc_attr( $block['anchor'] ) . '"';
}

$block_id = ! empty( $block['id'] ) ? sanitize_html_class( $block['id'] ) : wp_unique_id( 'pfld-directory-' );

$labs_query = new WP_Query(
	array(
		'post_type'      => 'research-lab',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'orderby'        => 'title',
		'order'          => 'ASC',
		'no_found_rows'  => true,
	)
);

$filter_terms = array();
if ( $show_area_filters ) {
	$filter_terms = get_terms(
		array(
			'taxonomy'   => 'research-area',
			'hide_empty' => true,
			'orderby'    => 'name',
			'order'      => 'ASC',
		)
	);

	if ( is_wp_error( $filter_terms ) ) {
		$filter_terms = array();
	}
}

$total_count = (int) $labs_query->post_count;
$class_attr  = implode( ' ', array_map( 'sanitize_html_class', $block_attr ) );
?>

<div<?php echo $anchor; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> class="<?php echo esc_attr( $class_attr ); ?>" style="<?php echo esc_attr( $spacing ); ?>" data-pfld-directory="<?php echo esc_attr( $block_id ); ?>">
	<div class="pfld-result-summary">
		<span class="pfld-summary-icon" aria-hidden="true">i</span>
		<span role="status" aria-live="polite">There are <span class="pfld-visible-count"><?php echo esc_html( $total_count ); ?></span> research organizations that match your query.</span>
		<?php if ( $show_recruiting_filter ) : ?>
			<span class="pfld-summary-recruiting">
				<input id="<?php echo esc_attr( $block_id ); ?>-recruiting-inline" class="pfld-recruiting-filter" type="checkbox" value="1">
				<label for="<?php echo esc_attr( $block_id ); ?>-recruiting-inline"><?php esc_html_e( 'Currently recruiting students', 'pitchfork-lab-directory' ); ?></label>
			</span>
		<?php endif; ?>
	</div>

	<div class="pfld-layout">
		<div class="pfld-results">
			<?php
			if ( $labs_query->have_posts() ) :
				while ( $labs_query->have_posts() ) :
					$labs_query->the_post();

					$lab_id       = get_the_ID();
					$title        = get_the_title();
					$external_url = get_field( 'pfld_external_url', $lab_id );
					$recruiting   = (bool) get_field( 'pfld_recruiting_students', $lab_id );
					$terms        = get_the_terms( $lab_id, 'research-area' );
					$term_slugs   = array();
					$term_names   = array();

					if ( $terms && ! is_wp_error( $terms ) ) {
						foreach ( $terms as $term ) {
							$term_slugs[] = sanitize_title( $term->slug );
							$term_names[] = $term->name;
						}
					}

					$content_plain = wp_strip_all_tags( strip_shortcodes( get_post_field( 'post_content', $lab_id ) ) );
					$summary       = wp_trim_words( $content_plain, 55, '&hellip;' );
					$search_text   = strtolower( $title . ' ' . $content_plain . ' ' . implode( ' ', $term_names ) );
					$card_tag      = $external_url ? 'a' : 'article';
					$card_attrs    = $external_url ? ' href="' . esc_url( $external_url ) . '"' : '';
					?>

					<<?php echo esc_html( $card_tag ); ?> class="pfld-lab" data-pfld-lab data-search="<?php echo esc_attr( $search_text ); ?>" data-areas="<?php echo esc_attr( implode( ' ', $term_slugs ) ); ?>" data-recruiting="<?php echo $recruiting ? '1' : '0'; ?>"<?php echo $card_attrs; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
						<div class="pfld-lab-media">
							<?php
							if ( has_post_thumbnail( $lab_id ) ) {
								echo wp_get_attachment_image(
									get_post_thumbnail_id( $lab_id ),
									'medium',
									false,
									array(
										'class'   => 'pfld-lab-image',
										'loading' => 'lazy',
									)
								);
							} else {
								?>
								<div class="pfld-lab-image-placeholder" aria-hidden="true"></div>
								<?php
							}
							?>
						</div>

						<div class="pfld-lab-content">
							<h3 class="pfld-lab-title"><?php echo esc_html( $title ); ?></h3>
							<?php if ( $summary ) : ?>
								<p class="pfld-lab-summary"><?php echo esc_html( $summary ); ?></p>
							<?php endif; ?>

							<?php if ( $recruiting ) : ?>
								<span class="badge badge-rectangle pfld-recruiting-badge"><?php esc_html_e( 'Recruiting students', 'pitchfork-lab-directory' ); ?></span>
							<?php endif; ?>

							<?php if ( ! empty( $term_names ) ) : ?>
								<div class="pfld-lab-tags" aria-label="<?php esc_attr_e( 'Research areas', 'pitchfork-lab-directory' ); ?>">
									<?php foreach ( $term_names as $term_name ) : ?>
										<span class="badge badge-rectangle pfld-area-badge"><?php echo esc_html( $term_name ); ?></span>
									<?php endforeach; ?>
								</div>
							<?php endif; ?>
						</div>
					</<?php echo esc_html( $card_tag ); ?>>
					<?php
				endwhile;
				wp_reset_postdata();
			endif;
			?>

			<p class="pfld-no-results" hidden><?php esc_html_e( 'No research organizations match your query.', 'pitchfork-lab-directory' ); ?></p>
		</div>

		<aside class="pfld-filters" aria-label="<?php esc_attr_e( 'Filter research lab results', 'pitchfork-lab-directory' ); ?>">
			<h2><?php esc_html_e( 'Filter the results.', 'pitchfork-lab-directory' ); ?></h2>

			<?php if ( $show_search ) : ?>
				<div class="pfld-filter-group pfld-filter-search">
					<label for="<?php echo esc_attr( $block_id ); ?>-search" class="screen-reader-text"><?php esc_html_e( 'Search research labs', 'pitchfork-lab-directory' ); ?></label>
					<input id="<?php echo esc_attr( $block_id ); ?>-search" class="pfld-search" type="search" placeholder="<?php esc_attr_e( 'Search ...', 'pitchfork-lab-directory' ); ?>">
				</div>
			<?php endif; ?>

			<?php if ( $show_area_filters && ! empty( $filter_terms ) ) : ?>
				<fieldset class="pfld-filter-group">
					<legend><?php esc_html_e( 'Research Areas', 'pitchfork-lab-directory' ); ?></legend>
					<?php foreach ( $filter_terms as $term ) : ?>
						<?php $term_id = $block_id . '-area-' . sanitize_html_class( $term->slug ); ?>
						<div class="pfld-checkbox-row">
							<input id="<?php echo esc_attr( $term_id ); ?>" class="pfld-area-filter" type="checkbox" value="<?php echo esc_attr( sanitize_title( $term->slug ) ); ?>">
							<label for="<?php echo esc_attr( $term_id ); ?>"><?php echo esc_html( $term->name ); ?></label>
						</div>
					<?php endforeach; ?>
				</fieldset>
			<?php endif; ?>

			<button class="btn btn-maroon pfld-reset" type="button"><?php esc_html_e( 'Reset', 'pitchfork-lab-directory' ); ?></button>
		</aside>
	</div>
</div>
