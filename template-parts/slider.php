<?php
	$eventID = $args['eventID'];
	$exhibitionTitle = get_field('exhibition_name', $eventID);
	$artist = get_field('artist', $eventID);
	$artistSplit = explode(' ', $artist);
	$dateBeforeText = get_field('date_before_text', $eventID);
	$dateFrom = get_field('date_from', $eventID);
	$dateFromYear = DateTime::createFromFormat('d.m.Y', $dateFrom)->format('Y');
	$dateTo = get_field('date_to', $eventID);
	$dateToYear = $dateTo ? DateTime::createFromFormat('d.m.Y', $dateTo)->format('Y') : null;
	$dateFromWithOrWithoutY = $dateTo ? ($dateFromYear == $dateToYear ? DateTime::createFromFormat('d.m.Y', $dateFrom)->format('d.m') : $dateFrom) : $dateFrom;
	$showAt = get_field('show_top_title_from_n_slide', $eventID);
	$slide = get_post_meta($eventID, 'slide', true);
	$numberOfSlide = count($slide) + 1;
	$prevPostPermalink = null;
	$nextPostPermalink = null;

	$thisEventDate = DateTime::createFromFormat('d.m.Y', $dateFrom)->format('Y-m-d');

	$prevArgs = array(
		'post_type'   => 'events',
		'meta_key' => 'date_from',
		'posts_per_page' => 1,
		'orderby' => 'meta_value_num',
		'order' => 'DESC',
		'meta_query' => array(
			array(
				'key' => 'date_from',
				'compare' => '<',
				'value' => $thisEventDate,
				'type' => 'DATE'
			)
		),
	);

	$nextArgs = array(
		'post_type'   => 'events',
		'meta_key' => 'date_from',
		'posts_per_page' => 1,
		'orderby' => 'meta_value_num',
		'order' => 'ASC',
		'meta_query' => array(
			array(
				'key' => 'date_from',
				'compare' => '>',
				'value' => $thisEventDate,
				'type' => 'DATE'
			)
		),
	);

	$previousEvent = new WP_Query($prevArgs);
	$nextEvent = new WP_Query($nextArgs);
	// $numberOfSlide = $previousEvent->have_posts() ? $numberOfSlide + 1 : $numberOfSlide;

	if ($previousEvent->have_posts()) : while ($previousEvent->have_posts()) : $previousEvent->the_post();
		$prevPostPermalink = get_permalink($post->ID);
	endwhile; endif; wp_reset_postdata();

	if ($nextEvent->have_posts()) : while ($nextEvent->have_posts()) : $nextEvent->the_post();
		$nextPostPermalink = get_permalink($post->ID);
	endwhile; endif; wp_reset_postdata();
?>

