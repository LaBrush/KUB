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
            'EDT2JsArray' => new \Twig_Function_Method($this, 'EDT2JsArray')
        );
    }

    public function EDT2JsArray()
    {

        $js_array = $this->time->getHours();

        foreach ($js_array as $key => $hour) {
            # code...
        }

        return json_encode($js_array);

    }

    public function getName()
    {
        return 'EDT2JsArray';
    }
}