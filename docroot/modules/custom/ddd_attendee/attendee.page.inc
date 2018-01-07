<?php

/**
 * @file
 * Contains attendee.page.inc.
 *
 * Page callback for Attendee entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Attendee templates.
 *
 * Default template: attendee.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_attendee(array &$variables) {
  // Fetch Attendee Entity Object.
  $attendee = $variables['elements']['#attendee'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
