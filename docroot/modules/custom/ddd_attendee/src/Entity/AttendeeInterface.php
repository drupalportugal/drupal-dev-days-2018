<?php

namespace Drupal\ddd_attendee\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Attendee entities.
 *
 * @ingroup ddd_attendee
 */
interface AttendeeInterface extends ContentEntityInterface, RevisionLogInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Attendee name.
   *
   * @return string
   *   Name of the Attendee.
   */
  public function getName();

  /**
   * Sets the Attendee name.
   *
   * @param string $name
   *   The Attendee name.
   *
   * @return \Drupal\ddd_attendee\Entity\AttendeeInterface
   *   The called Attendee entity.
   */
  public function setName($name);

  /**
   * Gets the Attendee creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Attendee.
   */
  public function getCreatedTime();

  /**
   * Sets the Attendee creation timestamp.
   *
   * @param int $timestamp
   *   The Attendee creation timestamp.
   *
   * @return \Drupal\ddd_attendee\Entity\AttendeeInterface
   *   The called Attendee entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Attendee published status indicator.
   *
   * Unpublished Attendee are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Attendee is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Attendee.
   *
   * @param bool $published
   *   TRUE to set this Attendee to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\ddd_attendee\Entity\AttendeeInterface
   *   The called Attendee entity.
   */
  public function setPublished($published);

  /**
   * Gets the Attendee revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Attendee revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\ddd_attendee\Entity\AttendeeInterface
   *   The called Attendee entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Attendee revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Attendee revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\ddd_attendee\Entity\AttendeeInterface
   *   The called Attendee entity.
   */
  public function setRevisionUserId($uid);

}
