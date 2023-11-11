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

Use the following custom DDEV command to add the GitHub repository configuration to composer.json and require the module:

```
ddev dcc-add-module [username] [repo-name] [branch-name]
```

Replace `[username]` with the GitHub repository username and `[repo-name]` with the repository name. For example, the username of this project is `weekbeforenext` and the repository name is `drupal-code-challenges-test`.

Replace `[branch-name]` with the name of the branch you want to test for the GitHub repository.

### Update to the latest feature branch changes

If you've started testing a module and changes are committed and pushed to the feature branch, use this custom DDEV command to pull in the latest code for re-testing:

```
ddev dcc-up-module [username] [repo-name]
```

Replace `[username]` with the GitHub repository username and `[repo-name]` with the repository name. For example, the username of this project is `weekbeforenext` and the repository name is `drupal-code-challenges-test`.

## Remote testing (Tugboat)

[Tugboat](https://www.tugboatqa.com/) configuration is included in this codebase as a convenient way to create a remote Drupal test site.

---

## Updating Drupal core (Maintainers Only)

Maintainers of this project can use the follow custom DDEV command to keep this project up-to-date with core and contrib module updates:

```
ddev dcc-update
```
