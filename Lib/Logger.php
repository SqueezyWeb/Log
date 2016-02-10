<?php
/**
 * Logger class file.
 *
 * @package Freyja\Log
 * @copyright 2016 SqueezyWeb
 * @since 0.1.0
 */

namespace Freyja\Logger;
use Psr\Log\AbstractLogger;
use Freyja\Exceptions\InvalidArgumentException;

/**
 * Logger class.
 *
 * @package Freyja\Log
 * @author Gianluca Merlo <gianluca@squeezyweb.com>
 * @since 0.1.0
 * @version 1.0.0
 */
class Logger extends AbstractLogger implements LoggerInterface {
  /**
   * Whether logging is enabled or not.
   *
   * @since 1.0.0
   * @access protected
   * @static
   * @var bool
   */
  protected static $enabled = true;

  /**
   * Notice use of deprecated element.
   *
   * @since 1.0.0
   * @access public
   *
   * @param string $element Deprecated element.
   * @param string $version Version since element is deprecated.
   * @param string $replacement Optional. Element to use instead. Default null.
   */
  public function deprecated($element, $version, $replacement = null) {
    $message = '{element} is deprecated since {version}.';
    $context = array(
      'element' => $element,
      'version' => $version
    );

    if (!is_null($replacement)) {
      $message .= ' Use {replacement} instead.';
      $context['replacement'] = $replacement;
    }

    $this->log(
      LogLevel::DEPRECATED,
      $message,
      $context
    );
  }

  /**
   * Log with arbitrary level.
   *
   * @since 1.0.0
   * @access public
   *
   * @param mixed $level Type of log message.
   * @param string $message The message to send to the user.
   * @param array $context Optional. Other information to be placed in the
   * message. Default empty.
   *
   * @throws Freyja\Exceptions\InvalidArgumentException if $message is not a
   * string.
   */
  public function log($level, $message, array $context = array()) {
    if (!is_string($message))
      throw InvalidArgumentException::typeMismatch('message', $message, 'String');

    // Return early if logging is disabled.
    // Done after argument check in order to debug errors anyway.
    if (!self::$enabled)
      return;

    $message = self::interpolate($message, $context);

    switch ($level) {
      case LogLevel::EMERGENCY:
      case LogLevel::ALERT:
      case LogLevel::CRITICAL:
      case LogLevel::ERROR:
        trigger_error($message, E_USER_ERROR);
        break;
      case LogLevel::WARNING:
        trigger_error($message, E_USER_WARNING);
        break;
      case LogLevel::NOTICE:
      case LogLevel::INFO:
      case LogLevel::DEBUG:
        trigger_error($message, E_USER_NOTICE);
        break;
      case LogLevel::DEPRECATED:
        trigger_error($message, E_USER_DEPRECATED);
        break;
    }
  }

  /**
   * Disable logging.
   *
   * @since 1.0.0
   * @access public
   * @static
   */
  public static function disable() {
    self::$enabled = false;
  }

  /**
   * Enable logging.
   *
   * @since 1.0.0
   * @access public
   * @static
   */
  public static function enable() {
    self::$enabled = true;
  }

  /**
   * Interpolate message with additional information.
   *
   * @since 1.0.0
   * @access protected
   * @static
   *
   * @param string $message
   * @param array $context
   * @return string The actual message.
   */
  protected static function interpolate($message, array $context = array()) {
    // Build a replacement array with braces around the context keys.
    $replace = array();
    foreach ($context as $key => $val)
      $replace['{'.$key.'}'] = $val;

    // Interpolate replacement values into the message and return.
    return strtr($message, $replace);
  }
}
