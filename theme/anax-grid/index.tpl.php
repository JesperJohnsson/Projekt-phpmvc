<!doctype html>
<html class='no-js' lang='<?=$lang?>'>
<head>
<meta charset='utf-8'/>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?=$title . $title_append?></title>
<?php if(isset($favicon)): ?><link rel='icon' href='<?=$this->url->asset($favicon)?>'/><?php endif; ?>
<?php foreach($stylesheets as $stylesheet): ?>
<link rel='stylesheet' type='text/css' href='<?=$this->url->asset($stylesheet)?>'/>
<?php endforeach; ?>
<?php if(isset($style)): ?><style><?=$style?></style><?php endif; ?>
<script src='<?=$this->url->asset($modernizr)?>'></script>
</head>

<body>
<?php if($this->views->hasContent('header')) : ?>
<div id='header'><?php $this->views->render('header')?></div>
<?php endif; ?>

<?php if ($this->views->hasContent('navbar')) : ?>
<div id='wrapper-navbar'>
    <div id='navbar'>
    <?php $this->views->render('navbar')?>
    </div>
</div>
<?php endif; ?>

<?php if ($this->views->hasContent('sidebar-left')) : ?>
<div id='sidebar-left'>
<?php $this->views->render('sidebar-left')?>
</div>
<?php endif; ?>

<div id='wrapper'>

<?php if ($this->views->hasContent('flash')) : ?>
<div id='flash'><?php $this->views->render('flash')?></div>
<?php endif; ?>

<?php if ($this->views->hasContent('featured-1', 'featured-2', 'featured-3')) : ?>
<div id='wrap-featured'>
    <?php if ($this->views->hasContent('wrap-featured')) : ?>
        <?php $this->views->render('wrap-featured')?>
    <?php endif; ?>
    <div id='featured-1'><?php $this->views->render('featured-1')?></div>
    <div id='featured-2'><?php $this->views->render('featured-2')?></div>
    <div id='featured-3'><?php $this->views->render('featured-3')?></div>
</div>
<?php endif; ?>


<?php if ($this->views->hasContent('main')) : ?>
<div id='wrap-main'>
    <div id='main'>
        <?php $this->views->render('main')?>
        <?php if($this->views->hasContent('byline')) : ?>
        <div class='byline'><?php $this->views->render('byline')?></div>
        <?php endif; ?>
    </div>
    <?php if($this->views->hasContent('sidebar')) : ?>
    <div id='sidebar' ><?php $this->views->render('sidebar')?></div>
    <?php endif; ?>
</div>
<?php endif; ?>


<?php if ($this->views->hasContent('triptych-1', 'triptych-2', 'triptych-3')) : ?>
<div id='wrap-triptych'>
    <div id='triptych-1'><?php $this->views->render('triptych-1')?></div>
    <div id='triptych-2'><?php $this->views->render('triptych-2')?></div>
    <div id='triptych-3'><?php $this->views->render('triptych-3')?></div>
</div>
<?php endif; ?>
</div>

<?php if($this->views->hasContent('comment-form')) : ?>
<div id='wrapper-comments-form'>
    <div id='comment-form'>
    <?php $this->views->render('comment-form')?>
    </div>
</div>
<?php endif; ?>

<?php if($this->views->hasContent('wrap-comment')) : ?>
<div id='wrapper-comments'>
    <div id='wrap-comment'>
    <?php $this->views->render('wrap-comment')?>
    </div>
</div>
<?php endif; ?>


<div id='wrapper-bottom'>
<div id='wrap-footer'>
    <?php if ($this->views->hasContent('footer-col-1', 'footer-col-2', 'footer-col-3')) : ?>
    <div id='wrap-footer-col'>
        <div id='footer-col-1'><?php $this->views->render('footer-col-1')?></div>
        <div id='footer-col-2'><?php $this->views->render('footer-col-2')?></div>
        <div id='footer-col-3'><?php $this->views->render('footer-col-3')?></div>
    </div>
    <?php endif; ?>

    <?php if($this->views->hasContent('footer')) : ?>
    <div id='footer'><?php $this->views->render('footer')?></div>
    <?php endif; ?>
    </div>
</div>



<?php if(isset($jquery)):?><script src='<?=$this->url->asset($jquery)?>'></script><?php endif; ?>

<?php if(isset($javascript_include)): foreach($javascript_include as $val): ?>
<script src='<?=$this->url->asset($val)?>'></script>
<?php endforeach; endif; ?>

<?php if(isset($google_analytics)): ?>
<script>
  var _gaq=[['_setAccount','<?=$google_analytics?>'],['_trackPageview']];
  (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
  g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
  s.parentNode.insertBefore(g,s)}(document,'script'));
</script>
<?php endif; ?>

</body>
</html>
