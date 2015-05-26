<small class='right'><a href='?limit=all'>View All Activity</a></small>
<h2>Activities</h2>
<ul class="fa-ul">
<?php foreach ($activities as $activity) : ?>
    <?
    $reputation = null;
    if(isset($activity->reputation)) {
        $reputation = '<small style="color:green;"><i class="fa fa-star"></i> +' . $activity->reputation . '</small>';
        if($activity->reputation < 0) {
            $reputation = '<small style="color:red;"><i class="fa fa-star"></i> ' . $activity->reputation . '</small>';
        }
    }
    $active = null;
    if(isset($activity->active)) {
        $active = '<small style="color:#666;"><i class="fa fa-clock-o"></i> +' . $activity->active . '</small>';
    }

    $color = '#363636';
    if ($activity->icon == "fa fa-thumbs-o-up" || $activity->icon == "fa fa-check-circle-o") {
        $color = 'green';
    } elseif ($activity->icon == "fa fa-thumbs-o-down" || $activity->icon == "fa fa-times-circle-o") {
        $color = 'red';
    } elseif ($activity->icon == "fa fa-trophy") {
        $color = '#0066FF';
    }

    ?>
    <?php if($activity->other_id != 0) : ?>
    <li class='user-ul'><a style='color: <?=$color?>;' href='<?=$this->url->create('questions/id/' . $activity->other_id)?>'><i class="fa <?=$activity->icon?> fa-fw"></i></a><?=ucfirst($name)?> <?=$activity->action_desc?> <?=$active?> <?=$reputation?></li>
    <?php else: ?>
    <li class='user-ul'><a style='color: <?=$color?>;' href='<?=$this->url->create('users/')?>'><i class="fa <?=$activity->icon?> fa-fw"></i></a><?=ucfirst($name)?> <?=$activity->action_desc?> <?=$active?> <?=$reputation?></li>
    <?php endif; ?>
<?php endforeach; ?>
</ul>
<h2 id='questions'>Questions</h2>
<ul class="fa-ul">
<?php foreach ($questions as $statement) : ?>
    <?php if (!isset($statement->question_id)) :?>
        <li class='user-ul'>
            <a style='color: #363636;' href='<?=$this->url->create('questions/id/' . $statement->id)?>'><i class="fa fa-question-circle fa-fw"></i></a>
            <a style='color: #3F9A82;' href='<?=$this->url->create('questions/id/' . $statement->question_id)?>'><?=$statement->title?></a> - <time class='timeago' datetime="<?=$statement->created?>"></time>
        </li>
    <?php endif; ?>
<?php endforeach; ?>
</ul>
<h2 id='answers'>Answers</h2>
<ul class="fa-ul">
<?php foreach ($questions as $statement) : ?>
    <?php if (isset($statement->question_id)) :?>
        <li class='user-ul'>
            <a style='color: #363636;' href='<?=$this->url->create('questions/id/' . $statement->question_id)?>'><i class="fa fa-reply"></i></a>
            <?php $content = implode(' ', array_slice(explode(' ', $statement->content), 0, 7)); $content .= "..."; ?>
            <a style='color: #3F9A82;' href='<?=$this->url->create('questions/id/' . $statement->question_id)?>'><?=$content?></a> -  - <time class='timeago' datetime="<?=$statement->created?>"></time>
        </li>
    <?php endif; ?>
<?php endforeach; ?>
</ul>
<h2 id='comments'>Comments</h2>
<ul class="fa-ul">
<?php foreach ($comments as $statement) : ?>
    <li class='user-ul'>
        <a style='color: #363636;' href='<?=$this->url->create('questions/id/' . $statement->thread_id)?>'><i class="fa fa-comment"></i></a>
        <?php $content = implode(' ', array_slice(explode(' ', $statement->content), 0, 10)); $content .= "...."; ?>

        <a style='color: #3F9A82;' href='<?=$this->url->create('questions/id/' . $statement->thread_id . '#CW' . $statement->id)?>'><?=$content?></a> - <time class='timeago' datetime="<?=$statement->created?>"></time>
    </li>
<?php endforeach; ?>
</ul>
