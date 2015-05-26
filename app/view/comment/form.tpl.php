<div class='comment-form' id='comments'>
    <form method=post>
        <input type=hidden name="redirect" value="<?=$this->url->create($pageId)?>">
        <input type=hidden name="pageId" value="<?=$pageId?>">
        <p class='toggler'><label><strong>Comment:</strong><br/><textarea placeholder=' Join the dicsussion...' rows="2" cols="60" name='content' id='content'><?=$content?></textarea></label></p>
        <div class='hidden'>
            <p><label><small><strong>Name:</strong></small><br/><input type='text' name='name' value='<?=$name?>'/></label></p>
            <p><label><small><strong>Homepage:</strong></small><br/><input type='text' name='web' value='<?=$web?>'/></label></p>
            <p><label><small><strong>Email:</strong></small><br/><input type='text' name='mail' value='<?=$mail?>'/></label></p>
            <p class=buttons>
                <?php if (!isset($id)): ?>
                    <input type='submit' name='doCreate' value='Comment' onClick="this.form.action = '<?=$this->url->create('comment/add')?>'"/>
                    <!--<input type='reset' value='Reset'/>-->
                    <input type='submit' name='doRemoveAll' value='Remove all' onClick="this.form.action = '<?=$this->url->create('comment/remove-all')?>'"/>
                <?php else: ?>
                    <input type='submit' name='doEdit' value='Edit comment' onClick="this.form.action = '<?=$this->url->create('comment/edit') . '?id=' . $id?>'"/>
                <?php endif; ?>
            </p>
        </div>
        <output><?=$output?></output>
    </form>
</div>
