<div class='questions-bounty' style='margin-top:22px;'>
    <h2 style='margin-bottom:0;border-bottom:1px solid #ccc;' ><?=$title?></h2>
    <table class='table'>
        <?php foreach($questions as $question) : ?>
            <tr onclick="document.location = '<?=$this->url->create('questions/id/' . $question->id) ?>';"><td style='border-right:1px solid #ccc;'>Question</td><td style='width:35%;border-right:1px solid #ccc;'><?=$question->title?></td><td style='border-right:1px solid #ccc;'>Bounty is set to <?=$question->bounty?> reputation</td><td>Bounty ends in <time class='timeago' datetime="<?=$question->bountytime?>"></time></td></tr>
        <?php endforeach; ?>
    </table>
</div>
