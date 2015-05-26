<h2><?=$title?></h2>
<ul class="fa-ul">
<?php foreach ($activities as $activity) : ?>
    <?

    $user = $this->di->user->findByAcronym($activity->acronym);

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
    <li class='user-ul'><a style='color: <?=$color?>;' href='<?=$this->url->create('questions/id/' . $activity->other_id)?>'><i class="fa <?=$activity->icon?> fa-fw"></i></a><?=ucfirst($user->name)?> <?=$activity->action_desc?> <?=$active?> <?=$reputation?></li>
    <?php else: ?>
    <li class='user-ul'><a style='color: <?=$color?>;' href='<?=$this->url->create('users/')?>'><i class="fa <?=$activity->icon?> fa-fw"></i></a><?=ucfirst($user->name)?> <?=$activity->action_desc?> <?=$active?> <?=$reputation?></li>
    <?php endif; ?>
<?php endforeach; ?>
</ul>
