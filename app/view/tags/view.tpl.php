<small class='right' style='color:#ccc;'><a href="../../questions?order=created">Newest</a> | <a href="?order=answers">Popular</a> | <a href="?order=score">Score</a></small>
<h1><?=$title?></h1>
<?php foreach ($questions as $question) : ?>
    <?php if($question->question_id == 0) : ?>
        <a href='<?=$this->url->create('questions/id/' . $question->id)?>'>
            <div class='list-question'>
                <?php
                $userWhoAsked = $this->user->findByAcronym($question->acronym);
                $url = $this->url->create('users/id/'. $userWhoAsked->id);
                $answers = $question->answers;
                if ($question->answers == 0) {
                    $answers .= " 0 Answers";
                } elseif($question->answers == 1) {
                    $answers .= " Answer";
                } else {
                    $answers .= " Answers";
                }
                ?>
                <h3><?=$question->title?></h3>
                <div id='tags'>
                    <?php $tags = explode(',', $question->tag); ?>
                    <?php foreach($tags as $tag) : ?>
                        <a href='<?=$this->url->create('questions/tagged/' . $tag)?>'>
                            <div class='tag'>
                                <p><i class="fa fa-tag"></i> <?=$tag?></p>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
                <div id='list-question-bottom' class='clear'>
                    <p style='margin-bottom:0;'><?=$answers ?> | Asked by <a href='<?=$url?>'><?=$question->acronym?></a> on <?=$question->created?></p>
                </div>
            </div>
        </a>
    <?php endif; ?>
<?php endforeach;?>
