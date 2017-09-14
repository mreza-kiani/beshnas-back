<?php
/**
 * Created by PhpStorm.
 * User: arash
 * Date: 7/13/16
 * Time: 1:42 PM
 */

namespace App\Utils\Reflection;


use Exception;

abstract class ReflectiveAbstraction implements \JsonSerializable
{
    /**
     * @var Annotation[]
     */
    private $annotations;

    /**
     * ReflectiveAbstraction constructor.
     */
    public function __construct()
    {
        $this->annotations = [];
        foreach ($this->getAnnotationTitles() as $annotationTitle) {
            $this->annotations[$annotationTitle] = $this->createAnnotationByTitle($annotationTitle);
        }
    }

    /**
     * @return Annotation[]
     */
    public function getAnnotations()
    {
        return $this->annotations;
    }

    /**
     * @param Annotation[] $annotations
     */
    public function setAnnotations($annotations)
    {
        $this->annotations = $annotations;
    }

    /**
     * @return string
     */
    public function toJson()
    {
        return json_encode($this->jsonSerialize());
    }

    /**
     * @return string
     */
    public abstract function getComment();


    /**
     * @return array[]
     */
    public function getAnnotationsArraySerialize()
    {
        $result = [];
        if ($this->annotations) {
            foreach ($this->annotations as $key => $value) {
                $result[$key] = $value->jsonSerialize();
            }
        }
        return $result;
    }

    /**
     * @return string[]
     */
    private function getAnnotationTitles()
    {
        $tmpComment = $this->getComment();
        $result = [];
        while (($pos = strpos($tmpComment, '@')) !== false) {
            $tmpComment = substr($tmpComment, $pos + 1);

            $pos = strpos($tmpComment, '@');
            $line = $pos !== false ?
                substr($tmpComment, 0, strpos($tmpComment, '@')) :
                $tmpComment;

            if (strpos($line, '(') !== false) {
                $newTitle = substr($tmpComment, 0, strpos($tmpComment, '('));
                $result[] = $newTitle;
            }
        }
        return $result;
    }

    /**
     * @param string $title
     * @return Annotation|bool
     */
    private function createAnnotationByTitle($title)
    {
        $tmpComment = $this->getComment();

        $pos = strpos($tmpComment, '@' . $title);
        if ($pos === false)
            return false;
        $tmpComment = str_replace('@' . $title, '', $tmpComment);
        $tmpComment = substr($tmpComment, $pos);
        $tmpComment = substr($tmpComment, 1, strpos($tmpComment, ')') - 1);

        return new Annotation($title, $this->parseProperties($tmpComment));
    }

    /**
     * @param string $string
     * @return \string[]
     * @throws Exception
     */
    private function parseProperties($string)
    {
        $resultArray = [];
        if (strlen($string) != 0) {
            $string = str_replace('\\,', '\\$&', $string);
            foreach (explode(',', $string) as $part) {
                $part = str_replace('\\$&', ',', $part);
                $part = explode('=', $part);
                if (sizeof($part) != 0) {
                    $key = trim($part[0]);
                    $value = '';
                    if (sizeof($part) > 1){
                        try {
                            eval("\$value = " . trim($part[1]) . ";");
                        }catch(Exception $e){
                            throw new Exception("the syntax error in php docs : {$string} , please note that you can not use characters like (',', '(', ')', '=', '@') in your value of annotation attributes, thanks");
                        }
                    }
                    if(is_string($value)){
                        $value = trans($value);
                    }
                    $resultArray[$key] = $value;
                }
            }
        }

        return $resultArray;
    }

    /**
     * @param string $title
     * @return bool
     */
    public function hasAnnotation($title)
    {
        return array_key_exists($title, $this->annotations);
    }


    /**
     * @param string $title
     * @return Annotation|bool
     */
    public function getAnnotation($title)
    {
        if ($this->hasAnnotation($title))
            return $this->annotations[$title];
        return false;
    }

    public function needsLogin()
    {
        return
            $this->hasAnnotation('permissionSystem') and
            $this->getAnnotation('permissionSystem')->hasProperty('loginNeeded') and
            ($this->getAnnotation('permissionSystem')->getProperty('loginNeeded') !== false);
    }

}