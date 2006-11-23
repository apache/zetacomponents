<?php
ezcTestRunner::addFileToFilter( __FILE__ );

$res["testUnusualCall"] = '[34;1meZ components PersistentObject definition generator[0m[m
[0m[0m[0m[m
[0m[31;1mError while processing your options: Option with long name \'source\' is mandatory
but was not submitted.[0m[m
[0m[0m[0m[m
[0m[34mUsage: $
/home/dotxp/dev/ez/ezcomponents/trunk/PersistentObjectDatabaseSchemaTiein/src/ru
ngenerator.php -s <string> -f <string> [-e] [-h]  [[--] <args>]
Generates defition files for the eZ PersistentObject package from eZ
DatabaseSchema formats. The directory to save the definition files to is
provided as an argument.

-s / --source  DatabaseSchema source to use.
-f / --format  DatabaseSchema format of the input source.
-e / --empty   Empty directory before writing.
-h / --help    Retrieve detailed help about this application.
[0m';

$res["testNoParameters"] = '[34;1meZ components PersistentObject definition generator[0m[m
[0m[0m[0m[m
[0m[31;1mError while processing your options: Option with long name \'source\' is mandatory
but was not submitted.[0m[m
[0m[0m[0m[m
[0m[34mUsage: $ PersistentObjectDatabaseSchemaTiein/src/rungenerator.php -s <string> -f
<string> [-e] [-h]  [[--] <args>]
Generates defition files for the eZ PersistentObject package from eZ
DatabaseSchema formats. The directory to save the definition files to is
provided as an argument.

-s / --source  DatabaseSchema source to use.
-f / --format  DatabaseSchema format of the input source.
-e / --empty   Empty directory before writing.
-h / --help    Retrieve detailed help about this application.
[0m';


$res['testOnlySourceParameter'] = '[34;1meZ components PersistentObject definition generator[0m[m
[0m[0m[0m[m
[0m[31;1mError while processing your options: Option with long name \'format\' is mandatory
but was not submitted.[0m[m
[0m[0m[0m[m
[0m[34mUsage: $ PersistentObjectDatabaseSchemaTiein/src/rungenerator.php -s <string> -f
<string> [-e] [-h]  [[--] <args>]
Generates defition files for the eZ PersistentObject package from eZ
DatabaseSchema formats. The directory to save the definition files to is
provided as an argument.

-s / --source  DatabaseSchema source to use.
-f / --format  DatabaseSchema format of the input source.
-e / --empty   Empty directory before writing.
-h / --help    Retrieve detailed help about this application.
[0m';


$res['testOnlyFormatParameter'] = '[34;1meZ components PersistentObject definition generator[0m[m
[0m[0m[0m[m
[0m[31;1mError while processing your options: Option with long name \'source\' is mandatory
but was not submitted.[0m[m
[0m[0m[0m[m
[0m[34mUsage: $ PersistentObjectDatabaseSchemaTiein/src/rungenerator.php -s <string> -f
<string> [-e] [-h]  [[--] <args>]
Generates defition files for the eZ PersistentObject package from eZ
DatabaseSchema formats. The directory to save the definition files to is
provided as an argument.

-s / --source  DatabaseSchema source to use.
-f / --format  DatabaseSchema format of the input source.
-e / --empty   Empty directory before writing.
-h / --help    Retrieve detailed help about this application.
[0m';


$res['testFormatSourceParameter'] = '[34;1meZ components PersistentObject definition generator[0m[m
[0m[0m[0m[m
[0m[31;1mThe directory to save the PersistentObject definitions to is required as an
argument.[0m[m
[0m[0m[0m[m
[0m[34mUsage: $ PersistentObjectDatabaseSchemaTiein/src/rungenerator.php -s <string> -f
<string> [-e] [-h]  [[--] <args>]
Generates defition files for the eZ PersistentObject package from eZ
DatabaseSchema formats. The directory to save the definition files to is
provided as an argument.

-s / --source  DatabaseSchema source to use.
-f / --format  DatabaseSchema format of the input source.
-e / --empty   Empty directory before writing.
-h / --help    Retrieve detailed help about this application.
[0m';


$res['testInvalidFormat'] = '[34;1meZ components PersistentObject definition generator[0m[m
[0m[0m[0m[m
[0m[31;1mError reading schema: There is no \'read\' handler available for the \'test\'
format.[0m[m
[0m[0m[0m[m
[0m';


$res['testInvalidSource'] = '[34;1meZ components PersistentObject definition generator[0m[m
[0m[0m[0m[m
[0m[31;1mError reading schema: The schema file \'test\' could not be found.[0m[m
[0m[0m[0m[m
[0m';


$res['testInvalidDestination'] = '[34;1meZ components PersistentObject definition generator[0m[m
[0m[0m[0m[m
[0m[31;1mError writing schema: The directory file \'test\' could not be found.[0m[m
[0m[0m[0m[m
[0m';


$res['testValidFromFile'] = '[34;1meZ components PersistentObject definition generator[0m[m
[0m[0m[0m[m
[0m[34;1mPersistentObject definition successfully written to';

$res['testDuplicateWriteFromFileFailure'] = '[34;1meZ components PersistentObject definition generator[0m[m
[0m[0m[0m[m
[0m[31;1mError writing schema: An error occurred while writing to
[0m';

$res['testDuplicateWriteFromFileSuccess'] = '[34;1meZ components PersistentObject definition generator[0m[m
[0m[0m[0m[m
[0m[34;1mPersistentObject definition successfully written to';

$res['testValidFromDb'] = '[34;1meZ components PersistentObject definition generator[0m[m
[0m[0m[0m[m
[0m[34;1mPersistentObject definition successfully written to';

return $res;

?>
