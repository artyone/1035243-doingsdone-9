<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once 'functions/templates.php';

require_once 'functions/db/db.php';
require_once 'functions/db/project.php';
require_once 'functions/db/task.php';
require_once 'functions/db/user.php';

require_once 'functions/methods.php';

require_once 'functions/user.php';

require_once 'functions/validators/auth.php';
require_once 'functions/validators/registration.php';
require_once 'functions/validators/task.php';
require_once 'functions/validators/project.php';
require_once 'functions/validators/validators.php';

$config = require_once 'config.php';

const UPLOAD_DIR = __DIR__ . '/uploads/';
const RANGE_TOMORROW = 'tomorrow';
const RANGE_TODAY = 'today';
const RANGE_EXPIRED = 'expired';