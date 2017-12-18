<?php

namespace Cenoura\Support;

class BasePresenter
{
    protected $subject;

    public function __construct($subject)
    {
        $this->subject = $subject;
    }

    public function __call($methodName, $arguments)
    {
        $classMethods = get_class_methods($this->subject);

        if (in_array($methodName, $classMethods)) {
            return call_user_func_array([$this->subject, $methodName], $arguments);
        } else {
            throw new \Exception("Method " . $methodName . " not found.");
        }
    }
}
