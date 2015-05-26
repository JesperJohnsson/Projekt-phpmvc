<?php  if (is_array($comments)) : ?>

<?php
$comments = array_reverse($comments, true);
foreach ($comments as $id => $comment) :
    $comment = $comment->getProperties();
    extract($comment);

    $edit = null;
    $remove = null;
    if ($this->di->user->getUserAcronym() == $acronym) {
        $url = $this->url->create('questions/updatecomment/' . $id);
        $edit = "- <a href={$url} title='Update Comment'><i class='fa fa-pencil'></i></a>";
        $url = $this->url->create('questions/deletecomment/' . $id);
        $remove = "- <a href={$url} title='Delete Comment'><i class='fa fa-remove'></i></a>";
    }
?>

<div class='comment'>
    <?php $content = $this->textFilter->doFilter($content, 'shortcode, markdown, bbcode'); ?>
    <p class='content'><?=$content?> – <a href="#"><?= $acronym?></a><small> <time class='timeago' datetime="<?=$created?>"></time>  <?php if(isset($updated)){echo '- Edited ' . '<time class="timeago" datetime="$question->created"></time>';} ?> <?=$edit?> <?=$remove?></small></p>
</div>

<?php
endforeach;
endif;
?>
