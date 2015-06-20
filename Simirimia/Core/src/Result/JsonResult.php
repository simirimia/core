<?php
/*
 * This file is part of the simirimia/core package.
 *
 * (c) https://github.com/simirimia
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Simirimia\Core\Result;


class JsonResult implements Result
{
    use ResultCode;

    /**
     * @var string
     */
    private $data;

    public function __construct( $jsonString, $resultCode = null )
    {
        $this->data = $jsonString;
        if ( null !== $resultCode ) {
            if ( is_int( $resultCode ) ) {
                $this->setResultCode( $resultCode );
            } else {
                throw new \InvalidArgumentException( '$resultCode needs to be integer or omitted' );
            }
        }
    }

    /**
     * @return string
     */
    public function getJsonString()
    {
        return $this->data;
    }
}
