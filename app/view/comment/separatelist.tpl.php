<h2>Comments</h2>
<?php foreach ($comments as $statement) : ?>
    <p>
        <a style='color: #363636;' href='<?=$this->url->create('questions/id/' . $statement->thread_id)?>'>
            <span class="fa-stack fa-lg">
                <i class="fa fa-square-o fa-stack-2x"></i>
                <i class="fa fa-comment fa-stack-1x"></i>
            </span>
        </a>
        <?php $content = implode(' ', array_slice(explode(' ', $statement->content), 0, 10)); $content .= "...."; ?>

        <a style='color: #3F9A82;' href='<?=$this->url->create('questions/id/' . $statement->thread_id)?>'><?=$statement2->title?></a> - <?=$content?> - <?=$statement->created?>
    </p>
<?php endforeach; ?>
