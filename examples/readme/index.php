<?php

include_once '../../library/Aste/Template.php';                                                                                                                                                 
include_once '../../library/Aste/Block.php';
include_once '../../library/Aste/Block/Parser.php';
include_once '../../library/Aste/Exception.php';

$template = new Aste_Template('template.tpl');

$news = $template->getBlock('news');
$news->display();

for($i = 1; $i < 6; $i++) {
    $newslist = $news->getBlock('newslist', true);
    $newslist->setVar('content', 'News ' . $i);
    $newslist->setVar('publication_date', date('d-m-Y', time()));
    $newslist->setVar('author', 'Anonymous');
}

echo $template->fetch();
