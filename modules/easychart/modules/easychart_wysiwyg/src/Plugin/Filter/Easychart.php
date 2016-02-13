<?php

/**
 * @file
 * Contains \Drupal\easychart_wysiwyg\Plugin\Filter\Easychart.
 */

namespace Drupal\easychart_wysiwyg\Plugin\Filter;

use Drupal\filter\FilterProcessResult;
use Drupal\filter\Plugin\FilterBase;
use Drupal\node\Entity\Node;

/**
 * Provides a filter to render
 *
 * @Filter(
 *   id = "easychart_filter",
 *   title = @Translation("Render Easychart charts"),
 *   description = @Translation("This filter will replace tokens in form of [[chart-nid:{nid},chart-view-mode:{view_mode}]]."),
 *   type = Drupal\filter\Plugin\FilterInterface::TYPE_MARKUP_LANGUAGE,
 *   weight = -10
 * )
 */
class Easychart extends FilterBase {

  /**
   * {@inheritdoc}
   */
  public function process($text, $langcode) {
    return new FilterProcessResult($this->replaceChartToken($text));
  }

  /**
   * Replaces Easychart tokens with the actual chart.
   *
   * @param $text
   *   The text to replace.
   *
   * @return mixed
   */
  private function replaceChartToken($text) {
    return preg_replace_callback('/\[\[chart-nid:(\d+),chart-view-mode:(\w+)\]\]/', [$this, 'renderChart'], $text);
  }

  /**
   * Provides the replacement html to be rendered in place of the embed code.
   *
   * Does not handle nested embeds.
   *
   * @param array $matches
   *   Array of matches by preg_replace_callback
   *
   * @return string
   *   The rendered HTML replacing the embed code
   */
  public function renderChart($matches) {
    /* @var $node \Drupal\Node\NodeInterface */
    $node = Node::load($matches[1]);
    if ($node == FALSE || !$node->isPublished() || !$node->access('view')) {
      return "[[chart-nid:{$matches[1]},chart-view-mode:{$matches[2]}]]";
    }
    else {
      $view = node_view($node, $matches[2]);
      $render = drupal_render($view);
      return $render;
    }
  }
}
