<?php

class Aste_Block {

    private $name = null;

    private $content = null;

    private $parser = null;

    private $blocks = array();

    private $display = false;

    private $pattern = null;

    public function __construct($name, $content) {

        $this->setName($name);
        $this->setContent($content);
        $this->setPattern($content);

        $this->parser = new Aste_Block_Parser($content);
    }

    public function setName($name) {

        $this->name = $name;
    }

    public function getName() {

        return $this->name;
    }

    public function setContent($content) {

        $this->content = $content;
    }

    public function setPattern($pattern) {

        $this->pattern = $pattern;
    }

    public function getPattern() {

        return $this->pattern;
    }

    public function getContent() {

        return $this->content;
    }

    private function addBlock($block) {

        $this->blocks[$block->getName()] = $block;
    }

    private function addBlocks($blocks) {

        foreach($blocks as $block) {

            $this->addBlock($block);
        }
    }

    public function getBlocks() {

        return $this->blocks;
    }

    private function getChildBlock($name) {

        if (!empty($this->blocks[$name])) {
            
            return $this->blocks[$name];
        }

        return null;
    }

    public function getBlock($name) {

        $block = $this->getChildBlock($name);
        if ($block == null ) {

            $content = $this->parser->fetchBlockContent($name, $this->getContent());

            $this->addBlock(new Aste_Block($name, $content));

            $this->setContent($this->parser->getContent());
        }

        return $this->getChildBlock($name);
    }

    public function fetch() {

        return $this->parser->fetchBlock($this);
    }

    public function display($display = true) {
        
        $this->display = $display;
    }

    public function doDisplay() {

        return $this->display;
    }

    public function setVar($name, $value) {

        $content = $this->getContent();
        $content = $this->parser->parseVar($content, $name, $value);
        $this->setContent($content);
    }

    public function loop() {

        static $count;
        $count++;

        if ($count > 1) {
            $this->setContent($this->getContent() . $this->getPattern()); 
        }
        $this->display(true);
    }

    public function loopRecursive() {

        static $count;
        $count++;
        
        if ($count > 1) {
            // $this->setContent(
        }
    }
}
