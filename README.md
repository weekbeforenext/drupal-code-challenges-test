# Drupal Code Challenges Test Site
A Drupal site for testing Drupal Code Challenge solutions.

## Local testing (DDEV)

[DDEV](https://ddev.com/) configuration is included in this codebase as a convenient way to create a local Drupal development environment and test site.

1. Install [DDEV](https://ddev.readthedocs.io/en/stable/) on your computer.

2. Build this site.
    ```
    ddev start;
    ddev composer install;
    ddev import-db --src=drupal-code-challenges.sql.gz;
    ddev launch
    ```

## Remote testing (Tugboat)

[Tugboat](https://www.tugboatqa.com/) configuration is included in this codebase as a convenient way to create a remote Drupal test site.

Use the provided database backup file [drupal-code-challenges.sql.gz](drupal-code-challentes.sql.gz) in the Tugboat setup.

## Updating Drupal core

1. Install the site in DDEV and run the following:

    ```
    ddev composer update drupal/core-composer-scaffold drupal/core-project-message drupal/core-recommended -W
    ```

2. Run the Drush database update command and export configuration updates:

    ```
    ddev drush updb;
    ddev drush cex -y
    ```

3. Export a new starter database backup file:

    ```
    ddev drush sql-dump --gzip > drupal-code-challenges.sql.gz
    ```
