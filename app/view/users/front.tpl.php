<h2>Newest Users</h2>
<?php foreach ($users as $user) : ?>
<div class='main-user-2 left' onclick="document.location = '<?=$this->url->create('users/id/' . $user->id) ?>';">
    <div class='main-information-user'>
        <figure style='width:75px;overflow:auto;margin-bottom:0;' class='left'>
            <img src="http://www.gravatar.com/avatar/<?=$user->gravatar?>?s=75" />
        </figure>
        <main style='margin-left:22px;'>
            <p class='smart-no-show' style='font-size:22px;margin-bottom:11px;padding-top:5px;'><i class="fa fa-user"></i> <?=$user->acronym?> <span>| <i class="fa fa-star"></i> <?=$user->reputation?> | <i class="fa fa-clock-o"></i> <?=$user->active_value?><span></p>
            <p class='smart-no-show' style='margin-bottom:0;'>Joined GameQuest
                <span style='color:#3B596A;'><time class='timeago' datetime="<?=$user->created?>"></time></span>
            </p>
            <p class='smart-show' style='font-size:22px;margin-bottom:11px;padding-top:22px;'><i class="fa fa-user"></i> <?=$user->acronym?></p>
        </main>
    </div>
</div>
<?php endforeach; ?>
