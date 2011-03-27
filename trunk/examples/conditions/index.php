<?php

include_once '../../library/Aste/Template.php';
include_once '../../library/Aste/Block.php';
include_once '../../library/Aste/Block/Parser.php';
include_once '../../library/Aste/Exception.php';

$someContent = 'This is sample article';
$publicationDate = date('d-m-Y', time());
$author = '';

$template = new Aste_Template('template.tpl');

$content = $template->getBlock('content');
if ($someContent != '') {

    $content->setVar('content', $someContent);
    $content->display(true);

    $publicationDateBlock = $content->getBlock('publication_date');

    if ($publicationDate != '') {

        $publicationDateBlock->setVar('publication_date', $publicationDate);
        $publicationDateBlock->display();
    }

    $authorBlock = $content->getBlock('author');
    if ($author != '') {

        $authorBlock->setVar('author', $author);
        $authorBlock->display();
    } 
}

echo $template->fetch();
