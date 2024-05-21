<?php

namespace Drupal\newsletters_integration\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\newsletters_integration\Form\NewsletterSubscriptionForm;

/**
 * Provides route responses for the Newsletters Integration module.
 */
class NewsletterController extends ControllerBase {

  /**
   * Returns the newsletter subscription page.
   *
   * @return array
   *   A render array.
   */
  public function subscribe() {
    $form = \Drupal::formBuilder()->getForm(NewsletterSubscriptionForm::class);
    return [
      'form' => $form,
    ];
  }

}
