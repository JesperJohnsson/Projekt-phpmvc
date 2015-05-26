<?php
$content = $this->fileContent->get($file);
$content = $this->textFilter->doFilter($content, 'shortcode, markdown');

?>

<?=$content;
