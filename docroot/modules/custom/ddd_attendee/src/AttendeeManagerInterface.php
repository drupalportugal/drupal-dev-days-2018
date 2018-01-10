<?php

namespace Drupal\ddd_attendee;

use Drupal\user\UserInterface;

/**
 * Interface AttendeeManagerInterface.
 */
interface AttendeeManagerInterface {

  /**
   * Update an Attendee or create if not exists.
   *
   * @param string $attendee_id
   *   The Attendee id.
   * @param string $mail
   *   The Attendee mail.
   * @param array|null $payload
   *   The payload.
   *
   * @return int
   *   Whether the entity was updated/created or not.
   *
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  public function updateAttendee($attendee_id, $mail, $payload = NULL);

  /**
   * Set User on Attendee if Attendee exists and does not reference user.
   *
   * @param \Drupal\user\UserInterface $user
   *   The User.
   *
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  public function setAttendeesUserByUserAccountEmail(UserInterface $user);

}
