<?php

namespace Drupal\migrate_file_to_media\Plugin\migrate\process;

use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\crop\Entity\Crop;
use Drupal\file\Entity\File;
use Drupal\migrate\MigrateException;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\Plugin\migrate\process\FileCopy;
use Drupal\migrate\Row;

/**
 * Copies or local file for usage in media module.
 *
 * Examples:
 *
 * @code
 * process:
 *   path_to_file:
 *     plugin: file_copy
 *     source:
 *       - id
 *       - public://new/path/to/
 * @endcode
 *
 * @see \Drupal\migrate\Plugin\MigrateProcessInterface
 *
 * @MigrateProcessPlugin(
 *   id = "media_file_copy"
 * )
 */
class MediaFileCopy extends FileCopy implements ContainerFactoryPluginInterface {

  /**
   * {@inheritdoc}
   */
  public function transform($source_id, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
    // If we're stubbing a file entity, return a URI of NULL so it will get
    // stubbed by the general process.
    if ($row->isStub()) {
      return NULL;
    }

    $destination_folder = $this->configuration['path'] ?? 'public://media/';
    $source_file = File::load($source_id);
    $source = $source_file->getFileUri();

    $destination = NULL;
    if ($source_file) {
      $destination = $destination_folder . $source_file->getFilename();
    }

    // Ensure the source file exists, if it's a local URI or path.
    if (!file_exists($source)) {
      throw new MigrateException("File '$source' does not exist");
    }

    // Prepare destination folder.
    if (strpos($destination_folder, 'rokka' !== 0)) {
      // Check if a writable directory exists, and if not try to create it.
      $dir = $this->getDirectory($destination);
      // If the directory exists and is writable, avoid file_prepare_directory()
      // call and write the file to destination.
      if (!is_dir($dir) || !is_writable($dir)) {
        if (!file_prepare_directory($dir, FILE_CREATE_DIRECTORY | FILE_MODIFY_PERMISSIONS)) {
          throw new MigrateException("Could not create or write to directory '$dir'");
        }
      }
    }

    $final_destination = $this->saveFile($source, $destination);
    if ($final_destination) {
      $this->updateFocalPoint($source, $final_destination->getFileUri(), $final_destination);
      return $final_destination->id();
    }

    throw new MigrateException("File $source could not be copied to $destination");
  }

  /**
   * Save file to a defined destination.
   */
  protected function saveFile($source, $destination, $replace = FILE_EXISTS_RENAME) {
    $data = file_get_contents($source);
    $file = file_save_data($data, $destination, $replace);
    return $file;
  }

  /**
   * Update focal point.
   *
   * @param $uri_old
   *   Old URI.
   * @param $uri_rokka
   *   Rokka URI.
   * @param $rokka_file
   *   Rokka file.
   */
  private function updateFocalPoint($uri_old, $uri_rokka, $rokka_file) {

    try {

      /** @var \Drupal\crop\Entity\Crop $old_crop */
      $old_crop = Crop::findCrop($uri_old, 'focal_point');

      $crop = Crop::create([
        'type' => 'focal_point',
        'entity_id' => $rokka_file->id(),
        'entity_type' => 'file',
        'uri' => $uri_rokka,
        'height' => $old_crop->height->value,
        'width' => $old_crop->width->value,
        'x' => $old_crop->x->value,
        'y' => $old_crop->y->value,
      ]);

      $crop->save();

    }
    catch (\Exception $exception) {
      throw new MigrateException('Failed to save the focal point to rokka');
    }

  }

}
