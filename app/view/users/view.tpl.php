<div class="displayOfUser">
    <?php if($this->di->user->getUserAcronym() == $user->acronym ||  $this->di->user->isAdmin()) : ?>
    <div class="links">
        <a href="<?=$this->url->create('users/update/' . $user->id) ?>">update </a>
        <?php if($this->di->user->isAdmin() && $user->acronym != 'jejd14') : ?>
            <?php if(!isset($user->active)) : ?>
            <a href="<?=$this->url->create('users/activate/' . $user->id) ?>">[activate] </a>
            <?php else: ?>
            <a href="<?=$this->url->create('users/deactivate/' . $user->id) ?>">[deactivate] </a>
            <?php endif; ?>
            <?php if(!isset($user->deleted)) : ?>
            <a href="<?=$this->url->create('users/soft-delete/' . $user->id) ?>">[trash] </a>
            <?php else: ?>
            <a href="<?=$this->url->create('users/soft-undelete/' . $user->id) ?>">[untrash] </a>
            <?php endif; ?>
            <a href="<?=$this->url->create('users/delete/' . $user->id) ?>">[remove] </a></td>
        <?php endif; ?>
    </div>
    <?php endif; ?>
    <div class='main-user'>
        <div class='main-information-user'>
            <figure style='width:100px;overflow:auto;margin-bottom:0;' class='left'>
                <img src="http://www.gravatar.com/avatar/<?=$user->gravatar?>?s=100" />
            </figure>
            <main style='margin-left:22px;'>
                <p style='font-size:22px;margin-bottom:11px'><i class="fa fa-user"></i> <?=$user->acronym?> <span class='right'>| <i class="fa fa-star"></i> <?=$user->reputation?> | <i class="fa fa-clock-o"></i> <?=$user->active_value?><span></p>
                <p style='margin-bottom:11px;'><?=$title?>, <i class="fa fa-at"></i> <?=$user->email?></p>
                <p style='margin-bottom:0;'>Joined GameQuest
                    <span style='color:#3B596A;'><time class='timeago' datetime="<?=$user->created?>"></time></span>
                    <?php if(isset($user->updated)) : ?>
                    , Updated profile
                    <span style='color:#3B596A;'><time class='timeago' datetime="<?=$user->updated?>"></time>
                    <?php endif; ?>
                </p>
            </main>
        </div>
    </div>
</div>
<?php $this->views->render('qa')?>

<p><a href='<?=$this->url->create('users/list')?>'>Back to users...</a></p>
