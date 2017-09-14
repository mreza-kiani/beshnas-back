<?php

namespace App\Utils\Reflection;

/**
 * Created by PhpStorm.
 * User: arash
 * Date: 7/13/16
 * Time: 1:29 PM
 */
class Action implements \JsonSerializable
{
    /**
     * @var string
     */
    private $action;
    /**
     * @var ReflectiveClass
     */
    private $class;
    /**
     * @var ReflectiveMethod
     */
    private $method;

    /**
     * Action constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return Action
     */
    private static function newObject()
    {
        return new self();
    }

    /**
     * @param string $action
     * @return Action
     */
    public static function withAction($action)
    {
        $newObj = self::newObject();
        $newObj->action = $action;
        $newObj->construct();
        return $newObj;
    }

    /**
     * @param string $className
     * @param string $methodName
     * @return Action
     */
    public static function withClassMethodNames($className, $methodName)
    {
        $newObj = self::newObject();
        $newObj->action = $className . '@' . $methodName;
        $newObj->construct();
        return $newObj;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return Action|bool
     */
    public static function withRequest($request)
    {
        if ($request != null and $request->route() != null) {
            $newObj = self::newObject();
            $newObj->action = $request->route()->getActionName();
            $newObj->construct();
            return $newObj;
        } else
            return false;
    }

    /**
     * @return void
     */
    private function construct()
    {
        $this->class = new ReflectiveClass($this->getClassName());
        $this->method = new ReflectiveMethod($this->getClassName(), $this->getMethodName());
    }

    /**
     * @return string
     */
    public function getClassName()
    {
        $parts = explode('@', $this->action);
        return $parts[0];
    }

    public function getMethodName()
    {
        $parts = explode('@', $this->action);
        return $parts[1];
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param string $action
     */
    public function setAction($action)
    {
        $this->action = $action;
    }

    /**
     * @return ReflectiveClass
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param ReflectiveClass $class
     */
    public function setClass($class)
    {
        $this->class = $class;
    }

    /**
     * @return ReflectiveMethod
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param ReflectiveMethod $method
     */
    public function setMethod($method)
    {
        $this->method = $method;
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
            'action' => $this->action,
            'class' => $this->class->jsonSerialize(),
            'method' => $this->method->jsonSerialize()
        ];
    }
}