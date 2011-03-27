<?php

include_once '../../library/Aste/Template.php';
include_once '../../library/Aste/Block.php';
include_once '../../library/Aste/Block/Parser.php';
include_once '../../library/Aste/Exception.php';

$root = new Category('root');

$category1 = new Category('category 1');
$category11 = new Category('category 1.1');
$category1->addCategory($category11);

$category12 = new Category('category 1.2');
$category121 = new Category('category 1.2.1');
$category12->addCategory($category121);
$category122 = new Category('category 1.2.2');
$category12->addCategory($category122);
$category1->addCategory($category12);

$category13 = new Category('category 1.3');
$category1->addCategory($category13);
$category14 = new Category('category 1.4');
$category1->addCategory($category14);
$root->addCategory($category1);

$category2 = new Category('category 2');
$category21 = new Category('category 2.1');
$category22 = new Category('category 2.2');

$category2->addCategory($category21);
$category2->addCategory($category22);
$root->addCategory($category2);

$category3 = new Category('category3');
$root->addCategory($category3);
$category4 = new Category('category4');
$category41 = new Category('category 4.1');
$category4->addCategory($category41);
$category42 = new Category('category 4.2');
$category4->addCategory($category42);

$root->addCategory($category4);

$template = new Aste_Template('template.tpl');

showCategories($root->getCategories(), $template);

echo $template->fetch();

function showCategories($categories, $template) {

    foreach($categories as $category) {

        $block = $template->loop('categories');
        $block->setVar('name', $category->getName());

        $children = $category->getCategories();

        if (sizeOf($children) > 0) {

            $block->rloop();
            showCategories($children, $block);
        }
    }
}

class Category {

    private $name;

    private $categories = array();

    public function __construct($name) {

        $this->name = $name;
    }

    public function getName() {

        return $this->name;
    }

    public function addCategory($category) {

        $this->categories[] = $category;
    }

    public function getCategories() {

        return $this->categories;
    }

}
