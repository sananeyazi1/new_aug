<?php

interface SlideshowFieldParserInterface {
  public static function create($url);

  public function getMetadata($xml);

  public function loadRemoteFile($xml);

  public function getItems($xml);

  public function save();

}
