<?php

namespace Drupal\augusta_block_api\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Block\BlockPluginInterface;

/**
 * Provides a 'PhotoApiBlock' block.
 *
 * @Block(
 *  id = "photo_api_block",
 *  admin_label = @Translation("Photo Api block")
 * )
 */
class PhotoApiBlock extends BlockBase implements BlockPluginInterface {

/**
 * {@inheritdoc}
 */
  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);
    $config = $this->getConfiguration();
    $form['hello_block_name'] = array (
      '#type' => 'textfield',
      '#title' => $this->t('Who'),
      '#description' => $this->t('Who do you want to say hello to?'),
      '#default_value' => isset($config['name']) ? $config['name'] : '',
    );
    $form['mobile_number'] = array (
      '#type' => 'textfield',
      '#title' => $this->t('your number'),
      '#description' => $this->t('enter your personal mobile number'),
      '#default_value' => isset($config['number']) ? $config['number'] : '',
    );
    $form['address'] = array (
      '#type' => 'textfield',
      '#title' => $this->t('your address'),
      '#description' => $this->t('enter your home town'),
      '#default_value' => isset($config['town']) ? $config['town'] : '',
    );
    return $form;
  }

    /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
/*    $client = \Drupal::httpClient();
   // $request = $client->request('GET', 'http://augustaphotos.wpengine.com/wp-json/ghmAugustaPhotos/v2/tag/masters');
    $request = $client->request('GET', 'http://augustaphotos.wpengine.com/wp-json/ghmAugustaPhotos/v2/tag/masters');
    $response = json_decode($request->getBody());
    //$test = PhotoApiBlock::get_api_data('http://augustaphotos.wpengine.com/wp-json/ghmAugustaPhotos/v2/tag/masters');
   // print_r($response);die('xxxxxxxxxxxxxxx');
    $this->get_api_data();*/
    $this->setConfigurationValue('name', $form_state->getValue('hello_block_name'));
    $this->setConfigurationValue('number', $form_state->getValue('mobile_number'));
    $this->setConfigurationValue('town', $form_state->getValue('address'));
  }

    public function build() {
    $config = $this->getConfiguration();
    //print_r($config);die('lol');
    if (!empty($config['name'])) {
      $name = $config['name'];
    }
    else {
      $name = $this->t('to no one');
    }
    if (!empty($config['number'])) {
      $number = $config['number'];
    }
    else {
      $number = $this->t('mobile number');
    }
    if (!empty($config['town'])) {
      $town = $config['town'];
    }
    else {
      $town = $this->t("@town");
    }
    return array(
      '#markup' => $this->t('Hi my number is @number!,@name and my address @town', 
       array (
         '@number' => $number, '@name' => $name, '@town' => $town,
       )
       ),
    );
  }

   public static function palyers_detail(){
	$node = Node::create([
	// The node entity bundle.
	'type' => 'article',
	'langcode' => 'en',
	'created' => $created_date,
	'changed' => $created_date,
	// The user ID.
	'uid' => 1,
	'moderation_state' => 'published',
	'title' => $title,
	'field_article_section' => array('target_id'=>$section_target_id),
	'field_author' => 111,
	'field_article_main_image' => array('image' => [
	'target_id' => $file->id()
	],
	'field_media_in_library'=> 1
	),

	'field_article_main_video' => array(
	'field_media_video_embed_field' => $youtubeID,
	'field_media_in_library'=> 1
	),

	'field_article_body_summary' => [
	'summary' => substr(strip_tags($text), 0, 100),
	'value' => $text,
	'format' => 'rich_text'
	]
	]);
	$node->save();
  }
}

