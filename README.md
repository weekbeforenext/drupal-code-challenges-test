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

## Add a GitHub module to composer

1. Add the GitHub repository:

    ```
    {
      "type": "package",
      "package": {
          "name": "username/repository_name",
          "version": "branch_name",
          "type": "drupal-module",
          "source": {
              "url": "https://github.com/username/repository_name.git",
              "type": "git",
              "reference": "branch_name"
          }
      }
    }
    ```
    Replace `username` with the GitHub repository username and `repository_name` with the repository name. For example, the name of this project is `weekbeforenext/drupal-code-challenges-test`.

    Replace `branch_name` with the name of the branch you want to test for the GitHub repository.
  2. Require the project:

      ```
      ddev composer require username/repository_name
      ```
      Again, replace `username` with the GitHub repository username and `repository_name` with the repository name. For example, the name of this project is `weekbeforenext/drupal-code-challenges-test`.

      If you want to require a feature branch from the repository, you can specify the branch name prefixed with `dev-`:
      ```
      ddev composer require username/repository_name:dev-feature_branch_name
      ```

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
