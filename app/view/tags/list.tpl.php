<h1><?=$title?><?if(isset($searchword)) : ?> : <span style='color:#427676;'><?=ucfirst($searchword)?></span> <?endif;?></h1>
<div id='tags'>
    <?=$search?>
    <div id='tags-wrapper'>
        <a href='<?=$this->url->create('tags')?>'>
            <div class='tag tag-king'>
                <p><i class="fa fa-tags"></i> View all</p>
            </div>
        </a>
    <?php foreach ($tags as $tag) : ?>
        <?php if ($tag->amount > 0) : ?>
            <?php $amount = '<small style="color:#ccc;">( ' . $tag->amount . ' )</small>'; ?>
            <a href='<?=$this->url->create('questions/tagged/' . strtolower($tag->tag_description))?>'>
                <div class='tag'>
                    <p><i class="fa fa-tag"></i> <?=$tag->tag_description?> <?=$amount?></p>
                </div>
            </a>
            <?php endif; ?>
    <?php endforeach;?>
    </div>
    <?php $this->di->flashMessage->notice('Press one of the tags to see the questions that uses it.'); ?>
    <p><?=$this->di->flashMessage->get();?></p>
    <?php $this->di->flashMessage->clear();?>
</div>
