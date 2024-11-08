
*** CUSTOMIZING YOUR VERSION OF THE EVIDENCE HUB CODE ***

NOTE: language customizations are done in the language folder (see README in language folder)
theme customizations are done in the theme folder (see README in theme folder)

This is the beginnings of a system to more easily manage local customizations of the code.
It is a very crude system to try and keep the released code separate from any local code changes on different Hubs.
This is envisaged for the interface to work along side Themes.

There are currently two ways you can customize your version of the Evidence hub:

1. REPLACE A WHOLE FILE - all files
All include and script calls get prepocessed to look for a local customization of a given file.
These files should be placed in the /custom folder in the same subfolder structure as the original.
The custom file should have the same file name as the file being replaced.

For example, if you wish to replace the default ui/homepage.php file, 
create a file called '/custom/ui/homepage.php'.
If you are copying the original file, remember the intial call to config.php
will now need to be one level deeper.

When includes and scripts are preprocessed by the FileLocationManager, 
it will look for a customisation and if it finds one, 
it returns the path to the local version of the file.
If not, it return the original path to the main version of the file.

Top level pages have code at the top of their file to check for a custom version. 
It there is one, it asks the FileLocationManager for the path to the custom version
and redirects to it.

The top level files are:

/403-error-page.php
/404-error-page.php
/builder.php
/explore.php
/index.php
/search.php
/user.php
/admin/adminregister
/admin/index.php
/admin/thememanager.php
/admin/userContextStats.php
/help/builderhelp.php
/help/compendiumimport.php
/help/errorcodes.php
/help/index.php
/help/networkmap.php
/io/compendium/importcompendium.php
/ui/pages *.php
/ui/popup *.php

This is primarily envisaged for use for UI pages, like the header and footer pages and the homepage, 
where each site may want extensive changes to the original file.

NOTE: Most files in the ui/pages folder and in the /help folder, like about.php, privacy.php etc.
should not need replacing.
You can change the text displayed by changing the language file associated, 
using the language custom system (see the README.txt file in the language folder).

EXCLUSIONS: 
1. external libraries (found in /core/lib and ui/lib) that we use will not be included in this sytem,
so their 'include' and 'script' calls will not go through the FileLocationManager.
2. 'config.php' and the file it includes 'setup.php', cannot be overriden in custom.


2. OVERRIDE PART OF A FILE - Javascript 
If you want to include new additional javascript functions or variables 
or you want to override an existing function you can do this by loading additional files.
All headers files (found inside the theme system) will check for and load custom header 
(found inside the 'custom' folder) files which can include additional script statements or
variable declarations etc. for local interface additions or changes.

For exmaple, if you want to override a function in the ui/widget.js.php file you would add 
the following code into headerCustom.php: 

<script src='<?php echo $CFG->homeAddress; ?>custom/ui/widgetCustom.js.php' type="text/javascript"></script>

