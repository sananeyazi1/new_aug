<?php

class SlideshowFieldMyCaptureParser extends SlideshowFieldParser implements SlideshowFieldParserInterface {
  static function create($url) {
    // Class init
    $parser = new SlideshowFieldMyCaptureParser();

    // Load first remote document into simplexml document
    $parser->setLink($url);
    $fileContents = $parser->loadRemoteFile($url . '&page=1');
    $json = json_decode($fileContents, true);

    // Populate parser's metadata variables (title, total items, number of items per page,
    // number of pages and description) from the first document.
    $parser->getMetadata($json);

    // Loop through the rest of pages and load their data
    if ($parser->pageCount > 1) {
      for ($i = 2; $i <= $parser->pageCount; $i++) {
        $fileContents = $parser->loadRemoteFile($url . '&page=' . $i);
        $json = json_decode($fileContents, true);
        $parser->getItems($json);
      }
    }

    return $parser;
  }

  function getMetadata($json) {
    $this->total = (string)$json['total_results'];
    $this->count = (string)$json['results_showing'];
    $this->pageCount = ($this->count > 0 ? ceil($this->total / $this->count) : 0);
    $this->getItems($json);
  }

  function getItems($json) {
    $i = 0;
    foreach ($json['photos'] as $item) {
	  
	 $large_image = str_replace('golfphotos.augusta.com', 'www.augusta.com/spotted', (string)$item['large_image']);
	 $this->items[] = array(
        'title' => $item['title'],
	'photo' => $large_image,
	'caption' => (string)$item['caption']
      );
      $i++;
    }

    return $i;
  }
}
