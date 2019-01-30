#Migrate File Entities to Media Entities

This module allows you to migrate Drupal 8.0 file entities to Drupal 8.5 media entities using the migrate module.

##Main features:
- While migrating the files, a binary hash of all images is calculated and duplicate files are recognized. If the same file was uploaded multiple times, only one media entity will be created.
- Migration of translated file/image fields is supported. Having different images per language will create a translated media entity with the corresponding image.
- Using migrate module allows drush processing, rollback and track changes.

## Usage
- Install the module.

##Preparation: Install media core module
Before you can start, you need to install the media module of Drupal Core. This will automatically create 4 (in Drupal 8.5) or 5 (in Drupal 8.6) media bundle types for you, namely image, video, file and audio.


## Prepare media fields

- Prepare the media fields based on the existing file fields using the following drush command:
```
drush migrate:file-media-fields <entity_type> <bundle> <source_field_type> <target_media_bundle>
```

### Example
```
drush migrate:file-media-fields node article image image
```

For all file fields the corresponding media entity reference fields will be automatically created suffixed by <field_name>_media.


## Prepare duplicate file detection

In order to detect duplicate files / images, run the following drush command to calculate a binary hash 
for all files. The data will be saved to the table "migrate_file_to_media_mapping". You need to run this 
drush command to be able to import media entities.

```
drush migrate:duplicate-file-detection
```

## Create a custom the migration per content type based on the migrate_file_to_media_example module
- Create a custom module
- Create your custom migration templates using the included yml generator.
- The module supports nodes and also paragraphs and any other entity type as a source bundle.

```
drush generate yml-migrate_file_to_media_migration_media
```
```
Welcome to yml-migrate_file_to_media_migration_media generator!
–––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
 Module machine name:
  ➤ migrate_file_to_media
```

The generator will ask you several questions about the module, the source bundle and the target media entity.
It will generate several files based on your answers, that can be used to migrate the files to media entity.

## Explanation of the generated migration files

### Step 1:
File `config/install/migrate_plus.migration.migrate_file_to_media_example_article_images_step1.yml`

This is the starting point. This migration creates a unique media entity from all files / images referenced by 
fields in the configuration `field_names` of the source plugin.
In the example, we have two image fields called: "field_image" and "field_image2".

#### Important:
The drush command to calculate the binary hash need to be run before you can use the
media_entity_generator source plugin.

### Using rokka.io on Step 1:
File `config/install/migrate_plus.migration.migrate_file_to_media_example_article_images_step1_rokka.yml`

This is an example migration, how to move all images to the rokka.io image cdn. You need to install the
drupal rokka module.

### Step 2:
File `config/install/migrate_plus.migration.migrate_file_to_media_example_article_images_step1_de.yml`

This migration adds a translation to existing media entities if a translated file / image field is found.

### Step 3:
File `config/install/migrate_plus.migration.migrate_file_to_media_example_article_images_step2.yml`

This migration links the newly created media entities with entity reference field on the target bundle.


### Check the migration using
```
drush migrate:status
```
### Run the migration using
```
drush migrate:import <migration_name>
```
