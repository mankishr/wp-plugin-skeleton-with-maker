# WordPress plugin skeleton + plugin maker for CLI
Create new plugin from wp-plugin-skeleton folder and files in the root of the project by running this command in cli
    
    $ php app/bin/console app:make-wp-plugin "My new plugin" "Mark Markic" "1.0.12"

## Version tags
Checkout to any tag you need for your plugin development. 
If you only need boilerplate or options page you don't need to checkout to the latest version.

First be sure that you have all tags locally:
    
    $ git fetch --all --tags --prune

Then checkout tag you need to the new branch

    $ git checkout tags/<tag_name> -b <branch_name>

* v1.0.0 boilerplate 
* v2.0.0 options page 
* v3.0.0 custom database table 
* v4.1.0 mapping entity to database table and validation
* v5.0.0 cron job
* v6.0.0 database migration

## Contribute
If there is something that you like to fix or add in this repo feel free to suggest your changes. 
If you would like to add something in the lower versions, checkout from the tag.
If the change request is accepted it will not be merged into main branch.
Instead new version tag will be released for the branch that has change inside. 
Look at the tag v4.1.0 for an example.
It is important to keep the main version on that branch and bump only minor versions.
So if you have checkouted from the tag v2.0.0 new tag for the made changes will be 2.0.1 for the small typo and fixes or 2.1.0 for the new implementation. For example adding webpack.