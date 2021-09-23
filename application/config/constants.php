<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',              'rb');
define('FOPEN_READ_WRITE',            'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',    'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',  'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',          'ab');
define('FOPEN_READ_WRITE_CREATE',        'a+b');
define('FOPEN_WRITE_CREATE_STRICT',        'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',    'x+b');



// zoho settings
define('ZOHO_CLIENT_ID', '1000.TWQWMZG2S307K1PRKEMVURBXLI7G9K');
define('ZOHO_CLIENT_SECRET', '515ba4b772b8a2f4a13c8719855063587561f34873');
define('ZOHO_REDIRECT', 'https://souvik.campuscarddev.com/roadmapautomation');
define('ZOHO_SCOPE', 'Desk.search.READ,Desk.contacts.READ,Desk.tasks.READ,Desk.tickets.READ,Desk.basic.READ,Desk.settings.READ,Desk.tickets.UPDATE');
define('ZOHO_DESK_API', 'https://desk.zoho.com/api/v1/');
define('ZOHO_ACCOUNT_API', 'https://accounts.zoho.com/oauth/v2/');
define('ZOHO_ORG_ID', '691897978');
define('ZOHO_TICKET_STATUS', 'TEST');


/* End of file constants.php */
/* Location: ./application/config/constants.php */