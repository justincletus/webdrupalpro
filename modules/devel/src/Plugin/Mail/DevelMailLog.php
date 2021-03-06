<?php
/**
 * @file
 * MailSystemInterface for logging mails to the filesystem.
 *
 * To enable, save a variable in settings.php (or otherwise) whose value
 * can be as simple as:
 *
 * $config['system.mail']['interface']['default'] = 'devel_mail_log';
 *
 * Saves to temporary://devel-mails dir by default. Can be changed using
 * 'debug_mail_directory' config setting. Filename pattern controlled by
 * 'debug_mail_file_format' config setting.
 * NOTE: Config settings are currently broken: see
 * https://www.drupal.org/node/2385971.
 */

namespace Drupal\devel\Plugin\Mail;

use Drupal\Component\Utility\Unicode;
use Drupal\Core\Mail\Plugin\Mail\PhpMail;
use Drupal\Core\Site\Settings;
use Exception;

/**
 * Defines a mail backend that saves emails as temporary files.
 *
 * @Mail(
 *   id = "devel_mail_log",
 *   label = @Translation("Devel Logging Mailer"),
 *   description = @Translation("Outputs the message as a file in the temporary directory.")
 * )
 */
class DevelMailLog extends PhpMail {

  public function composeMessage($message) {
    $mimeheaders = array();
    $message['headers']['To'] = $message['to'];
    foreach ($message['headers'] as $name => $value) {
      $mimeheaders[] = $name . ': ' . Unicode::mimeHeaderEncode($value);
    }

    $line_endings = Settings::get('mail_line_endings', PHP_EOL);
    $output = join($line_endings, $mimeheaders) . $line_endings;
    // 'Subject:' is a mail header and should not be translated.
    $output .= 'Subject: ' . $message['subject'] . $line_endings;
    // Blank line to separate headers from body.
    $output .= $line_endings;
    $output .= preg_replace('@\r?\n@', $line_endings, $message['body']);
    return $output;
  }

  public function getFileName($message) {
    $output_directory = $this->getOutputDirectory();
    $this->makeOutputDirectory($output_directory);
    $output_file_format = \Drupal::config('devel.settings')->get('debug_mail_file_format');

    $tokens = array(
      '%to' => $message['to'],
      '%subject' => $message['subject'],
      '%datetime' => date('y-m-d_his'),
    );
    return $output_directory . '/' . $this->dirify(str_replace(array_keys($tokens), array_values($tokens), $output_file_format));
  }

  private function dirify($string) {
    return preg_replace('/[^a-zA-Z0-9_\-\.@]/', '_', $string);
  }

  /**
   * Save an e-mail message to a file, using Drupal variables and default settings.
   *
   * @see http://php.net/manual/en/function.mail.php
   * @see drupal_mail()
   *
   * @param array $message
   *   A message array, as described in hook_mail_alter().
   * @return bool|int TRUE if the mail was successfully accepted, otherwise FALSE.
   * TRUE if the mail was successfully accepted, otherwise FALSE.
   */
  public function mail(array $message) {
    $output = $this->composeMessage($message);
    $output_file = $this->getFileName($message);

    return file_put_contents($output_file, $output);
  }

  protected function makeOutputDirectory($output_directory) {
    if (!file_prepare_directory($output_directory, FILE_CREATE_DIRECTORY)) {
      throw new Exception("Unable to continue sending mail, $output_directory is not writable");
    }
  }

  public function getOutputDirectory() {
    return \Drupal::config('devel.settings')->get('debug_mail_directory');
  }

}
