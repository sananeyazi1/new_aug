<?php

class SlideshowFieldXMLParser {
  public $link, $description, $total, $title, $count, $pageCount, $created;
  public $items = array();

  const PARSER = 'spotted';
  const ITEMS_PER_JSON = 30;

  static function create($url) {
    // Class init
    $parser = new SlideshowFieldXMLParser();

    // Load first remote document into simplexml document
    $parser->setLink($url);
    $fileContents = $parser->loadRemoteFile($url . '&page=1');
    $xml = simplexml_load_string($fileContents);

    // Populate parser's metadata variables (title, total items, number of items per page,
    // number of pages and description) from the first document.
    $parser->getMetadata($xml);

    // Loop through the rest of pages and load their data
    if ($parser->pageCount > 1) {
      dsm($parser->pageCount);
      for ($i = 2; $i <= $parser->pageCount; $i++) {
        $fileContents = $parser->loadRemoteFile($url . '&page=' . $i);
        $xml = simplexml_load_string($fileContents);
        $parser->getItems($xml);
      }
    }

    return $parser;
  }

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


  function getMetadata($xml) {
    $this->title = (string)$xml->channel->title;
    $this->description = (string)$xml->channel->description;
    $this->total = (string)$xml->channel->total;

    $this->count = $this->getItems($xml);
    $this->pageCount = ($this->count > 0 ? ceil($this->total / $this->count) : 0);
  }

  function getItems($xml) {
    $i = 0;
    foreach ($xml->channel->item as $item) {
      $this->items[] = array(
        'photo' => (string)$item->photo,
        'caption' => (string)$item->caption
      );
      $i++;
    }
    return $i;
  }


  function setLink($link) {
    $this->link = $link;
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
