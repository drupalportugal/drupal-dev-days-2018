<?php

namespace Drupal\ddd_attendee\Event;

/**
 * Defines events for the ti.to webhook callback.
 *
 * @ingroup ddd_attendee
 */
final class TitoEvents {

  /**
   * The webhook event.
   *
   * @var string
   */
  const WEBHOOK_CALLBACK = 'tito.webhook_callback';


}
