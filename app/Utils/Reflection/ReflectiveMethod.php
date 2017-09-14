<?php
/**
 * Created by PhpStorm.
 * User: arash
 * Date: 7/13/16
 * Time: 1:41 PM
 */

namespace App\Utils\Reflection;


use ReflectionMethod;

class ReflectiveMethod extends ReflectiveAbstraction
{
    /**
     * @var string
     */
    private $className;
    /**
     * @var string
     */
    private $methodName;
    /**
     * @var ReflectionMethod
     */
    private $reflectionMethod;

    /**
     * ReflectiveMethod constructor.
     * @param string $className
     * @param string $methodName
     */
    public function __construct($className, $methodName)
    {
        $this->className = $className;
        $this->methodName = $methodName;
        $this->reflectionMethod = new ReflectionMethod($this->className, $this->methodName);
        parent::__construct();
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->reflectionMethod->getDocComment();
    }

    /**
     * @return string
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * @param string $className
     */
    public function setClassName($className)
    {
        $this->className = $className;
    }

    /**
     * @return string
     */
    public function getMethodName()
    {
        return $this->methodName;
    }

    /**
     * @param string $methodName
     */
    public function setMethodName($methodName)
    {
        $this->methodName = $methodName;
    }

    /**
     * @return ReflectionMethod
     */
    public function getReflectionMethod()
    {
        return $this->reflectionMethod;
    }

    /**
     * @param ReflectionMethod $reflectionMethod
     */
    public function setReflectionMethod($reflectionMethod)
    {
        $this->reflectionMethod = $reflectionMethod;
    }

    /**
     * @return Action
     */
    public function getAction(){
        return Action::withClassMethodNames($this->className, $this->methodName);
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    function jsonSerialize()
    {
        return [
            'action' => $this->getAction()->getAction() ,
            'className' => $this->className ,
            'methodName' => $this->methodName ,
            'annotations' => $this->getAnnotationsArraySerialize()
        ];
    }
}