<div id='header-container'>
    <div id='header-sub-container'>
        <a href='<?=$this->url->create('')?>' class='logo'>GameQuest</a>
        <?php if($this->di->user->isAuthenticated()) : ?>
            <div id='user-gravatar'>
                <img src='<?='http://www.gravatar.com/avatar/' . $this->di->user->getUserGravatar() . "?s=30";?>'>
            </div>
        <?php endif; ?>
        <?php if(!$this->di->user->isAuthenticated()) : ?>
        <div id='user-bar'>
        <?php else : ?>
        <div id='user-bar2'>
        <?php endif; ?>
        <?php if(!$this->di->user->isAuthenticated()) : ?>
            <a href='<?= $this->url->create("signin") ?>' class='text-sign '> Sign in</a>
            <span> | </span>
            <a href='<?= $this->url->create("signup") ?>' class='text-sign'>Sign up</a>
        <?php else : ?>
            <div class='navbar'>
                <ul>
                    <li class='no-border'>
                        <a class='text-sign no-padding default-mouse' id='user-acronym'><?= ucfirst($this->di->user->getUserAcronym()) ?></a>
                    <ul class='smart-no-show'>
                        <li><a href='<?= $this->url->create("users/id/" . $this->di->user->getUserId()) ?>'>Profile</a></li>
                        <?php if($this->di->user->isAdmin()) : ?>
                        <li><a href='<?= $this->url->create('') ?>'>Administrative</a></li>
                        <?php endif; ?>
                        <li><a href='<?= $this->url->create("users/logout") ?>'>Sign out</a></li>
                    </ul>
                </li>
            </div>
        </div>
    <?php endif; ?>
    </div>
    </div>
</div>
<?php if($this->di->user->isAuthenticated()) : ?>
<div id='header-container-2' class='smart-show clear' style='overflow:auto;margin-top:22px;'>
    <div class='smart-show right '>
        <ul>
            <li class='inline' style='margin-right: 22px;'><a href='<?= $this->url->create("users/id/" . $this->di->user->getUserId()) ?>'>Profile</a></li>
            <?php if($this->di->user->isAdmin()) : ?>
            <li class='inline' style='margin-right: 22px;'><a href='<?= $this->url->create('') ?>'>Administrative</a></li>
            <?php endif; ?>
            <li class='inline' style='margin-right: 22px;'><a href='<?= $this->url->create("users/logout") ?>'>Sign out</a></li>
        </ul>
    </div>
</div>
<?php endif; ?>
