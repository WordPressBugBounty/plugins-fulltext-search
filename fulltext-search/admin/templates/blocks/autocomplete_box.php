<?php

defined('ABSPATH') || exit;


/**
 * Copyright 2013-2026 Epsiloncool
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  @copyright 2013-2026
 *  @license GPLv3
 *  @package WP Fast Total Search
 */

global $wpfts_core;

if (!($wpfts_core && is_object($wpfts_core))) {
	exit();
}

$ac_limit = max(1, intval($wpfts_core->get_option('autocomplete_limit')));
$ac_minlength = max(1, intval($wpfts_core->get_option('autocomplete_minlength')));
$ac_delay = max(0, intval($wpfts_core->get_option('autocomplete_delay')));

?><div class="mb-2 mt-2 wpfts_smartform" data-name="form_autocomplete">
	<?php wp_nonce_field('wpfts_options_autocomplete', 'wpfts_options-nonce_autocomplete'); ?>
	<div class="row">
		<span class="col-9"><h5><?php echo esc_html(__('Autocomplete', 'fulltext-search')); ?></h5></span>
		<span class="col-3 text-right sf_savelink_place"></span>
	</div>
	<div class="bg-light">
		<p><?php echo esc_html(__('These settings control the live search suggestions shown by the WPFTS search widget, block and shortcode.', 'fulltext-search')); ?></p>

		<div class="row">
			<div class="col fixed-200 font-weight-bolder">
				<?php echo esc_html(__('Maximum suggestions', 'fulltext-search')); ?>
			</div>
			<div class="col fixed-150">
				<input type="number" min="1" max="50" step="1" name="wpfts_autocomplete_limit" value="<?php echo esc_attr($ac_limit); ?>" style="width: 100%;" />
			</div>
			<div class="col col-xl col-12">
				<p class="text-secondary"><i><?php echo esc_html(__('How many results the autocomplete request may return (1-50, default 10).', 'fulltext-search')); ?></i></p>
			</div>
		</div>

		<div class="row">
			<div class="col fixed-200 font-weight-bolder">
				<?php echo esc_html(__('Minimum query length', 'fulltext-search')); ?>
			</div>
			<div class="col fixed-150">
				<input type="number" min="1" max="10" step="1" name="wpfts_autocomplete_minlength" value="<?php echo esc_attr($ac_minlength); ?>" style="width: 100%;" />
			</div>
			<div class="col col-xl col-12">
				<p class="text-secondary"><i><?php echo esc_html(__('Do not send an autocomplete request until the visitor has typed this many characters (1-10, default 3).', 'fulltext-search')); ?></i></p>
			</div>
		</div>

		<div class="row">
			<div class="col fixed-200 font-weight-bolder">
				<?php echo esc_html(__('Debounce delay, ms', 'fulltext-search')); ?>
			</div>
			<div class="col fixed-150">
				<input type="number" min="0" max="5000" step="50" name="wpfts_autocomplete_delay" value="<?php echo esc_attr($ac_delay); ?>" style="width: 100%;" />
			</div>
			<div class="col col-xl col-12">
				<p class="text-secondary"><i><?php echo esc_html(__('Wait this many milliseconds after the last keystroke before sending a request (0-5000, default 500).', 'fulltext-search')); ?></i></p>
			</div>
		</div>

		<div class="sf_savebtn_place"></div>
	</div>
</div>
