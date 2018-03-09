<?php

namespace Drupal\ddd_attendee\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'AttendesNumberBlock' block.
 *
 * @Block(
 *  id = "attendees_number_block",
 *  admin_label = @Translation("Attendees number block"),
 * )
 */
class AttendeesNumberBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Construct.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param string $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\dddlx_sponsors\SponsorsManager $sponsors_manager
   * @internal param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {

    $query = \Drupal::entityQuery('attendee');
    $entity_count = count($query->execute());

    $build = [
      '#theme' => 'ddd_attendees_number',
      '#attendees' => $entity_count,
      '#cache' => [
        'contexts' => ['url.path'],
        'max-age' => 300
      ]
    ];

    return $build;
  }
}
