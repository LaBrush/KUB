<?php
namespace Kub\EDTBundle\Twig;

class EDT2JsArrayExtension extends \Twig_Extension
{
    private $time ;

    public function __construct($time)
    {
        $this->time = $time ;
    }

    public function getFunctions()
    {
        return array(
            'EDT2JsArray' => new \Twig_Function_Method($this, 'EDT2JsArray', array('is_safe' => array('html')))
        );
    }

    public function EDT2JsArray()
    {

        $hours = $this->time->getHours();

        foreach ($hours as $key => $hour) {
            
            $js_array[$hour] = $this->time->getMinutesForHour($hour);

        }

        return json_encode($js_array);

    }

    public function getName()
    {
        return 'EDT2JsArray';
    }
}
