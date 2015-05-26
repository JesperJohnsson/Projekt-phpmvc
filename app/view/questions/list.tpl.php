<?php $url = $this->di->request->getCurrentUrl(); ?>
<?php if(!isset($back)) : ?>
<small class='right' style='color:#ccc;'><a href="?order=created+desc">Newest</a> | <a href="?order=created+asc">Oldest</a> | <a href="?order=answers+desc">Popular</a> | <a href="?order=score+desc">Score </a> </small>
<?php else : ?>
<small class='right' style='color:#ccc;'><?=$back?></small>
<?php endif; ?>

<h1 style='margin-bottom:0;'><?=$title?></h1>

<?php foreach ($questions as $question) : ?>
    <?php if($question->question_id == 0) : ?>
        <a href='<?=$this->url->create('questions/id/' . $question->id)?>'>
            <div class='list-question'>
                <small>
                    <?php
                    $userWhoAsked = $this->user->findByAcronym($question->acronym);
                    $url = $this->url->create('users/id/'. $userWhoAsked->id);
                    $answers = $question->answers;
                    if ($question->answers == 0) {
                        $answers = "0 Answers";
                    } elseif($question->answers == 1) {
                        $answers .= " Answer";
                    } else {
                        $answers .= " Answers";
                    }

                    $score = $question->score;
                    if ($score == 0) {
                        $score = null;
                    } elseif ($score > 0) {
                        $score = '<span style="color:green;">' . $score . '</span> |';
                    } else {
                        $score = '<span style="color:red;">' . $score . '</span>  |';
                    }

                    $accepted = null;
                    if (isset($question->accepted)) {
                        $accepted = '<i class="fa fa-check" style="color:green;"></i> |';
                    }

                    $bounty = null;
                    if (isset($question->bounty)) {
                        $bounty = '<i class="fa fa-dollar" style="color:orange;">' . $question->bounty . '</i> |';
                    }

                    ?>

                    <div class='container' style='overflow:hidden;'>
                        <a href='<?=$this->url->create('questions/id/' . $question->id)?>'><h3><?=$question->title?></h3></a>
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
                            <p style='margin-bottom:0;'> <?=$bounty?> <?=$accepted?> <?=$score?> <?=$answers ?> | Asked by <a href='<?=$url?>'><?=$question->acronym?></a> <time class='timeago' datetime="<?=$question->created?>"></time></p>
                        </div>
                    </div>
                </small>
            </div>
        </a>
    <?php endif; ?>
<?php endforeach;?>
