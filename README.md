# Drupal Code Challenges Test Site
A Drupal site for testing Drupal Code Challenge solutions locally or remotely.

- [Local testing (DDEV)](#local-testing-ddev)
- [Add a GitHub module to composer](#add-a-github-module-to-composer)
- [Remote testing (Tugboat)](#remote-testing-tugboat)

## Local testing (DDEV)

[DDEV](https://ddev.com/) configuration is included in this codebase as a convenient way to create a local Drupal development environment and test site.

1. Install [DDEV](https://ddev.readthedocs.io/en/stable/) on your computer.

2. Build this site using the following custom DDEV command:
    ```
    ddev dcc-build
    ```

## Add a GitHub module to composer

1. Add the module's GitHub repository to the composer.json file repositories array like this:

    ```
    {
        "type": "package",
        "package": {
            "name": "username/repository_name",
            "version": "dev-branch_name",
            "type": "drupal-module",
            "source": {
                "url": "https://github.com/username/repository_name.git",
                "type": "git",
                "reference": "branch_name"
            }
        }
    }
    ```
    Replace `username` with the GitHub repository username and `repository_name` with the repository name. For example, the username of this project is `weekbeforenext` and the repository name is `drupal-code-challenges-test`.

    Replace `branch_name` with the name of the branch you want to test for the GitHub repository.
  2. Require the project:

      ```
      ddev composer require username/repository_name
      ```
      Again, replace `username` with the GitHub repository username and `repository_name` with the repository name in the command.

### Update to the latest feature branch changes

If you've started testing a module and changes are committed and pushed to the feature branch, follow these steps to pull in the latest code for re-testing:

1. Delete the module directory.
2. Run `ddev composer clear-cache`.
3. Run `ddev composer update username/repository_name` (Again, replace `username` with the GitHub repository username and `repository_name` with the repository name in the command).

## Remote testing (Tugboat)

[Tugboat](https://www.tugboatqa.com/) configuration is included in this codebase as a convenient way to create a remote Drupal test site.

---

## Updating Drupal core (Maintainers Only)

Maintainers of this project can use the follow custom DDEV command to keep this project up-to-date with core and contrib module updates:

```
ddev dcc-update
```
