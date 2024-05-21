<?php

namespace Drupal\newsletters_integration\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Messenger\MessengerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use DrewM\MailChimp\MailChimp;

/**
 * Provides a Newsletter Subscription form.
 */
class NewsletterSubscriptionForm extends FormBase {

  /**
   * The messenger service.
   *
   * @var \Drupal\Core\Messenger\MessengerInterface
   */
  protected $messenger;

  /**
   * Constructs a new NewsletterSubscriptionForm.
   *
   * @param \Drupal\Core\Messenger\MessengerInterface $messenger
   *   The messenger service.
   */
  public function __construct(MessengerInterface $messenger) {
    $this->messenger = $messenger;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('messenger')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'newsletter_subscription_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['#attributes']['class'][] = 'newsletter-subscription-form';

    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Email'),
      '#required' => TRUE,
      '#attributes' => ['class' => ['newsletter-email']],
    ];

    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Subscribe'),
      '#button_type' => 'primary',
      '#attributes' => ['class' => ['newsletter-submit']],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $email = $form_state->getValue('email');

    // Aquí puedes añadir la lógica para suscribir el email a MailChimp.
    $mailchimp_api_key = \Drupal::config('newsletters_integration.settings')->get('mailchimp_api_key');
    $mailchimp_list_id = 'your_mailchimp_list_id'; // Reemplaza con tu ID de lista de MailChimp.

    if ($mailchimp_api_key && $mailchimp_list_id) {
      $mailchimp = new MailChimp($mailchimp_api_key);
      $result = $mailchimp->post("lists/$mailchimp_list_id/members", [
        'email_address' => $email,
        'status'        => 'subscribed',
      ]);

      if ($mailchimp->success()) {
        $this->messenger->addMessage($this->t('You have been subscribed to the newsletter with email: @email', ['@email' => $email]));
      } else {
        $this->messenger->addError($this->t('There was a problem with your subscription: @error', ['@error' => $mailchimp->getLastError()]));
      }
    } else {
      $this->messenger->addError($this->t('MailChimp API key or list ID is not configured.'));
    }
  }

}
