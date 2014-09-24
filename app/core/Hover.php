<?php namespace Contentify;

use HTML;

class Hover {

    /**
     * The content to display
     * @var string
     */
    private $content = null;

    /**
     * Code for an HTML element that contians the content
     * @var string
     */
    private $wrapperTag = '<div class="hover-ui">%%</div>';

    /**
     * Constructor.
     * 
     * @param string $text Text to add
     */
    public function __construct($text = '')
    {
        if ($text) {
            $this->text($text);
        }
    }

    public function __tostring()
    {
        return $this->render();
    }

    /**
     * Adds text to the content.
     * 
     * @param  string $text The text to add
     * @return Hover
     */
    public function text($text)
    {
        if ($text) {
            $this->content .= '<p>'.$text.'</p>';
        }
        return $this;
    }

    /**
     * Adds an image to the content.
     * 
     * @param  string $url        Image URL
     * @param  string $alt        Image alt attribute
     * @param  array  $attributes Image attributes
     * @return Hover
     */
    public function image($url, $alt = null, $attributes = array())
    {
        if ($url) {
            $this->content .= HTML::image($url, $alt = null, $attributes);
        }
        return $this;
    }

    /**
     * Adds a heading to the content
     * 
     * @param  string $heading The heading to add
     * @return Hover
     */
    public function heading($heading)
    {
        if ($heading) {
            $this->content .= '<h3>'.$heading.'</h3>';
        }
        return $this;
    }

    /**
     * Clear the content
     * 
     * @return Hover
     */
    public function clear()
    {
        $this->content = null;
        return $this;
    }

    /**
     * Renders the hover UI element.
     * 
     * @return string
     */
    public function render()
    {
        if ($this->content) {
            return str_replace('%%', $this->content, $this->wrapperTag);
        } else {
            return '';
        }
    }

}