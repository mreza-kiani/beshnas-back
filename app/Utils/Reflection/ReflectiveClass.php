<?php
/**
 * Created by PhpStorm.
 * User: arash
 * Date: 7/13/16
 * Time: 1:41 PM
 */

namespace App\Utils\Reflection;


use ReflectionClass;

class ReflectiveClass extends ReflectiveAbstraction
{
    /**
     * @var string
     */
    private $className;
    /**
     * @var ReflectionClass
     */
    private $reflectionClass;

    /**
     * ReflectiveClass constructor.
     * @param string $className
     */
    public function __construct($className)
    {
        $this->className = $className;
        $this->reflectionClass = new ReflectionClass($this->className);
        parent::__construct();
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->reflectionClass->getDocComment();
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
     * @return ReflectionClass
     */
    public function getReflectionClass()
    {
        return $this->reflectionClass;
    }

    /**
     * @param ReflectionClass $reflectionClass
     */
    public function setReflectionClass($reflectionClass)
    {
        $this->reflectionClass = $reflectionClass;
    }

    /**
     * @return \ReflectionMethod[]
     */
    private function reflectionMethods()
    {
        return $this->reflectionClass->getMethods();
    }

    /**
     * @param bool $justPermissionSystemMethod
     * @return ReflectiveMethod[]
     */
    public function getMethods($justPermissionSystemMethod = true)
    {
        $methods = [];
        foreach ($this->reflectionMethods() as $reflectionMethod) {
            $method = Action::withClassMethodNames($this->className, $reflectionMethod->name)->getMethod();
            if (!$justPermissionSystemMethod or $method->hasAnnotation('permissionSystem')) {
                $methods[] = $method;
            }
        }
        return $methods;
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
        $methods = [];

        foreach ($this->getMethods() as $method) {
            $methods[] = $method->jsonSerialize();
        }

        return [
            'className' => $this->className,
            'annotations' => $this->getAnnotationsArraySerialize(),
            'methods' => $methods
        ];
    }
}