<?php

/*
 * This file is part of Respect/Validation.
 *
 * (c) Alexandre Gomes Gaigalas <alexandre@gaigalas.net>
 *
 * For the full copyright and license information, please view the "LICENSE.md"
 * file that was distributed with this source code.
 */

namespace Respect\Validation\Exceptions;

class TrueValException extends ValidationException
{
    public static $defaultTemplates = array(
        self::MODE_DEFAULT => array(
            self::STANDARD => '{{name}} is not considered as `true`',
        ),
        self::MODE_NEGATIVE => array(
            self::STANDARD => '{{name}} is considered as `true`',
        ),
    );
}
