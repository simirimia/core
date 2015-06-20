<?php
/*
 * This file is part of the simirimia/core package.
 *
 * (c) https://github.com/simirimia
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Simirimia\Core\ResultRenderer;

use Simirimia\Core\Result\JsonResult;

class JsonResultRenderer implements ResultRenderer
{

    public static function render( $result )
    {
        if ( !( $result instanceof JsonResult ) ) {
            throw new \InvalidArgumentException( '$result needs to be of type JsonResult' );
        }

        return $result->getJsonString();
    }

}
