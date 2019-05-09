<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once './bootstrapTest.php';

require_once './db/getProjectTest.php';
require_once './db/getProjectsTest.php';
require_once './db/getTasksTest.php';
require_once './db/getUserByIdTest.php';

require_once './validators/formDataFilterTest.php';
require_once './validators/isImportantTest.php';
require_once './validators/validateAuthFormTest.php';
require_once './validators/validateTaskFormTest.php';
require_once './validators/validateUserFormTest.php';

require_once './getParamTest.php';
require_once './buildProjectUrlTest.php';