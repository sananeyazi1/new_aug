<?php

class SlideshowFieldNewRealEstateParser extends SlideshowFieldParser implements SlideshowFieldParserInterface {
  static function create($url) {
    // Class init
    $parser = new SlideshowFieldNewRealEstateParser();

    // Load first remote document into simplexml document
    $parser->setLink($url);
    $fileContents = $parser->loadRemoteFile($url);
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
    $this->total = (string)$xml->total;
    $this->count = (string)$xml->limit;
    $this->pageCount = ($this->count > 0 ? ceil($this->total / $this->count) : 0);
    $this->getItems($xml);

  }

  function getItems($xml) {


    $i = 0;
    foreach ($xml->channel->item as $item) {
      $caption = '<br/><p class="link">' . l(t('View full listing'), (string)$item->link) . '</p>';

      $this->items[] = array(
        'title' => (string)$item->title,
        'link' => (string)$item->link,
        'caption' => (string)$item->description . $caption,
        'photo' => (string)$item->enclosure['url'],
      );

      $i++;
    }
  }
}
