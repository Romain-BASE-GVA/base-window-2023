<?php
    $currentEventID = get_field('current_exhibition', 'options');

    $events = get_posts( array(
        'post_type' => 'events',
        'meta_key'  => 'date_from',
        'orderby'   => 'meta_value_num',
        'order'     => 'DESC',
    ));

    if($events):
?>
<div class="window-exhibitions">
    <button class="close-window"></button>
    <div class="window__wrapper">
        <div>
            <ul class="events">
                <?php foreach( $events as $event ): 
                	$eventID = $event->ID;
                    $exhibitionTitle = get_field('exhibition_name', $eventID);
                    $artist = get_field('artist', $eventID);
                    $dateBeforeText = get_field('date_before_text', $eventID);
                    $dateFrom = get_field('date_from', $eventID);
                    $dateFromYear = DateTime::createFromFormat('d.m.Y', $dateFrom)->format('Y');
                    $dateTo = get_field('date_to', $eventID);
                    $dateToYear = $dateTo ? DateTime::createFromFormat('d.m.Y', $dateTo)->format('Y') : null;
                    $dateFrom = $dateTo ? ($dateFromYear == $dateToYear ? DateTime::createFromFormat('d.m.Y', $dateFrom)->format('d.m') : $dateFrom) : $dateFrom;
                    $onDisplayClass = $currentEventID ? ($currentEventID == $eventID ? 'event--on-display' : '') : '' ;
                ?>
                <li class="event <?php echo $onDisplayClass; ?>" data-id="<?php echo $eventID; ?>">
                    <a href="<?php echo get_permalink($eventID); ?>" title="<?php echo $artist . ' - ' . $exhibitionTitle; ?>">
                        <span class="event__time">
                            <?php if ($dateBeforeText) : ?>
                                <span><?php echo $dateBeforeText; ?></span>
                            <?php endif; ?>
                            <?php if ($dateFrom) : ?>
                                <time datetime=""><?php echo $dateFrom; ?></time>
                            <?php endif; ?>
                            <?php if ($dateTo) : ?>
                                &nbsp;–&nbsp;
                                <time datetime=""><?php echo $dateTo; ?></time>
                            <?php endif; ?>
                        </span>
                        <span class="event__artist"><?php echo $artist; ?></span>
                        <span class="event__title"><?php echo $exhibitionTitle; ?></span>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>
<?php endif; ?>