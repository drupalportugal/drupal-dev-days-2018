<?php

namespace Drupal\ddd_attendee;

use Drupal\Core\Entity\ContentEntityStorageInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\ddd_attendee\Entity\AttendeeInterface;

/**
 * Defines the storage handler class for Attendee entities.
 *
 * This extends the base storage class, adding required special handling for
 * Attendee entities.
 *
 * @ingroup ddd_attendee
 */
interface AttendeeStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Attendee revision IDs for a specific Attendee.
   *
   * @param \Drupal\ddd_attendee\Entity\AttendeeInterface $entity
   *   The Attendee entity.
   *
   * @return int[]
   *   Attendee revision IDs (in ascending order).
   */
  public function revisionIds(AttendeeInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Attendee author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Attendee revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\ddd_attendee\Entity\AttendeeInterface $entity
   *   The Attendee entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(AttendeeInterface $entity);

  /**
   * Unsets the language for all Attendee with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

  /**
   * Get an Attendee by id.
   *
   * @param string $id
   *   The attendee id.
   *
   * @return \Drupal\Core\Entity\EntityInterface|null
   *   The Attendee entity if found or null.
   */
  public function getAttendeeById($id);

  /**
   * Get an Attendee by mail.
   *
   * @param string $mail
   *   The attendee email.
   *
   * @return \Drupal\Core\Entity\EntityInterface|null
   *   The Attendee entity if found or null.
   */
  public function getAttendeeByMail($mail);

}
