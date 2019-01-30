<?php

abstract class SlideshowFieldParser {
  public $link;
  public $description;
  public $total;
  public $title;
  public $count;
  public $pageCount;
  public $created;
  public $items = array();

  function __construct() {
    $this->created = time();
  }

  function loadRemoteFile($url) {
    $parsed_url = parse_url($url);
    if (!isset($destination)) {
      $path = file_build_uri(drupal_basename($parsed_url['path']));
    } else {
      if (is_dir(drupal_realpath($destination))) {
        // Prevent URIs with triple slashes when glueing parts together.
        $path = str_replace('///', '//', "$destination/") . drupal_basename($parsed_url['path']);
      } else {
        $path = $destination;
      }
    }
    $result = drupal_http_request($url);
    if ($result->code != 200) {
      drupal_set_message(t('HTTP error @errorcode occurred when trying to fetch @remote.', array(
        '@errorcode' => $result->code,
        '@remote' => $url
      )), 'error');
      return FALSE;
    }

    return $result->data;
  }


  function setLink($link) {
    $this->link = $link;
  }

  function escape($string) {
    $patterns = array(
      '/&lt;/' => '<',
      '/&gt;/' => '>',
      '/&quot;/' => '"',
    );

    return preg_replace(array_keys($patterns), array_values($patterns), $string);
  }


  function save() {
    $record = array(
      'title' => $this->title,
      'link' => $this->link,
      'description' => $this->description,
      'total_items' => $this->total,
      'time_created' => $this->created,
      'items' => $this->items
    );

    // Save the record.
    file_save_data(drupal_json_encode($record), 'public://slideshowfield-' . md5($this->link) . '.json', FILE_EXISTS_REPLACE);

    return $record;
  }
}
