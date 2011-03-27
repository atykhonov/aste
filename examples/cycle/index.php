<?php

include_once '../../library/Aste/Template.php';
include_once '../../library/Aste/Block.php';
include_once '../../library/Aste/Block/Parser.php';
include_once '../../library/Aste/Exception.php';

$template = new Aste_Template('template.tpl');

for($i = 0; $i < 5; $i++){
    $block = $template->getBlock('news', true);
    $block->setVar('num', $i+1);

    for($k = 0; $k < 3; $k++){
        $fear = $block->getBlock('photo', true);
        $fear->setVar('n', $k+1);
    }
}

echo $template->fetch();
