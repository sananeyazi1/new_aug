<?php

class SlideshowFieldRealEstateParser extends SlideshowFieldParser implements SlideshowFieldParserInterface {
  static function create($url) {
    // Class init
    $parser = new SlideshowFieldRealEstateParser();

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
    foreach ($xml->listings->listing as $item) {
      $caption = '<p class="link">' . l(t('View full listing'), (string)$item->permalink) . '</p>';
      $caption .= '<p class="price">' . t('<b>Price:</b> :price', array(':price' => (string)$item->price)) . '</p>';
      $caption .= '<p class="beds">' . t('<b>Beds:</b> :beds', array(':beds' => (string)$item->beds)) . '</p>';
      $caption .= '<p class="baths">' . t('<b>Baths:</b> :baths', array(':baths' => (string)$item->baths)) . '</p>';

      $this->items[] = array(
        'title' => (string)$item->full_address,
        'photo' => (string)$item->main_photo,
        'caption' => $caption . (string)$item->description
      );
      $i++;
    }
    return $i;
  }
}
