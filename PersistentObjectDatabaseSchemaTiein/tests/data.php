<?php
$res["testUnusualCall"] = '[34;1meZ components PersistentObject definition generator[0m[m
[0m[0m[0m[m
[0m[31;1mError while processing your options: Argument with name \'def dir\' is mandatory
but was not submitted.[0m[m
';

$res["testNoParameters"] = '[34;1meZ components PersistentObject definition generator[0m[m
[0m[0m[0m[m
[0m[31;1mError while processing your options: Argument with name \'def dir\' is mandatory
but was not submitted.[0m[m
[0m[0m[0m[m
[0m[34mUsage: $ PersistentObjectDatabaseSchemaTiein/src/rungenerator.php -s <string> -f
<string> [-o] [-p <string>] [-h] [--] <string:def dir> [<string:class dir>]
Generates defition files for the eZ PersistentObject package from eZ
DatabaseSchema formats. The directory to save the definition files to is
provided as an argument.

-s / --source       DatabaseSchema source to use.
-f / --format       DatabaseSchema format of the input source.
-o / --overwrite    Overwrite existing files.
-p / --prefix       Class prefix.
-h / --help         Retrieve detailed help about this application.
Arguments:          
<string:def dir>    PersistentObject definition directory.
<string:class dir>  Class directory.
[0m';


$res['testOnlySourceParameter'] = '[34;1meZ components PersistentObject definition generator[0m[m
[0m[0m[0m[m
[0m[31;1mError while processing your options: Argument with name \'def dir\' is mandatory
but was not submitted.[0m[m
[0m[0m[0m[m
[0m[34mUsage: $ PersistentObjectDatabaseSchemaTiein/src/rungenerator.php -s <string> -f
<string> [-o] [-p <string>] [-h] [--] <string:def dir> [<string:class dir>]
Generates defition files for the eZ PersistentObject package from eZ
DatabaseSchema formats. The directory to save the definition files to is
provided as an argument.

-s / --source       DatabaseSchema source to use.
-f / --format       DatabaseSchema format of the input source.
-o / --overwrite    Overwrite existing files.
-p / --prefix       Class prefix.
-h / --help         Retrieve detailed help about this application.
Arguments:          
<string:def dir>    PersistentObject definition directory.
<string:class dir>  Class directory.
[0m';


$res['testOnlyFormatParameter'] = '[34;1meZ components PersistentObject definition generator[0m[m
[0m[0m[0m[m
[0m[31;1mError while processing your options: Argument with name \'def dir\' is mandatory
but was not submitted.[0m[m
[0m[0m[0m[m
[0m[34mUsage: $ PersistentObjectDatabaseSchemaTiein/src/rungenerator.php -s <string> -f
<string> [-o] [-p <string>] [-h] [--] <string:def dir> [<string:class dir>]
Generates defition files for the eZ PersistentObject package from eZ
DatabaseSchema formats. The directory to save the definition files to is
provided as an argument.

-s / --source       DatabaseSchema source to use.
-f / --format       DatabaseSchema format of the input source.
-o / --overwrite    Overwrite existing files.
-p / --prefix       Class prefix.
-h / --help         Retrieve detailed help about this application.
Arguments:          
<string:def dir>    PersistentObject definition directory.
<string:class dir>  Class directory.
[0m';


$res['testFormatSourceParameter'] = '[34;1meZ components PersistentObject definition generator[0m[m
[0m[0m[0m[m
[0m[31;1mError while processing your options: Argument with name \'def dir\' is mandatory
but was not submitted.[0m[m
[0m[0m[0m[m
[0m[34mUsage: $ PersistentObjectDatabaseSchemaTiein/src/rungenerator.php -s <string> -f
<string> [-o] [-p <string>] [-h] [--] <string:def dir> [<string:class dir>]
Generates defition files for the eZ PersistentObject package from eZ
DatabaseSchema formats. The directory to save the definition files to is
provided as an argument.

-s / --source       DatabaseSchema source to use.
-f / --format       DatabaseSchema format of the input source.
-o / --overwrite    Overwrite existing files.
-p / --prefix       Class prefix.
-h / --help         Retrieve detailed help about this application.
Arguments:          
<string:def dir>    PersistentObject definition directory.
<string:class dir>  Class directory.
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
[0m[0m[0m[m
[0m';

$res['testDuplicateWriteFromFileSuccess'] = '[34;1meZ components PersistentObject definition generator[0m[m
[0m[0m[0m[m
[0m[34;1mPersistentObject definition successfully written to';

$res['testValidFromDb'] = '[34;1meZ components PersistentObject definition generator[0m[m
[0m[0m[0m[m
[0m[34;1mPersistentObject definition successfully written to';

$res['testInvalidFromDb'] = '[34;1meZ components PersistentObject definition generator[0m[m
[0m[0m[0m[m
[0m[31;1mError reading schema: ';

$res['testValidFromFileWithClasses'] = '[34;1meZ components PersistentObject definition generator[0m[m
[0m[0m[0m[m
[0m[34;1mPersistentObject definition successfully written to
[0m[34;1mClass files successfully written to
[0m';

$res['testValidFromFileWithClassesAndPrefix'] = '[34;1meZ components PersistentObject definition generator[0m[m
[0m[0m[0m[m
[0m[34;1mPersistentObject definition successfully written to
[0m[34;1mClass files successfully written to
[0m';

return $res;

?>
