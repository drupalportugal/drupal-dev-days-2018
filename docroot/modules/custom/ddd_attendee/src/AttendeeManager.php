<?php

namespace Drupal\ddd_attendee;
use Drupal\Component\Serialization\Json;
use Drupal\Core\Entity\EntityTypeManager;
use Drupal\Core\ProxyClass\Lock\DatabaseLockBackend;
use Drupal\user\UserInterface;

/**
 * Class AttendeeManager.
 */
class AttendeeManager implements AttendeeManagerInterface {

  /**
   * Drupal\Core\Entity\EntityTypeManager definition.
   *
   * @var \Drupal\Core\Entity\EntityTypeManager
   */
  protected $entityTypeManager;
  /**
   * Drupal\Core\ProxyClass\Lock\DatabaseLockBackend definition.
   *
   * @var \Drupal\Core\ProxyClass\Lock\DatabaseLockBackend
   */
  protected $lock;

  /**
   * The Attendee storage service.
   *
   * @var \Drupal\ddd_attendee\AttendeeStorageInterface
   */
  protected $attendeeStorage;

  /**
   * The user storage service.
   *
   * @var \Drupal\User\UserStorage
   */
  protected $userStorage;

  /**
   * AttendeeManager constructor.
   *
   * @param \Drupal\Core\Entity\EntityTypeManager $entity_type_manager
   *   The entity type manager service.
   * @param \Drupal\Core\ProxyClass\Lock\DatabaseLockBackend $lock
   *   The database lock service.
   */
  public function __construct(EntityTypeManager $entity_type_manager, DatabaseLockBackend $lock) {
    $this->entityTypeManager = $entity_type_manager;
    $this->attendeeStorage = $entity_type_manager->getStorage("attendee");
    $this->userStorage = $entity_type_manager->getStorage("user");
    $this->lock = $lock;
  }

  /**
   * {@inheritdoc}
   */
  public function updateAttendee($attendee_id, $mail, $payload = NULL) {
    /*
     * Get the Attendee by external id.
     */
    /** @var \Drupal\ddd_attendee\Entity\AttendeeInterface $attendee */
    $attendee = $this->attendeeStorage->getAttendeeById($attendee_id);
    /*
     * If empty $attendee create one.
     */
    if (empty($attendee)) {
      $attendee = $this->attendeeStorage->create([
        'name' => $attendee_id,
      ]);
    }
    $attendee->set("mail", $mail);
    /*
     * If payload is not empty, append to Attendee.
     */
    if (!empty($payload)) {
      $attendee->get("payload")->appendItem(Json::encode($payload));
    }
    /*
     * Set user on attendee if exists or empty if not found.
     */
    if (empty($mail)) {
      $mail = NULL;
    }
    else {
      $mail = $this->userStorage->loadByProperties(['mail' => $mail]);
    }
    $attendee->set("user", $mail);
    return $attendee->save();
  }

  /**
   * {@inheritdoc}
   */
  public function setAttendeesUserByUserAccountEmail(UserInterface $user) {
    /*
     * Get attendees by mail.
     * Load by properties can return multiple.
     */
    $attendee = $this->attendeeStorage->getAttendeeByMail($user->getEmail());
    /*
     * If there are attendees by mail.
     */
    if (!empty($attendee)) {
      /*
       * Iterate over Attendees.
       */
      /** @var \Drupal\ddd_attendee\Entity\AttendeeInterface $attendee */
      /*
       * If Attendee has not users.
       */
      if ($attendee->get("user")->isEmpty()) {
        /*
         * Set user on Attendee.
         */
        $attendee->set("user", $user->id());
        /*
         * Save Attendee.
         */
        $attendee->save();
      }
    }
  }

}
