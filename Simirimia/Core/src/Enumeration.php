<?php
/*
 * This file is part of the simirimia/core package.
 *
 * (c) https://github.com/simirimia
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Simirimia\Core;

use \ReflectionClass;
use \InvalidArgumentException;

abstract class Enumeration
{
    const __default = null ;

    /**
     * @var mixed
     */
    private $value;

    /**
     * @param mixed $initialValue
     */
    public function __construct ( $initialValue = null )
    {
        if ( in_array( $initialValue, $this->getConstList( true ) )) {
            $this->value = $initialValue;
        } elseif( $initialValue === null ) {
            $this->value = constant( get_called_class() . '::__default' );
        } else {
            throw new InvalidArgumentException( 'Invalid value: ' . $initialValue );
        }
    }

    /**
     * @param bool $includeDefault
     * @return array
     */
    public function getConstList ( $includeDefault = false )
    {
        $reflectionClass = new ReflectionClass( get_called_class() );
        $constants = $reflectionClass->getConstants();
        if ( ! $includeDefault ) {
            unset( $constants['__default'] );
        }
        return $constants;
    }

    /**
     * @param string $key
     * @return bool
     */
    public static function hasKey( $key )
    {
        try {
            $enumClassName = get_called_class();
            new $enumClassName( $key );
            return true;
        } catch ( InvalidArgumentException $e ) {
            return false;
        }
    }

    /**
     * @return string
     */
    public function getValuesName()
    {
        return array_search( $this->value, $this->getConstList() );
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->value;
    }
}
