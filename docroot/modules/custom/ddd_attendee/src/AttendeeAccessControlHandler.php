<?php

namespace Drupal\ddd_attendee;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Attendee entity.
 *
 * @see \Drupal\ddd_attendee\Entity\Attendee.
 */
class AttendeeAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\ddd_attendee\Entity\AttendeeInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished attendee entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published attendee entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit attendee entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete attendee entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add attendee entities');
  }

}
