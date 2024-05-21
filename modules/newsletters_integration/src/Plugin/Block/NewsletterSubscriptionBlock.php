<?php

namespace Drupal\newsletters_integration\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'Newsletter Subscription' block.
 *
 * @Block(
 *   id = "newsletter_subscription_block",
 *   admin_label = @Translation("Newsletter Subscription"),
 * )
 */
class NewsletterSubscriptionBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    return [
      '#markup' => $this->t('Newsletter subscription form will be here.'),
    ];
  }

}
