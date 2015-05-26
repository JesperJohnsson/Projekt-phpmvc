<?php if($value->acronym == $this->di->user->getUserAcronym()) : ?>
    <?php if(!isset($value->question_id)) : ?>
        <small class='right'><a href='<?=$this->url->create('questions/id/' . $value->id)?>'> Back to <?=$value->title?></a></small>
    <?php else : ?>
        <small class='right'><a href='<?=$this->url->create('questions/id/' . $value->question_id)?>'> Back to Question</a></small>
    <?php endif; ?>
<h1><?=$title?></h1>
<?=$content?>
<?php else : ?>
<?php $this->response->redirect($this->url->create('questions/id/' . $value->id)) ?>
<?php endif; ?>
