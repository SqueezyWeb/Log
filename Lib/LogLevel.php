<?php
/**
 * LogLevel class file.
 *
 * @package Freyja\Log
 * @copyright 2016 SqueezyWeb
 * @author Gianluca Merlo <gianluca@squeezyweb.com>
 * @license GPLv2+
 * @since 0.1.0
 */

namespace Freyja\Log;
use Psr\Log\LogLevel as PsrLogLevel;

/**
 * LogLevel class.
 *
 * This class contains all the constants corresponding to certain message types.
 *
 * @package Freyja\Log
 * @author Gianluca Merlo <gianluca@squeezyweb.com>
 * @since 0.1.0
 * @version 1.0.0
 */
class LogLevel extends PsrLogLevel {
  const DEPRECATED = 'deprecated';
}
