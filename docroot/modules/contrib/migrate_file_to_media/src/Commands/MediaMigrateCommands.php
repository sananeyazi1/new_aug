<?php

namespace Drupal\migrate_file_to_media\Commands;

use Drupal\Core\Database\Connection;
use Drupal\Core\Entity\EntityFieldManagerInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\field\Entity\FieldConfig;
use Drupal\field\Entity\FieldStorageConfig;
use Drupal\file\Entity\File;
use Drupal\media\Entity\Media;
use Drush\Commands\DrushCommands;
use Symfony\Component\Console\Input\InputOption;

/**
 * Drush 9 commands for migrate_file_to_media.
 */
class MediaMigrateCommands extends DrushCommands {

  /**
   * @var \Drupal\Core\Entity\EntityFieldManagerInterface
   */
  private $entity_field_manager;

  /**
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  private $entity_type_manager;

  /**
   * @var \Drupal\Core\Database\Connection
   */
  private $connection;

  /**
   * MediaMigrateCommands constructor.
   *
   * @param \Drupal\Core\Entity\EntityFieldManagerInterface $entityFieldManager
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   */
  public function __construct(
    EntityFieldManagerInterface $entityFieldManager,
    EntityTypeManagerInterface $entity_type_manager,
    Connection $connection
  ) {
    $this->entity_field_manager = $entityFieldManager;
    $this->entity_type_manager = $entity_type_manager;
    $this->connection = $connection;
  }

  /**
   * Create create media destination fields.
   *
   * @command migrate:file-media-fields
   * @aliases mf2m
   *
   * @param $entity_type
   * @param $bundle
   * @param $source_field_type
   * @param $target_media_bundle
   */
  public function migrateFileFields($entity_type, $bundle, $source_field_type, $target_media_bundle) {

    $this->output()
      ->writeln("Creating media reference fields for {$entity_type} : {$bundle}.");

    $bundle_fields = $this->entity_field_manager->getFieldDefinitions($entity_type, $bundle);

    // Gather a list of all target fields.
    $map = \Drupal::entityManager()->getFieldMapByFieldType($source_field_type);
    $source_fields = [];
    foreach ($map[$entity_type] as $name => $data) {
      foreach ($data['bundles'] as $bundle_name) {
        if ($bundle_name == $bundle) {
          $target_field_name = $name . '_media';
          $source_fields[$target_field_name] = $bundle_fields[$name];
          $this->output()->writeln('Found field: ' . $name);
        }
      }
    }

    $map = \Drupal::entityManager()->getFieldMapByFieldType('entity_reference');
    $media_fields = [];
    foreach ($map[$entity_type] as $name => $data) {
      foreach ($data['bundles'] as $bundle_name) {
        if ($bundle_name == $bundle) {
          $field_settings = $bundle_fields[$name];
          $target_bundles = $field_settings->getSettings()['handler_settings']['target_bundles'];
          $handler = $field_settings->getSettings()['handler'];
          if (count($target_bundles)) {
            foreach ($target_bundles as $target_bundle) {
              if ($handler == 'default:media' && $target_bundle == $target_media_bundle) {
                // $media_fields[$name] = $field_settings;.
                $this->output()
                  ->writeln('Found existing media field: ' . $name);
              }
            }
          }
        }
      }
    }

    // Create missing fields.
    $missing_fields = array_diff_key($source_fields, $media_fields);

    foreach ($missing_fields as $new_field_name => $field) {
      try {
        $new_field = $this->createMediaField(
          $entity_type,
          $bundle,
          $field,
          $new_field_name,
          $target_media_bundle
        );
      }
      catch (\Exception $ex) {
        $this->output()
          ->writeln("Error while creating media field: {$new_field_name}.");
      }

      if (!empty($new_field)) {
        $this->output()
          ->writeln("Created media field: {$new_field->getName()}.");
      }
    }

    drupal_flush_all_caches();

  }

  /**
   * Create a new entity media reference field.
   *
   * @param $entity_type
   * @param $bundle
   * @param \Drupal\field\Entity\FieldConfig $existing_field
   * @param $new_field_name
   * @param $target_media_bundle
   *
   * @return \Drupal\Core\Field\FieldDefinitionInterface
   */
  private function createMediaField(
    $entity_type,
    $bundle,
    FieldConfig $existing_field,
    $new_field_name,
    $target_media_bundle
  ) {
    $field = FieldConfig::loadByName($entity_type, $bundle, $new_field_name);
    if (empty($field)) {

      // Load existing field storage.
      $field_storage = FieldStorageConfig::loadByName($entity_type, $new_field_name);

      // Create a field storage if none found.
      if (empty($field_storage)) {
        $field_storage = FieldStorageConfig::create(
          [
            'field_name' => $new_field_name,
            'entity_type' => $entity_type,
            'cardinality' => $existing_field->getFieldStorageDefinition()
              ->getCardinality(),
            'type' => 'entity_reference',
            'settings' => ['target_type' => 'media'],
          ]
        );
        $field_storage->save();
      }

      $field = entity_create(
        'field_config',
        [
          'field_storage' => $field_storage,
          'bundle' => $bundle,
          'label' => $existing_field->getLabel() . ' Media',
          'settings' => [
            'handler' => 'default:media',
            'handler_settings' => ['target_bundles' => [$target_media_bundle => $target_media_bundle]],
          ],
        ]
      );
      $field->save();

      // Update Form Widget.
      /** @var \Drupal\Core\Entity\Display\EntityFormDisplayInterface $definition */
      $definition = $this->entity_type_manager->getStorage('entity_form_display')
        ->load($entity_type . '.' . $bundle . '.' . 'default');
      $definition->setComponent(
        $new_field_name,
        [
          'type' => 'entity_reference_autocomplete',
        ]
      )->save();

    }
    return $field;
  }

