<?php if($value->acronym == $this->di->user->getUserAcronym()) : ?>
<small class='right'><a href='<?=$this->url->create('questions/id/' . $value->thread_id  . '#CW' . $value->id)?>'> Back to Question</a></small>
<h1><?=$title?></h1>
<?=$content?>
<?php else : ?>
<?php $this->response->redirect($this->url->create('questions/id/' . $value->thread_id)) ?>
<?php endif; ?>
