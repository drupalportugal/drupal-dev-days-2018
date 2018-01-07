<?php

namespace Drupal\ddd_attendee\EventSubscriber;

use Drupal\ddd_attendee\Event\TitoEvent;
use Drupal\ddd_attendee\Event\TitoEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Drupal\ddd_attendee\AttendeeManager;

/**
 * Class TitoEventsSubscriber.
 */
class TitoEventsSubscriber implements EventSubscriberInterface {

  /**
   * Drupal\ddd_attendee\AttendeeManager definition.
   *
   * @var \Drupal\ddd_attendee\AttendeeManager
   */
  protected $attendeeManager;

  /**
   * TitoEventsSubscriber constructor.
   *
   * @param \Drupal\ddd_attendee\AttendeeManager $attendee_manager
   *   The Attendee manager service.
   */
  public function __construct(AttendeeManager $attendee_manager) {
    $this->attendeeManager = $attendee_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    return $events = [
      TitoEvents::WEBHOOK_CALLBACK => [
        'getTitoWebhookPayload',
      ],
    ];
  }

  /**
   * Create or update an Attendee form tito webhook payload.
   *
   * @param \Drupal\ddd_attendee\Event\TitoEvent $tito_event
   *   The TitoEvent class.
   *
   * @throws \Drupal\ddd_attendee\Exception\TitoWebhookException
   */
  public function getTitoWebhookPayload(TitoEvent $tito_event) {
    $this->attendeeManager->updateAttendee($tito_event->id(), $tito_event->getMail(), $tito_event->getPayload());
  }

}
