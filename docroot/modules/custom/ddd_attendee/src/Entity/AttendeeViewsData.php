<?php

namespace Drupal\ddd_attendee\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Attendee entities.
 */
class AttendeeViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    // Additional information for Views integration, such as table joins, can be
    // put here.

    return $data;
  }

}
