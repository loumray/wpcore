<?php
/*
 * This file is part of WPCore project.
 *
 * (c) Louis-Michel Raynauld <louismichel@pweb.ca>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WPCore\Forms;

class FieldSet implements \IteratorAggregate
{
    protected $fields = array();
    protected $fieldFactory;

    public function __construct()
    {
        $this->fieldFactory  = new FieldFactory();
    }

    public function init()
    {
        foreach ($this->fields as $field) {
            $field->init();
        }
    }

    public function addField($field)
    {
        if (!$field instanceof AbstractField) {
            $field = $this->fieldFactory->create($field);
        }
        $this->fields[] = $field;

        return $field;
    }

    public function __toString()
    {
        $echo = "";
        foreach ($this->fields as $field) {
            $echo.= $field->toHtml();
        }

        return $echo;
    }

    public function getFields()
    {
        return $this->fields;
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->fields);
    }
}