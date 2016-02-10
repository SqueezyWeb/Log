<?php
/**
 * LoggerInterface interface file.
 *
 * @package Freyja\Log
 * @copyright 2016 SqueezyWeb
 * @since 0.1.0
 */

namespace Freyja\Log;
use Psr\Log\LoggerInterface as PsrLoggerInterface;

/**
 * LoggerInterface class.
 *
 * Defines additional standards for Logger over PSR-3.
 *
 * @package Freyja\Log
 * @author Gianluca Merlo <gianluca@squeezyweb.com>
 * @since 0.1.0
 * @version 1.0.0
 */
interface LoggerInterface extends PsrLoggerInterface {
  /**
   * Notify use of deprecated element.
   *
   * @since 1.0.0
   * @access public
   *
   * @param string $element Deprecated element.
   * @param string $version Version since element is deprecated.
   * @param string $replacement Optional. Element to use instead. Default null.
   */
  public function deprecated($element, $version, $replacement = null);

  /**
   * Disable logging.
   *
   * @since 1.0.0
   * @access public
   * @static
   */
  public static function disable();

  /**
   * Enable logging.
   *
   * @since 1.0.0
   * @access public
   * @static
   */
  public static function enable();
}
