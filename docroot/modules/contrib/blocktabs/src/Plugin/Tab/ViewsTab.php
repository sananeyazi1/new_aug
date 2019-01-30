<?php

namespace Drupal\blocktabs\Plugin\Tab;

use Drupal\Core\Form\FormStateInterface;
use Drupal\blocktabs\ConfigurableTabBase;
use Drupal\blocktabs\BlocktabsInterface;
use Drupal\views\Views;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\ReplaceCommand;

/**
 * views tab.
 *
 * @Tab(
 *   id = "views_tab",
 *   label = @Translation("views tab"),
 *   description = @Translation("views tab.")
 * )
 */
class ViewsTab extends ConfigurableTabBase {

  /**
   * {@inheritdoc}
   */
   
  public function addTab(BlocktabsInterface $blocktabs) {

    return TRUE;
  }

  /**
   * {@inheritdoc}
   */
  public function getSummary() {
    $markup = $this->t('view name:') . $this->configuration['view_name'] . '; ';
	$markup .= $this->t('display:') . $this->configuration['view_display'] . '; ';
    if(!empty($this->configuration['view_arg'])){
	  $markup .= $this->t('argument:') . $this->configuration['view_arg'];
    }
    $summary = array(
      '#markup' => '(' . $markup . ')',
    ); 
    //$summary = parent::getSummary();

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return array(
      'view_name' => NULL,
	  'view_display' => NULL,
	  'view_arg' => NULL,
    );
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
	$view_options = Views::getViewsAsOptions(TRUE, 'all', NULL, FALSE, TRUE);
    $form['view_name'] = array(
      '#type' => 'select',
      '#title' => $this->t('view name'),
	  '#options' => $view_options,
      '#default_value' => $this->configuration['view_name'],
      '#field_suffix' => ' ' ,
	  //Drupal\blocktabs\Plugin\Tab\ViewsTab
      '#ajax' => [
	   'callback' => array($this, 'updateDisplay'),
        'wrapper' => 'edit-view-display-wrapper',
      ], 
      '#required' => TRUE,
    );

	$display_options = [];
    if ($this->configuration['view_name']) {
      $view = Views::getView($this->configuration['view_name']);
      foreach ($view->storage->get('display') as $name => $display) {
        $display_options[$name] = $display['display_title'] . ' (' . $display['id'] . ')';
      }	
	}
	

	
    $form['view_display'] = array(
      '#type' => 'select',
      '#title' => $this->t('Display'),
      '#default_value' => $this->configuration['view_display'],
      '#prefix' => '<div id="edit-view-display-wrapper">',
      '#suffix' => '</div>',
	  '#options' => $display_options,
      '#validated' => TRUE,	 
      '#required' => TRUE,
    );
	/*
    $form['view_display'] = array(
      '#type' => 'textfield',
      '#title' => t('Display'),
      '#default_value' => $this->configuration['view_display'],
      '#required' => TRUE,
    );	
*/	
    $form['view_arg'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Argument'),
      '#default_value' => $this->configuration['view_arg'],
      '#field_suffix' => ' ' ,

    );		
    return $form;
  }
  public function updateDisplay($form, FormStateInterface $form_state) {

    $form['data']['view_display']['#default_value'] = '';
	$data =$form_state->getValue('data');
	$view_name = isset($data['view_name']) ? $data['view_name'] : '';

	$display_options = [];
    if ($view_name) {
      $view = Views::getView($view_name);
      foreach ($view->storage->get('display') as $name => $display) {
        $display_options[$name] = $display['display_title'] . ' (' . $display['id'] . ')';
      }	
	}	
    $form['data']['view_display']['#options'] = $display_options;
	
    $form_state->get('rerender', TRUE);
    $form_state->setRebuild();
	
    $response = new AjaxResponse();
    $response->addCommand(new ReplaceCommand('#edit-view-display-wrapper',  drupal_render($form['data']['view_display'])));
    return $response;		
    //return $form['data']['view_display'];
  }

  /**
   * {@inheritdoc}
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
    parent::submitConfigurationForm($form, $form_state);

    $this->configuration['view_name'] = $form_state->getValue('view_name');
	$this->configuration['view_display'] = $form_state->getValue('view_display');
	$this->configuration['view_arg'] = $form_state->getValue('view_arg');
  }

  /**
   * {@inheritdoc}
   */  
  public function getContent() {
    $tab_content = '';
    $view_name = $this->configuration['view_name'];
    $view_display = $this->configuration['view_display'];
    $view_arg = !empty($this->configuration['view_arg']) ? $this->configuration['view_arg'] : NULL;
    $tab_view = views_embed_view($view_name, $view_display, $view_arg);	
	//$tab_content =  \Drupal::service('renderer')->render($tab_view);
    return $tab_view;
  }
}
