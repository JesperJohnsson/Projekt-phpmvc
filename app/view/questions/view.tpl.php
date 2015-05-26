<?php if (isset($question->bounty)) : ?>
    <?php $this->di->flashMessage->warning("This question has a bounty set of " . $question->bounty . " Reputation, claim it by getting the accepted answer or by giving the most upvoted answer before the bounty time expires, this bounty expires in <time class='timeago' datetime='$question->bountytime'></time>!") ?>
    <?php echo "<p>" . $this->di->flashMessage->get() . "</p>"; ?>
<?php endif;?>

<small class='right'> <a href="<?=$this->url->create("questions")?>">Back to questions</a></small>
<h1><?=$title?></h1>
<div class='question'>
    <?php
    $userWhoAsked = $this->user->findByAcronym($question->acronym);
    $url = $this->url->create('users/id/'. $userWhoAsked->id);

    $edit = null;
    $remove = null;
    $bounty = null;
    if ($this->di->user->getUserAcronym() == $userWhoAsked->acronym) {
        if (!isset($question->bounty) && !isset($question->accepted)) {
            $url2 = $this->url->create('questions/bounty/' . $question->id);
            $bounty = "- <a href={$url2} title='Set Bounty'><i class='fa fa-dollar'></i>bounty </a>";
        }
        $url2 = $this->url->create('questions/updatequestion/' . $question->id);
        $edit = "- <a href={$url2} title='Update Question'><i class='fa fa-pencil'></i> update </a>";
        $url2 = $this->url->create('questions/deletequestion/' . $question->id);
        $remove = "- <a href={$url2} title='Delete Question'><i class='fa fa-remove'></i> delete </a>";
    }
    ?>
    <div class='container'>
        <div class='vote left'>
            <?php if($this->di->user->isAuthenticated()) : ?>
            <a href='<?=$this->url->create('questions/upvote/' . $question->id)?>'><i class="fa fa-arrow-up fa-2x"></i></a>
            <p style='margin-bottom:0;margin-left:8px;font-size:25px;'><?=$question->score?></p>
            <a href='<?=$this->url->create('questions/downvote/' . $question->id)?>'><i class="fa fa-arrow-down fa-2x"></i></a>
            <?php else : ?>
            <i class="fa fa-arrow-up fa-2x"></i>
            <p style='margin-bottom:0;margin-left:8px;font-size:25px;'><?=$question->score?></p>
            <i class="fa fa-arrow-down fa-2x"></i>
            <?php endif; ?>
        </div>
        <div class='question-main'>
            <img class='gavatar' src="http://www.gravatar.com/avatar/<?=$userWhoAsked->gravatar?>?s=80" />
            <?php $content = $this->textFilter->doFilter($question->content,'shortcode, markdown, bbcode'); ?>
            <p style='margin-bottom:11px;'><?=$content?></p>
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
            <p class='clear'>Asked by <a href='<?=$url?>'><?=$question->acronym?></a> - <time class='timeago' datetime="<?=$question->created?>"></time> <?=$bounty?> <?=$edit?> <?=$remove?></p>
        </div>
    </div>
    <div class='comments' id='CW<?=$question->id?>' >
        <?php $this->views->render('CW' . $question->id)?>
    </div>
    <label class="collapse" for="C<?=$question->id?>"><i class="fa fa-comment-o"></i> Add a comment</label>
    <?php if($this->di->user->isAuthenticated()) : ?>
    <input id="C<?=$question->id?>" type="checkbox">
    <div class='comments-form'><?php $this->views->render('C' . $question->id)?></div>
    <?php endif; ?>