<div class="slider" data-previous-event="<?php echo $prevPostPermalink; ?>" data-next-event="<?php echo $nextPostPermalink; ?>">
	<div class="slider__list">

		<div class="slide slide--active">
			<div class="slide__layer slide__layer--title">
				<div class="title">
					<h1>
						<?php if ($exhibitionTitle) : ?>
							<span class="title__title"><?php echo $exhibitionTitle; ?></span>
						<?php endif; ?>
						<?php if ($artist) : ?>
							<span class="title__artist">
								<?php
								foreach ($artistSplit as $word) {
									echo ' <span>' . $word . '</span>';
								}
								?>
							</span>
						<?php endif; ?>
					</h1>
					<div class="title__time">
						<?php if ($dateBeforeText) : ?>
							<span><?php echo $dateBeforeText; ?></span>
						<?php endif; ?>
						<?php if ($dateFrom) : ?>
							<time datetime=""><?php echo $dateFromWithOrWithoutY; ?></time>
						<?php endif; ?>
						<?php if ($dateTo) : ?>
							&nbsp;–&nbsp;
							<time datetime=""><?php echo $dateTo; ?></time>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>

		<?php if (have_rows('slide', $eventID)) : ?>
			<?php while (have_rows('slide', $eventID)) : the_row(); ?>
				<div class="slide">
					<?php if (have_rows('layer')) : ?>
						<?php while (have_rows('layer')) : the_row();
							$type = get_sub_field('type');
							$rotation = get_sub_field('rotation') ? get_sub_field('rotation') . 'deg' : '0';
							$translateX = get_sub_field('translate_x') ? get_sub_field('translate_x') . 'px' : '0';
							$translateY = get_sub_field('translate_y') ? get_sub_field('translate_y') . 'px' : '0';
							$scale = get_sub_field('scale') ? get_sub_field('scale') : '1';
							$opacity = get_sub_field('opacity') ? get_sub_field('opacity') : '1';
							$blur = get_sub_field('blur') ? get_sub_field('blur') . 'px' : '0';
						?>

							<?php if ($type == 'media') :
								$mediaSizeClass = 'media--' . get_sub_field('media_size');
								$image = get_sub_field('image');
								$video = get_sub_field('video');
							?>

								<div class="slide__layer slide__layer--media">
									<div class="media <?php echo $mediaSizeClass; ?>" style="--rotation: <?php echo $rotation; ?>; --x: <?php echo $translateX ?>; --y: <?php echo $translateY ?>; --scale: <?php echo $scale; ?>; --opacity: <?php echo $opacity; ?>; --blur: <?php echo $blur; ?>">
										<?php if ($image) : ?>
											<img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
										<?php elseif ($video) : ?>
											<video muted loop playsinline>
												<source src="<?php echo $video['url']; ?>" type="video/mp4">
											</video>
										<?php endif; ?>
									</div>
								</div>

							<?php elseif ($type == 'text') :
								$text = get_sub_field('text');
								$fontSizeClass = 'text--fs-' . get_sub_field('font_size');
								$textWidthClass = 'text--w-' . get_sub_field('text_width');
								$textAlignmentClass = 'text-' . get_sub_field('text_alignment');
							?>
								<div class="slide__layer slide__layer--text">
									<div class="text <?php echo $textWidthClass;
														echo ' ' . $fontSizeClass;
														echo ' ' . $textAlignmentClass; ?>">
										<div>
											<?php echo $text; ?>
										</div>
									</div>
								</div>
							<?php elseif ($type == 'title') : ?>

								<div class="slide__layer slide__layer--title">
									<div class="title">
										<h1>
											<?php if ($exhibitionTitle) : ?>
												<span class="title__title"><?php echo $exhibitionTitle; ?></span>
											<?php endif; ?>
											<?php if ($artist) : ?>
												<span class="title__artist">
													<?php
													foreach ($artistSplit as $word) {
														echo ' <span>' . $word . '</span>';
													}
													?>
												</span>
											<?php endif; ?>
										</h1>
										<div class="title__time">
											<?php if ($dateBeforeText) : ?>
												<span><?php echo $dateBeforeText; ?></span>
											<?php endif; ?>
											<?php if ($dateFrom) : ?>
												<time datetime=""><?php echo $dateFromWithOrWithoutY; ?></time>
											<?php endif; ?>
											<?php if ($dateTo) : ?>
												&nbsp;–&nbsp;
												<time datetime=""><?php echo $dateTo; ?></time>
											<?php endif; ?>
										</div>
									</div>
								</div>

							<?php endif; ?>
						<?php endwhile; ?>
					<?php endif; ?>
				</div>
			<?php endwhile; ?>
		<?php endif; ?>





	</div>
	<div class="slider__nav">
		<button class="prev-next prev-next--prev"></button>
		<button class="prev-next prev-next--next"></button>
	</div>
	<div class="slider__index">
		<span class="slider__index__current">1</span>/<span class="slider__index__all"><?php echo $numberOfSlide; ?></span>
	</div>
	<div class="top-event" data-show-at="<?php echo $showAt; ?>">
		<h1>
			<?php if ($exhibitionTitle) : ?>
				<span class="top-event__title"><?php echo $exhibitionTitle; ?></span>
			<?php endif; ?>
			<?php if ($artist) : ?>
				<span class="top-event__artist"><?php echo $artist; ?></span>
			<?php endif; ?>
		</h1>
		<div class="top-event__time">
			<?php if ($dateBeforeText) : ?>
				<span><?php echo $dateBeforeText; ?></span>
			<?php endif; ?>
			<?php if ($dateFrom) : ?>
				<time datetime=""><?php echo $dateFromWithOrWithoutY; ?></time>
			<?php endif; ?>
			<?php if ($dateTo) : ?>
				&nbsp;–&nbsp;
				<time datetime=""><?php echo $dateTo; ?></time>
			<?php endif; ?>
		</div>
	</div>

</div>