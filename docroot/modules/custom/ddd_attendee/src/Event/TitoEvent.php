<?php

namespace Drupal\ddd_attendee\Event;

use Drupal\ddd_attendee\Exception\TitoWebhookException;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class SwitchEvent.
 *
 * @see \Drupal\ddd_attendee\Event\TitoEvents
 */
class TitoEvent extends Event {

  /**
   * Event Type.
   *
   * @var string
   */
  protected $type;

  /**
   * The ti.to payload.
   *
   * @var array
   */
  protected $payload;

  /**
   * Constructor.
   *
   * @param string $event_type
   *   The event type.
   * @param array $payload
   *   The ti.to webhook payload.
   */
  public function __construct($event_type, array $payload) {
    $this->type = $event_type;
    $this->payload = $payload;
  }

  /**
   * Get event type.
   *
   * @return string
   *   The event type.
   */
  public function getType() {
    return $this->type;
  }

  /**
   * Get the switch event.
   *
   * @return array
   *   The Switch event.
   */
  public function getPayload() {
    return $this->payload;
  }

  /**
   * Get the ti.to payload id.
   *
   * @return string
   *   The payload id.
   *
   * @throws \Drupal\ddd_attendee\Exception\TitoWebhookException
   */
  public function id() {
    if (empty($this->payload["id"])) {
      throw new TitoWebhookException("Payload id not found.");
    }
    return $this->payload["id"];
  }

  /**
   * Get the ti.to attendee mail.
   *
   * @return string
   *   The attendee email.
   *
   * @throws \Drupal\ddd_attendee\Exception\TitoWebhookException
   */
  public function getMail() {
    if (empty($this->payload["email"])) {
      throw new TitoWebhookException("Payload mail not found.");
    }
    return $this->payload["email"];
  }

}
