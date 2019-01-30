<?php

class SlideshowFieldSpottedParser extends SlideshowFieldParser implements SlideshowFieldParserInterface {
  static function create($url) {
    // Class init
    $parser = new SlideshowFieldSpottedParser();

    // Load first remote document into simplexml document
    $parser->setLink($url);
    $fileContents = $parser->loadRemoteFile($url . '&page=1');
    $xml = simplexml_load_string($fileContents);

    // Populate parser's metadata variables (title, total items, number of items per page,
    // number of pages and description) from the first document.
    $parser->getMetadata($xml);

    // Loop through the rest of pages and load their data
    if ($parser->pageCount > 1) {
      for ($i = 2; $i <= $parser->pageCount; $i++) {
        $fileContents = $parser->loadRemoteFile($url . '&page=' . $i);
        $xml = simplexml_load_string($fileContents);
        $parser->getItems($xml);
      }
    }

    return $parser;
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
        /// feed fields
        'title' => (string)$item->title,
        'photo' => (string)$item->photo,
        'caption' => $this->escape((string)$item->caption),
      );
      $i++;
    }
    return $i;
  }
}