  /**
   * Find duplicate file entities.
   *
   * @command migrate:duplicate-file-detection
   * @aliases migrate-duplicate
   *
   * @option An option that takes multiple values.
   */
  public function duplicateImageDetection($options = [
    'filter-schema' => InputOption::VALUE_REQUIRED,
    'check-existing-media' => FALSE,
  ]) {

    // Only query permanent files.
    $query = $this->connection->select('file_managed', 'f');
    $query->fields('f', ['fid']);
    $query->condition('status', 1, '=');
    $query->leftJoin('migrate_file_to_media_mapping', 'm', 'm.fid = f.fid');
    $query->isNull('m.fid');

    if ($options['filter-schema']) {
      $query->condition('f.uri', $options['filter-schema'] . '%', 'LIKE');
    }

    $fids = array_map(
      function ($fid) {
        return $fid->fid;
      },
      $query->execute()->fetchAll()
    );

    $files = File::loadMultiple($fids);

    foreach ($files as $file) {
      /** @var \Drupal\file\Entity\File $file */
      try {
        if (!empty($binary_hash = $this->calculateBinaryHash($file))) {

          $query = $this->connection->select('migrate_file_to_media_mapping', 'map');
          $query->fields('map');
          $query->condition('binary_hash', $binary_hash, '=');
          $result = $query->execute()->fetchObject();

          $duplicate_fid = $file->id();
          if ($result) {
            $existing_file = File::load($result->fid);
            $duplicate_fid = $existing_file->id();
            $this->output()
              ->writeln("Duplicate found for file {$existing_file->id()}");
          }

          $existing_media = NULL;
          if ($options['check-existing-media']) {
            // Check for an existing media entity.
            $query_media = $this->connection->select('migrate_file_to_media_mapping_media', 'media');
            $query_media->fields('media');
            $query_media->condition('binary_hash', $binary_hash, '=');
            $existing_media = $query_media->execute()->fetchObject();
          }

          $this->connection->insert('migrate_file_to_media_mapping')
            ->fields([
              'type' => 'image',
              'fid' => $file->id(),
              'target_fid' => $duplicate_fid,
              'binary_hash' => $binary_hash,
              'media_id' => $existing_media ? $existing_media->entity_id : NULL,
            ])
            ->execute();

          $this->output()
            ->writeln("Added binary hash {$binary_hash} for file {$file->id()}");
        }
        else {
          $this->output()
            ->writeln("File empty: Skipped binary hash for file {$file->id()}");
        }
      }
      catch (\Exception $ex) {
        $this->output()
          ->writeln("File not found: Skipped binary hash for file {$file->id()}");
      }
    }
  }

  /**
   * Calculate hash values of media entities. Can later be used together with
   * migrate:duplicate-file-detection to find existing media files.
   *
   * @command migrate:duplicate-media-detection
   *
   * @param $bundle
   *
   * @aliases migrate-duplicate
   */
  public function duplicateMediaImageDetection($bundle) {

    // Only query permanent files.
    $query = $this->connection->select('media', 'me');
    $query->fields('me', ['mid']);
    $query->leftJoin('migrate_file_to_media_mapping_media', 'm', 'm.entity_id = me.mid');
    $query->isNull('m.entity_id');
    $query->condition('bundle', $bundle);

    $mids = array_map(
      function ($mid) {
        return $mid->mid;
      },
      $query->execute()->fetchAll()
    );

    $medias = Media::loadMultiple($mids);

    foreach ($medias as $media) {
      /** @var \Drupal\media\Entity\Media $media */
      try {
        /** @var \Drupal\file\Entity\File $file */
        $file = $media->field_media_image->entity;

        if (!empty($binary_hash = $this->calculateBinaryHash($file))) {

          $query = $this->connection->select('migrate_file_to_media_mapping_media', 'map');
          $query->fields('map');
          $query->condition('binary_hash', $binary_hash, '=');
          $result = $query->execute()->fetchObject();

          $duplicate_id = $media->id();
          if ($result) {
            $existing_media = Media::load($result->entity_id);
            $duplicate_id = $existing_media->id();
            $this->output()
              ->writeln("Duplicate found for file {$existing_media->id()}");
          }

          $this->connection->insert('migrate_file_to_media_mapping_media')
            ->fields([
              'media_bundle' => $bundle,
              'fid' => $file->id(),
              'entity_id' => $media->id(),
              'target_entity_id' => $duplicate_id,
              'binary_hash' => $binary_hash,
            ])
            ->execute();

          $this->output()
            ->writeln("Added binary hash {$binary_hash} for media {$media->id()}");
        }
        else {
          $this->output()
            ->writeln("Media empty: Skipped binary hash for media {$media->id()}");
        }
      }
      catch (\Exception $ex) {
        $this->output()
          ->writeln("Media not found: Skipped binary hash for media {$media->id()}");
      }
    }
  }

  /**
   *
   */
  private function calculateBinaryHash(File $file) {

    // For rokka files, we can use the metadata table to get the correct
    // binary_hash value.
    $rokka_metadata = NULL;
    if (strpos($file->getFileUri(), 'rokka://') === 0) {
      $query = $this->connection->select('rokka_metadata', 'rokka');
      $query->fields('rokka');
      $query->condition('uri', $file->getFileUri(), '=');
      $rokka_metadata = $query->execute()->fetchObject();
      $data = 'empty';
    }
    else {
      $data = file_get_contents($file->getFileUri());
    }

    $binary_hash = NULL;
    if (!empty($data)) {
      $binary_hash = $rokka_metadata ? $rokka_metadata->binary_hash : sha1($data);
    }

    return $binary_hash;
  }

}