</div>
<small class='right' style='color:#ccc;'> <a href="<?=$this->url->create("questions/id/" . $question->id . "?order=created+asc")?>">Newest</a> | <a href="<?=$this->url->create("questions/id/" . $question->id . "?order=created+desc")?>">Oldest</a> | <a href="<?=$this->url->create("questions/id/" . $question->id . "?order=score")?>">Score</a></small>
<?php
$appendToAnswer = null;
if (isset($orderofanswers)) {
    if ($orderofanswers == "created asc") {
        $appendToAnswer = "(Newest)";
    } elseif ($orderofanswers == "created desc") {
        $appendToAnswer = "(Oldest)";
    } elseif ($orderofanswers == "score") {
        $appendToAnswer = "(Highest score)";
    }
}
?>
<h2 style='margin-bottom:0;'>Answers <small style='color:#427676;'><?=$appendToAnswer?></small></h2>
<?php if (!empty($questions)) : ?>
<?php $questions = array_reverse($questions, true); ?>
<?php foreach ($questions as $answer) : ?>
    <?php if ($answer->question_id == $question->id) : ?>
        <div class='answer'>
            <?php
            $content = $this->textFilter->doFilter($answer->content, 'shortcode, markdown, bbcode');
            $userWhoAnswered = $this->user->findByAcronym($answer->acronym);
            $url = $this->url->create('users/id/'. $userWhoAnswered->id);

            $edit = null;
            $remove = null;
            $accepted = null;

            if ($this->di->user->getUserAcronym() == $question->acronym) {
                if ($this->di->user->getUserAcronym() != $answer->acronym) {
                    $url2 = $this->url->create('questions/setaccepted/' . $answer->id);
                    $accepted = "- <a href={$url2} title='Accept Answer'><i class='fa fa-check'></i> accept answer </a>";
                    if (isset($question->accepted) && $question->accepted == $answer->id) {
                        $url2 = $this->url->create('questions/unsetaccepted/' . $answer->id);
                        $accepted = "- <a href={$url2} title='Accept Answer'><i class='fa fa-check'></i> reject answer </a>";
                    }
                }
            }

            if ($this->di->user->getUserAcronym() == $userWhoAnswered->acronym) {


                $url2 = $this->url->create('questions/updateanswer/' . $answer->id);
                $edit = "- <a href={$url2} title='Update Answer'><i class='fa fa-pencil'></i> update </a>";

                $url2 = $this->url->create('questions/deleteanswer/' . $answer->id);
                $remove = "- <a href={$url2} title='Delete Answer'><i class='fa fa-remove'></i> delete </a>";
            }
            ?>
            <div class='container'>
                <div class='vote left'>
                    <?php if($this->di->user->isAuthenticated()) : ?>
                    <a href='<?=$this->url->create('questions/upvote/' . $answer->id)?>'><i class="fa fa-arrow-up fa-2x"></i></a>
                    <p style='margin-bottom:0;margin-left:8px;font-size:25px;'><?=$answer->score?></p>
                    <a href='<?=$this->url->create('questions/downvote/' . $answer->id)?>'><i class="fa fa-arrow-down fa-2x"></i></a>
                    <?php else : ?>
                    <i class="fa fa-arrow-up fa-2x"></i>
                    <p style='margin-bottom:0;margin-left:8px;font-size:25px;'><?=$answer->score?></p>
                    <i class="fa fa-arrow-down fa-2x"></i>
                    <?php endif; ?>
                    <?php if(isset($question->accepted)) : ?>
                        <?php if($question->accepted == $answer->id) : ?>
                            <div class='answer-accepted'><i class="fa fa-check fa-2x"></i></div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
                <div class='answer-main'>
                    <img class='gavatar' src="http://www.gravatar.com/avatar/<?=$userWhoAnswered->gravatar?>?s=80" />
                    <p><?=$content?></p>
                    <p style='margin-bottom:11px;'>Answered by <a href='<?=$url?>'><?=$answer->acronym?></a> - <time class='timeago' datetime="<?=$answer->created?>"></time> <?=$accepted?> <?=$edit?>  <?=$remove?></p>
                </div>

                <div class='comments' id='CW<?=$answer->id?>' >
                    <?php $this->views->render('CW' . $answer->id)?>
                </div>
            </div>
            <label class="collapse" for="C<?=$answer->id?>"><i class="fa fa-comment-o"></i> Add a comment</label>
            <?php if ($this->di->user->isAuthenticated()) : ?>
            <input id="C<?=$answer->id?>" type="checkbox">
            <div class='comments-form'><?php $this->views->render('C' . $answer->id)?></div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
<?php endforeach;?>
<?php else : ?>
<?php if ($this->di->user->isAuthenticated()) {
        $this->di->flashMessage->clear();
        $this->di->flashMessage->notice("This question doesn't seem to have any answers. Do you think you know the answer? If so what are you waiting for?");
        echo "<p>" . $this->di->flashMessage->get() . "</p>";
        $this->di->flashMessage->clear();
    } ?>
<?php endif; ?>
<?php if (!$this->di->user->isAuthenticated()) {
    $signin = $this->url->create('signin');
    $signup = $this->url->create('signup');
    $this->di->flashMessage->clear();
    if (isset($question->accepted)) {
        $this->di->flashMessage->notice("Do you think you can give a better answer to this question? <a href={$signin}>Sign in</a> to answer or comment. Don't got a account yet? <a href={$signup}>Sign up</a> here!");
    } else {
        $this->di->flashMessage->notice("Do you know the answer to this question? <a href={$signin}>Sign in</a> to answer or comment. Don't got a account yet? <a href={$signup}>Sign up</a> here!");
    }

    echo "<p>" . $this->di->flashMessage->get() . "</p>";
    $this->di->flashMessage->clear();
}
