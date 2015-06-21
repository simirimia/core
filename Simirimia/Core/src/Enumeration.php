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
    const __default = null;

    /**
     * @var mixed
     */
    private $value;

    /**
     * Initial Value may be the name and/or the value of any defined class as well as null to select the default value
     *
     * @param mixed $initialValue
     */
    public function __construct ( $initialValue = null )
    {
        $constants = $this->getConstList( true );
        if ( in_array( $initialValue, $constants )) {
            $this->value = $initialValue;
        } elseif( $initialValue === null ) {
            $this->value = constant(get_called_class() . '::__default');
        } elseif( array_key_exists( $initialValue, $constants ) ) {
            $this->value = $constants[$initialValue];
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
