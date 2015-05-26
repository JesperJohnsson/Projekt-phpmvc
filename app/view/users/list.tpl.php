<small class='right' style='color:#ccc;'><a href='?search=<?=$searchword?>&order=created+desc'>Newest</a> | <a href='?search=<?=$searchword?>&order=created'>Oldest</a> | <a href='?search=<?=$searchword?>&order=reputation+desc'>Reputation</a> | <a href='?search=<?=$searchword?>&order=active_value+desc'>Activity</a></small>
<h1><?=$title?><?if(isset($searchword)) : ?><? if(isset($searchword) && $searchword != "") { echo " : ";}?> <span style='color:#427676;'><?=ucfirst($searchword)?></span> <?endif;?></h1>
<? $e/*
<table style='width: 100%; text-align: left;padding-bottom:22px;border-bottom:1px solid #ccc;' class='table'>

<tr>
    <th><?='Acronym'?></th>
    <th><?='Name'?></th>
    <th><?='Email'?></th>
    <? if($this->di->user->isAdmin()) : ?>
    <th><?='Active'?></th>
    <th><?='Deleted'?></th>
    <? endif; ?>
</tr>

<?php foreach ($users as $user) : ?>
<tr style="cursor:pointer;" onclick="document.location = '<?=$this->url->create('users/id/' . $user->id) ?>';">
    <td><?=$user->acronym?></td>
    <td><?=$user->name?></td>
    <td><?=$user->email?></td>
    <? if($this->di->user->isAdmin()) : ?>
    <td><?=isset($user->active) ? 'Y' : 'N'?></td>
    <td><?=isset($user->deleted) ? 'Y' : 'N'?></td>
    <? endif; ?>
</tr>
<?php endforeach; ?>
</table>*/?>


<div id='tags' style='border-bottom:1px solid #ccc;margin-bottom:22px;'>
    <?=$search?>
</div>
<div class='main-user-2 left' onclick="document.location = '<?=$this->url->create('users') ?>';" style='border:1px solid #ccc;width:100%;'>
    <div class='main-information-user'>
        <figure style='width:75px;height:73px;overflow:auto;margin-bottom:0;' class='left'>
            <i class="fa fa-users" style="font-size:33px;margin-top:22px;margin-left:18px;"></i>
        </figure>
        <main>
            <p style='font-size:33px;padding-top:15px;margin-bottom: 0;'> View All</p>
        </main>
    </div>
</div>
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
