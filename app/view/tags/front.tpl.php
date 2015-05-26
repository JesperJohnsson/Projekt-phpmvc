<h2 style='margin-bottom:0;'><?=$title?></h2>
<div id='tags-wrapper'>
<?php foreach ($tags as $tag) : ?>
    <?php if ($tag->amount > 0) : ?>
        <a href='<?=$this->url->create('questions/tagged/' . strtolower($tag->tag_description))?>'>
            <div class='tag'>
                <p><i class="fa fa-tag"></i> <?=$tag->tag_description?> </p>
            </div>
        </a>
    <?php endif; ?>
<?php endforeach;?>
</div>
