<?php

namespace Drupal\blocktabs\Plugin\Tab;

use Drupal\Core\Block\BlockManagerInterface;
use Drupal\Core\Block\BlockPluginInterface;
use Psr\Log\LoggerInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\blocktabs\ConfigurableTabBase;
use Drupal\blocktabs\BlocktabsInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * block tab.
 *
 * @Tab(
 *   id = "block_tab",
 *   label = @Translation("block plugin tab"),
 *   description = @Translation("block plugin tab.")
 * )
 */
class BlockTab extends ConfigurableTabBase {
  /**
   * @var \Drupal\Core\Block\BlockManagerInterface
   */
  protected $blockManager;

  /**
   * @var \Drupal\Core\Block\BlockPluginInterface
   */
  protected $blockPlugin;

  /**in
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('logger.factory')->get('blocktabs'),
      $container->get('plugin.manager.block')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, LoggerInterface $logger, BlockManagerInterface $block_manager) {
    parent::__construct($configuration, $plugin_id, $plugin_definition, $logger);

    $config = [];
    $this->blockManager = $block_manager;
    $this->blockPlugin = $this->blockManager->createInstance($this->configuration['block_id'], $config);
  }

  /**
   * {@inheritdoc}data']
   */
   
  public function addTab(BlocktabsInterface $blocktabs) {
    return TRUE;
  }

  /**
   * {@inheritdoc}
   */
  public function getSummary() {
  
    $summary = array(
      '#markup' => '(' . $this->t('Block plugin id:') . $this->configuration['block_id'] . ')',
    ); 
    //$summary = parent::getSummary();

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return array(
      'block_id' => NULL,
    );
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $definitions = $this->blockManager->getGroupedDefinitions();

    $options = array();
    foreach ($definitions as $group => $blocks) {
      $options[$group] = array();

      foreach ($blocks as $id => $block) {
        $options[$group][$id] = $block['admin_label'];
      }
    }

    $form['block_id'] = array(
      '#type' => 'select',
      '#title' => $this->t('Block id'),
      '#options' => $options,
      '#default_value' => $this->configuration['block_id'],
      '#required' => TRUE,
    );
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
    parent::submitConfigurationForm($form, $form_state);

    $this->configuration['block_id'] = $form_state->getValue('block_id');
  }
  
  public function getContent() {
    return $this->blockPlugin->build();
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheContexts() {
    return $this->blockPlugin->getCacheContexts();
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheTags() {
    return $this->blockPlugin->getCacheTags();
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheMaxAge() {
    return $this->blockPlugin->getCacheMaxAge();
  }

}
