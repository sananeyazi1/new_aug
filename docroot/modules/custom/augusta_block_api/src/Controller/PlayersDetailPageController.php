<?php

/**
 * @file
 * Contains Drupal\augusta_block_api\Controller.
 */

namespace Drupal\augusta_block_api\Controller;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\Core\Url;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\iom_invoice\Services\AtsService;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class PlayersDetailPageController.
 *
 * @package Drupal\augusta_block_api
 */
class PlayersDetailPageController extends ControllerBase {





  /**
   * Method to handle the user redirection
   */
  public function PlayersDetail() {
    $query = \Drupal::entityQuery('node');
    $query->condition('status', 1);
    $query->condition('type', 'players');
    $ids = $query->execute();
   // foreach ($ids as $nid) {
      $node = \Drupal\node\Entity\Node::load(6019);
      //print_r($node);die;
      $title = $node->get('title')->getValue()[0]['value'];
      $players_id = $node->get('field_players_id')->getValue()[0]['value'];
      $last_name = $node->get('field_last_name')->getValue()[0]['value'];
      $country = $node->get('field_country')->getValue()[0]['value'];
      $born = $node->get('field_born')->getValue()[0]['value'];
      $born_location = $node->get('field_born_location')->getValue()[0]['value'];
      $residence = $node->get('field_residence')->getValue()[0]['value'];
      $height = $node->get('field_height')->getValue()[0]['value'];
      $weight = $node->get('field_weight')->getValue()[0]['value'];
      $college = $node->get('field_college')->getValue()[0]['value'];
      $turned_pro = $node->get('field_turned_pro')->getValue()[0]['value'];
      $world_golf_rank = $node->get('field_world_golf_rank')->getValue()[0]['value'];
      $masters_earnings = $node->get('field_masters_earnings')->getValue()[0]['value'];
      $qualification = $node->get('field_2018_masters_qualification')->getValue()[0]['value'];
      $test_url = $node->get('field_test_url')->getValue()[0]['value'];
      $allperformance = $node->get('field_allperformance_data')->getValue()[0]['value'];
      $all_performance =json_decode($allperformance, true);
      $mastersrecors = $node->get('field_mastersrecors_data')->getValue()[0]['value'];
      $masters_recors= json_decode($mastersrecors, true);
      $tournament = $node->get('field_tournament_data')->getValue()[0]['value'];
      $tourn_decod =json_decode($tournament, true);
  //  }
      $data = array('title' => $title,'players_id' => $players_id,'last_name' => $last_name,'country' => $country,'born' => $born,'born_location' => $born_location,'residence' => $residence,'height' => $height,'weight' => $weight,'college' => $college,'college' => $college,'turned_pro' => $turned_pro,'world_golf_rank' => $world_golf_rank,'masters_earnings' => $masters_earnings,'qualification' => $qualification,'test_url' => $test_url,'all_performance' => $all_performance,'masters_recors' => $masters_recors,'tourn_decod' => $tourn_decod);
      return [
      '#theme' => 'players_detail_page',
      '#data' => $data,
    ];   
  }

}

