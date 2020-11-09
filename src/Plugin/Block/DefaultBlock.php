<?php

namespace Drupal\acme_football\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'DefaultBlock' block.
 *
 * @Block(
 *  id = "acme_football_block",
 *  admin_label = @Translation("Acme Football Masonry block"),
 * )
 */
class DefaultBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
    ] + parent::defaultConfiguration();
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['show_filters'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Show Filters?'),
      '#description' => $this->t('Check this box to show the filters.'),
      '#default_value' => isset($this->configuration['show_filters']) ? $this->configuration['show_filters'] : '',
      '#weight' => '0',
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['show_filters'] = $form_state->getValue('show_filters');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $build['#theme'] = 'acme_football_block';
//    $build['#content'][] = $this->configuration['show_filters'];
    $build['#content']['show_filters'] = $this->configuration['show_filters'];
    return $build;
  }

}
