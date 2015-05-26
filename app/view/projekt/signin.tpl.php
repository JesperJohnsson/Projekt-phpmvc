<h1><?=$title?></h1>
<div id='input-form' class='left'>
    <?=$content?>
    <p>New user? <a href='<?=$this->url->create('signup')?>'>Sign up now!</a></p>
</div>
<div class='left information'>
    <div>
        <div class='left information-sub-1'>
            <i class="fa fa-thumbs-up fa-3x"></i>
        </div>
        <div class='left information-sub-2'>
            <p class="left">Try out our voting system and upvote your favorite answers giving other people a higher chance of seeing them aswell!</p>
        </div>
    </div>
</div>
<div class='clear'>
    <?= $this->flashMessage->get(); ?>
</div>
