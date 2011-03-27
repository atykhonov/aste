<?php

include_once '../../library/Aste/Template.php';                                                                                                                                                 
include_once '../../library/Aste/Block.php';
include_once '../../library/Aste/Block/Parser.php';
include_once '../../library/Aste/Exception.php';

$template = new Aste_Template('template2.tpl');

$category = $template->getBlock('category');
$category->display();
$category->setVar('name', 'root');
$category->rloop();
$child = $category->getBlock('category');
$child->setVar('name', 'child');
$child->display();

echo $template->fetch();
