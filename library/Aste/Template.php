<?php

class Aste_Template {

    private $template = null;

    private $preview = null;

    public function __construct($template, $preview = null) {

        $this->setTemplate($template);
        $this->setPreview($preview);
    }

    public function setTemplate($template) {

        if (!file_exists($template)) {
        
            throw new Exception(sprintf('File "%s" does not exist', $template));
        }
        
        $this->template = $template;
    }

    public function setPreview($preview) {

        $this->preview = $preview;
    }

    public function getBlock($name = 'main') {

        return new Aste_Block($name, file_get_contents($this->template)); 
    }

}
