<?php

class Aste_Block_Parser {

    const START_BLOCK_PREFIX = '[{]';

    const END_BLOCK_PREFIX = '[{]/';

    const TAG_ENDFIX = '[}]';

    const FAKE_TAG_PREFIX = '{@%@';

    const FAKE_TAG_ENDFIX = '@%@}';

    const VAR_PREFIX = '{$';

    const VAR_ENDFIX = '}';

    private $content = null;

    public function __construct($content = '') {
        
        $this->setContent($content);
    }

    public function setContent($content) {

        $this->content = $content;
    }

    public function getContent() {

        return $this->content;
    }

    public function fetchBlockContent($name, $content) {

        $pattern = '#(' . self::START_BLOCK_PREFIX 
                        . $name 
                        . self::TAG_ENDFIX 
                        . ')(.*)(' 
                        . self::END_BLOCK_PREFIX 
                        . $name 
                        . self::TAG_ENDFIX 
                        . ')#is';

        $replacement = self::FAKE_TAG_PREFIX . $name . self::FAKE_TAG_ENDFIX;

        $matches = array();
        if (preg_match($pattern, $content, $matches)) {
            
            $blockContent = preg_replace($pattern, $replacement, $content); 

            $this->setContent(trim($blockContent));

            return $matches[2]; 

        } else {
            
            throw new Exception(sprintf('Block "%s" does not exist!', $name));
        }
    }

    public function fetchBlock($block) {

        foreach($block->getBlocks() as $name => $child) {

            $fake_tag = self::FAKE_TAG_PREFIX . $name . self::FAKE_TAG_ENDFIX;
            $fake_tag_length = strlen($fake_tag);
            $fake_tag_begin = strpos($block->getContent(), $fake_tag);

            if ($fake_tag_begin !== false) {

                if ($child->doDisplay() === true) {

                    $content = substr_replace($block->getContent(), $child->fetch(), $fake_tag_begin, $fake_tag_length);
                } elseif($child->doDisplay() === false) {

                    $content = substr_replace($block->getContent(), '', $fake_tag_begin, $fake_tag_length);
                } else {

                    $content = substr_replace($block->getContent()
                                                , self::START_BLOCK_PREFIX 
                                                    . $name 
                                                    . self::TAG_ENDFIX 
                                                    . $child->getContent() 
                                                    . self::END_BLOCK_PREFIX 
                                                    . $name 
                                                    . self::TAG_ENDFIX
                                                , $fake_tag_begin, $fake_tag_length);
                }

                $block->setContent($content);
            }
        }

        return trim($block->getContent());
    }

    public function parseVar($content, $name, $value) {

        $varTag = self::VAR_PREFIX . $name . self::VAR_ENDFIX;
        $varTagLen = strlen($varTag);
        $varTagPos = strpos($content, $varTag);
        if ($varTagPos !== false) {
            
            $content = substr_replace($content, $value, $varTagPos, $varTagLen);
            $this->setContent($content);
            return $content;
        }
    }
}
