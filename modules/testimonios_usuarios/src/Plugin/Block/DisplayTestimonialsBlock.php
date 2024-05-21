<?php

namespace Drupal\testimonios_usuarios\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Database\Connection;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;

/**
 * Provides a 'Display Testimonials Block' block.
 *
 * @Block(
 *   id = "display_testimonials_block",
 *   admin_label = @Translation("Display Testimonials Block"),
 * )
 */
class DisplayTestimonialsBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The database connection.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $database;

  /**
   * Constructs a new DisplayTestimonialsBlock instance.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin ID for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Database\Connection $database
   *   The database connection.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, Connection $database) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->database = $database;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('database')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $query = $this->database->select('testimonio', 't')
      ->fields('t', ['id', 'uid', 'testimonio', 'created'])
      ->range(0, 5)
      ->orderBy('created', 'DESC');
    $results = $query->execute()->fetchAll();

    $items = [];
    foreach ($results as $result) {
      $items[] = [
        '#markup' => '<p><strong>' . $this->t('User @uid', ['@uid' => $result->uid]) . ':</strong> ' . $result->testimonio . '<br><small>' . date('Y-m-d H:i:s', $result->created) . '</small></p>',
      ];
    }

    return [
      '#theme' => 'item_list',
      '#items' => $items,
      '#empty' => $this->t('No testimonials available.'),
    ];
  }

}
