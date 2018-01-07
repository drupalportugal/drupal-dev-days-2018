<?php

namespace Drupal\ddd_attendee;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
 * Defines a class to build a listing of Attendee entities.
 *
 * @ingroup ddd_attendee
 */
class AttendeeListBuilder extends EntityListBuilder {


  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Attendee ID');
    $header['name'] = $this->t('Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\ddd_attendee\Entity\Attendee */
    $row['id'] = $entity->id();
    $row['name'] = Link::createFromRoute(
      $entity->label(),
      'entity.attendee.edit_form',
      ['attendee' => $entity->id()]
    );
    return $row + parent::buildRow($entity);
  }

}
