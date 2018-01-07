<?php

namespace Drupal\ddd_attendee;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\ddd_attendee\Entity\AttendeeInterface;
use Drupal\user\UserInterface;

/**
 * Defines the storage handler class for Attendee entities.
 *
 * This extends the base storage class, adding required special handling for
 * Attendee entities.
 *
 * @ingroup ddd_attendee
 */
class AttendeeStorage extends SqlContentEntityStorage implements AttendeeStorageInterface {

  /**
   * {@inheritdoc}
   */
  public function revisionIds(AttendeeInterface $entity) {
    return $this->database->query(
      'SELECT vid FROM {attendee_revision} WHERE id=:id ORDER BY vid',
      [':id' => $entity->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function userRevisionIds(AccountInterface $account) {
    return $this->database->query(
      'SELECT vid FROM {attendee_field_revision} WHERE uid = :uid ORDER BY vid',
      [':uid' => $account->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function countDefaultLanguageRevisions(AttendeeInterface $entity) {
    return $this->database->query('SELECT COUNT(*) FROM {attendee_field_revision} WHERE id = :id AND default_langcode = 1', [':id' => $entity->id()])
      ->fetchField();
  }

  /**
   * {@inheritdoc}
   */
  public function clearRevisionsLanguage(LanguageInterface $language) {
    return $this->database->update('attendee_revision')
      ->fields(['langcode' => LanguageInterface::LANGCODE_NOT_SPECIFIED])
      ->condition('langcode', $language->getId())
      ->execute();
  }

  /**
   * {@inheritdoc}
   */
  public function getAttendeeById($id) {
    $query = $this->getQuery();
    $attendees = $query->condition("name", $id)
      ->execute();
    if (!empty($attendees)) {
      $attendee = reset($attendees);
      return $this->load($attendee);
    }
    return NULL;
  }

  /**
   * {@inheritdoc}
   */
  public function getAttendeeByMail($mail) {
    $query = $this->getQuery();
    $attendees = $query->condition("mail", $mail)
      ->execute();
    if (!empty($attendees)) {
      $attendee = reset($attendees);
      return $this->load($attendee);
    }
    return NULL;
  }
}
