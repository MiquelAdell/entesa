<header class="entry-header">
    <h2>
        <a href="<?php the_permalink(); ?>" rel="bookmark">
            <span class="date">
                <?php
                $date = DateTime::createFromFormat('d/m/Y', get_field('event_date'));
                $date = date_i18n('l j \d\e F Y',  $date->getTimestamp() ); # or $dt->format('U');
                ?>
                <?=$date ?>
            </span>
            <?php
            $time = get_field('event_time');
            if($time){
                ?>
                <span class="time">
                    <?=$time ?>
                </span>
                <?php
            }
            ?>
        </a>
    </h2>
</header>

<p><?php the_title(); ?></p>
