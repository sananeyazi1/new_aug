<?php

class SlideshowFieldBookedParser extends SlideshowFieldParser implements SlideshowFieldParserInterface {
  const MIN_ITEMS = 220;
  static function create($url) {
    // Class init
    $parser = new SlideshowFieldBookedParser();

    // Load first remote document into simplexml document
    $parser->setLink($url);

    $i = 1;

    while (count($parser->items) < SlideshowFieldBookedParser::MIN_ITEMS) {
      $fileContents = $parser->loadRemoteFile($url . '?page=' . $i);
      $xml = simplexml_load_string($fileContents);
      $parser->getItems($xml);
      $parser->total = count($parser->items);
      $i++;
    }

    return $parser;
  }

  function getMetadata($xml) {
    //$this->title = (string)$xml->channel->title;
    //$this->description = (string)$xml->channel->description;
    //$this->total = (string)$xml->channel->total;

    //$this->count = $this->getItems($xml);
    //$this->pageCount = ($this->count > 0 ? ceil($this->total / $this->count) : 0);
  }

  function getItems($xml) {
    $i = 0;
    foreach ($xml->item as $item) {
      $this->items[] = array(
        'title' => (string)$item->title,
        'photo' => (string)$item->photo,
        'caption' => (string)$item->caption
      );
      $i++;
    }
    return $i;
  }
}
