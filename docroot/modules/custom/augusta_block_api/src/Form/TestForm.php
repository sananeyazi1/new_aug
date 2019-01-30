<?php
/**
 * @file
 * Contains \Drupal\augusta_block_api\Form\TestForm.
 */
namespace Drupal\augusta_block_api\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
//use Drupal\file\Entity\File;
use Drupal\Core\Config\ConfigFactoryInterface;
//use Drupal\node\Entity\Node;
use Drupal\Core\Render\Renderer;
use Drupal\Core\Routing\RouteProvider;
use Drupal\Core\Link;
use Drupal\Core\Url;

use \Drupal\node\Entity\Node;
use \Drupal\file\Entity\File;
use Drupal\Core\Datetime\DrupalDateTime;

/*use Drupal\Component\Serialization\Json;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware as DefaultMiddleware;
use GuzzleHttp\Psr7\Request;*/

/**
 * Class TestForm.
 */
class TestForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'test_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['upload_csv'] = [
     '#type' => 'managed_file',
     '#title' => $this->t('Upload CSV'),
     '#description' => $this->t('Upload csv file from here.'),
     '#weight' => '0',
     '#upload_location' => 'public://csv/userimport' . date('Y') . '/' . date('m') . '/',
     '#upload_validators' => [
     'file_validate_extensions' => ['csv'],
     ],
     '#required' => TRUE,
     ];
    $form['description'] = array(
     '#markup' => '<p>Use this form to upload a CSV file Data</p>',
     );
    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = array(
     '#type' => 'submit',
     '#value' => $this->t('Upload CSV'),
     '#button_type' => 'primary',
    );
   return $form;
 }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
      $curl = curl_init(); 
       curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => 'http://golflink.herokuapp.com/playerFeed',
       ));
      $output = curl_exec($curl); 
      $output = str_replace('&quot;', '"', $output);
      $output = stripcslashes($output);
      $player_feed = json_decode($output, true);
       foreach($player_feed as $player_obj) {
        if($player_obj && $player_obj['player_id']){
            $url = "http://golflink.herokuapp.com/players/".(string)$player_obj['player_id']."/json";
            $player_curl = curl_init(); 
            curl_setopt_array($player_curl, array(
              CURLOPT_RETURNTRANSFER => 1,
              CURLOPT_URL => $url,
            ));
            $player_data = curl_exec($player_curl); 
            $player_data = str_replace('&quot;', '"', $player_data);
            $player_data = stripcslashes($player_data);
            $player = json_decode($player_data, true);
            print_r($player);die('xxxx');
           // $node = \Drupal\node\Entity\Node::load(5859);
            if(!empty($player)){
              foreach ($player['player'] as $data) {
                  $updated_time = $data['updated_at'];
                  $updated_timestap = new DrupalDateTime($updated_time, 'UTC');
                  $updated_timestap = $updated_timestap->getTimestamp();
                  $id =  $data['id'];
                  $first = $data['first'];
                  $last = $data['last'];
                  $country = $data['country'];
                  $field_born = [date('Y-m-d', strtotime($data['dob']))];
                  $field_born_location = $data['birthplace'];
                  $field_residence = $data['residence'];
                  $field_height = $data['height'];
                  $field_weight = $data['weight'];
                  $field_college = $data['college'];
                  $field_turned_pro = $data['turned_pro'];
                  $field_wins=$data['wins'];
                  $field_world_golf_rank = $data['world_golf_rank'];
                  $field_2018_masters_qualification = $data['qualifications'];
                  $field_test_url = $data['image'];
                  $field_created_at = [date('Y-m-d\TH:i:s', strtotime($data['created_at']))];
                  $field_updated_at = [date('Y-m-d\TH:i:s', strtotime($data['updated_at']))];
                }
                  $allPerformance[] = $player['allPerformance'];
                  $json_performance = json_encode($allPerformance);

                  $tournament[] = $player['tournament'];
                  $json_tournament = json_encode($tournament);
        
                   foreach ($player['mastersRecord'] as $master[]) {
                      $year = $master['year'];
                      $poition=$master['Position'];
                      $score= $master['Score'];
                      $earnings= $master['Earnings'];
                      $four=$master['4'];
                      $three=$master['3'];
                      $two=$master['2'];
                      $one=$master['1'];
                  }

                  //$master = $player['mastersRecord'];
                  $json_master = json_encode($master);

                   $node = Node::create([
                  'type' => 'players',
                  'field_players_id'  =>  $id,
                  'title'  =>  $first,
                  'field_last_name'  =>  $last,
                  'field_country'  =>  $country,
                  'field_born' => $field_born,
                  'field_born_location' =>  $field_born_location,
                  'field_residence'  =>  $field_residence,
                  'field_height'  =>  $field_height,
                  'field_weight' =>  $field_weight,
                  'field_college'  =>  $field_college,
                  'field_turned_pro'  =>  $field_turned_pro,
                  'field_wins'   =>  $field_wins,
                  'field_world_golf_rank'  =>  $field_world_golf_rank,
                  'field_masters_earnings'  =>  $masters_earnings,
                  'field_2018_masters_qualification'  =>  $field_2018_masters_qualification,
                  'field_test_url' =>  $field_test_url,
                  // '' =>  $data['best_finish'];
                  'field_created_at' => $field_created_at,
                  'field_updated_at' => $field_updated_at,
                  'field_allperformance_data'    =>  $json_performance,
                  'field_mastersrecors_data' =>  $json_master,
                 // 'field_rounds_data' =>  $data['group‎'],
                  'field_tournament_data' =>  $json_tournament,
                ]);
                 $node->status = 1;
                 $node->save();
            //  }
            }
          }
        }
     print_r('sanaaa');die;
    $data    = $form_state->getValue('upload_csv');
    }

    
  }