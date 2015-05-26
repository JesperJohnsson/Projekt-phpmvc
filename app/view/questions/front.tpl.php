<div onclick="document.location = '<?=$this->url->create('questions/id/' . $question->id) ?>';" class='featured-question'>
    <?php
    $answers = $question->answers;
    if ($question->answers == 0) {
        $answers = "0 Answers";
    } elseif ($question->answers == 1) {
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

    $userWhoAsked = $this->user->findByAcronym($question->acronym);

    ?>

    <p><strong><?=$question->title?></strong></p>
    <p><?=$score?> <?=$answers?> | Asked by <a href='<?=$this->url->create('users/id/' . $userWhoAsked->id)?>'><?=$question->acronym?></a></p>
    <?php $content = implode(' ', array_slice(explode(' ', $question->content), 0, 50)); $content .= "..."; ?>
    <p><?=$content?></p>
</div>
