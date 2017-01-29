<?php

namespace DocBlockRoute;

use phpDocumentor\Reflection\DocBlock\Tags\BaseTag;
use phpDocumentor\Reflection\DocBlock\Description;
use phpDocumentor\Reflection\DocBlock\DescriptionFactory;
use phpDocumentor\Reflection\Types\Context;
use phpDocumentor\Reflection\DocBlock\Tags\Factory\StaticMethod;


class PathTag extends BaseTag implements StaticMethod
{
    protected $name = 'path';

    public $description;

    /**
     * PathTag constructor.
     * @param Description $description
     */
    public function __construct(Description $description)
    {
        $this->description = $description;
    }

    public static function create($body, DescriptionFactory $descriptionFactory = null, Context $context = null)
    {
        return new static($descriptionFactory->create($body, $context));
    }


    /**
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }

    public function getPathInfo()
    {
        $description_string = (string)$this->description;
        $parts = explode(' ', $description_string);
        return array_slice($parts, 0, 3);
    }
}