<?php

namespace Drupal\dddlx_sponsors\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\dddlx_sponsors\SponsorsManager;

/**
 * Provides a 'AllSponsorsBlock' block.
 *
 * @Block(
 *  id = "all_sponsors_block",
 *  admin_label = @Translation("All sponsors block"),
 * )
 */
class AllSponsorsBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The Entity type manager service.
   *
   * @var \Drupal\dddlx_sponsors\SponsorsManager
   */
  protected $sponsors_manager;

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
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    SponsorsManager $sponsors_manager
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->sponsors_manager = $sponsors_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('dddlx_sponsors.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {

    $diamond_sponsors = [
      '#type' => 'view',
      '#name' => 'sponsors',
      '#display_id' => 'block_4',
      '#arguments' => [],
    ];

    $platinum_sponsors = [
      '#type' => 'view',
      '#name' => 'sponsors',
      '#display_id' => 'block_1',
      '#arguments' => [],
    ];

    $gold_sponsors = [
      '#type' => 'view',
      '#name' => 'sponsors',
      '#display_id' => 'block_2',
      '#arguments' => [],
    ];

    $silver_sponsors = [
      '#type' => 'view',
      '#name' => 'sponsors',
      '#display_id' => 'block_3',
      '#arguments' => [],
    ];

    $carrier_partner_sponsors = [
      '#type' => 'view',
      '#name' => 'sponsors',
      '#display_id' => 'block_6',
      '#arguments' => [],
    ];

    $partner_sponsors = [
      '#type' => 'view',
      '#name' => 'sponsors',
      '#display_id' => 'block_9',
      '#arguments' => [],
    ];

    $build = [
      '#theme_wrappers' => ['sponsors_wrapper'],
      /*
      'diamond' => [
        '#theme' => 'sponsors',
        '#title' => 'Diamond sponsors',
        '#sponsor_type' => 'diamond',
        '#sponsors' => $diamond_sponsors,
      ],
      'platinum' => [
        '#theme' => 'sponsors',
        '#title' => 'Platinum sponsors',
        '#sponsor_type' => 'platinum',
        '#sponsors' => $platinum_sponsors,
      ],*/
      'gold' => [
        '#theme' => 'sponsors',
        '#title' => 'Gold sponsors',
        '#sponsor_type' => 'gold',
        '#sponsors' => $gold_sponsors,
      ],
      'silver' => [
        '#theme' => 'sponsors',
        '#title' => 'Silver sponsors',
        '#sponsor_type' => 'silver',
        '#sponsors' => $silver_sponsors,
      ],
      'special_partner' => [
        '#theme' => 'sponsors',
        '#title' => 'Official carrier',
        '#sponsor_type' => 'bronze',
        '#sponsors' => $carrier_partner_sponsors,
      ],
      'partner' => [
        '#theme' => 'sponsors',
        '#title' => 'Official hosting partners',
        '#sponsor_type' => 'bronze',
        '#sponsors' => $partner_sponsors,
      ]
    ];

    return $build;
  }

}
