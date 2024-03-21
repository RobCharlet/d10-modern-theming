<?php

use Drupal\Core\Form\FormStateInterface;

/**
 * Implements hook_form_system_theme_settings_alter().
 */
function alps_trips_form_system_theme_settings_alter(&$form, FormStateInterface $form_state): void
{
  $form['alps_trips'] = [
    '#type' => 'fieldset',
    '#title' => t('Alps Trips Configuration'),
  ];

  $form['alps_trips']['copyright'] = [
    '#type' => 'textfield',
    '#title' => t('Copyright text'),
    '#default_value' => theme_get_setting('copyright'),
    '#description' => t('Copyright text'),
    '#required' => TRUE,
  ];

  $form['alps_trips']['socials'] = [
    '#type' => 'fieldset',
    '#title' => t('Socials'),
  ];

  $form['alps_trips']['socials']['twitter'] = [
    '#type' => 'textfield',
    '#title' => t('Twitter'),
    '#default_value' => theme_get_setting('twitter'),
    '#description' => t('Insert the Twitter url.'),
  ];

  $form['alps_trips']['socials']['facebook'] = [
    '#type' => 'textfield',
    '#title' => t('Facebook'),
    '#default_value' => theme_get_setting('facebook'),
    '#description' => t('Insert the Facebook url.'),
  ];

  $form['alps_trips']['socials']['github'] = [
    '#type' => 'textfield',
    '#title' => t('Github'),
    '#default_value' => theme_get_setting('github'),
    '#description' => t('Insert the Github url.'),
  ];
}
