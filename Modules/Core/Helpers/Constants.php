<?php


const USER_GUARD = 'api';
const SELLER_GUARD = 'user-api';

/**
 * login transaction
 *
 * @author BaRaa
 */
define('LOGIN_TRANSACTION', 10001);

/**
 * logout transaction
 *
 * @author BaRaa
 */
define('LOGOUT_TRANSACTION', 10002);

/**
 * this is the key of error
 * response
 *
 * @author BaRaa
 */
define('ERROR_RESPONSE', false);
/**
 * this is the key of success
 * response
 *
 * @author BaRaa
 */
define('SUCCESS_RESPONSE', true);
/**
 * Http success status
 *
 * @author BaRaa
 */
define('SUCCESS_STATUS', true);


define('FAILURE_STATUS', false);


/**
 * INACTIVE status
 *
 * @author BaRaa
 */
define('INACTIVE', 0);
/**
 * ACTIVE status
 *
 * @author BaRaa
 */
define('ACTIVE', 1);

/**
 * SUCCESS STATUS
 *
 * @author BaRaa
 */
define('SUCCESS', 1);

/**
 * ERROR STATUS
 *
 * @author BaRaa
 */
define('ERROR', 0);

define('ENTERNAL_ERROR', 500);

/**
 * error : not found
 * Http status code
 *
 * @author BaRaa
 */
define('USER_NOT_FOUND', 100);
/**
 * error:  user is not active
 * Http status code
 *
 * @author BaRaa
 */
define('USER_NOT_ACTIVE', 101);
/**
 * error : not authorized access
 * Http status code
 *
 * @author BaRaa
 */
define('NOT_AUTHORIZED_ACCESS', 102);
/**
 * error : validation exception
 * Http status code
 *
 * @author BaRaa
 */
define('VALIDATION_EXCEPTION', 103);
/**
 * error : crud error
 * Http status code
 */
define('RESOURCE_MANIPULATION', 103);
/**
 * error : could not delete the resource 'cause it has
 * children
 * Http status code
 */
define('UNAUTHENTICATED_ERROR', 106);
/**
 * error : unknown database
 * Http status code
 */
define('UNKNOWN_DATABASE', 105);

/**
 * error : UNKNOWN_RELATION
 * Http status code
 */
define('UNKNOWN_RELATION', 107);

/**
 * error : DATABASE_CONNECTION_ERROR
 * Http status code
 */
define('DATABASE_CONNECTION_ERROR', 112);

/**
 * error :  INVALID INPUT
 * Http status code
 */
define('INVALID_INPUT', 106);

/**
 * error : database backup
 * Http status code
 */
define('BACKUP_ERROR', 1105);
/**
 * error : resource not found
 * Http status code
 */
define('RESOURCE_NOT_FOUND', 404);
/**
 * error : resource not found
 * Http status code
 */
define('UN_AUTHORIZED_EXCEPTION', 403);
/**
 * error : could not delete the resource 'cause it has
 * children
 * Http status code
 */
define('DELETE_CHILDREN_ERROR', 1106);
/**
 * error : invalid access code
 *
 * Http status code
 */
define('INVALID_ACCESS_CODE', 1107);
/**
 * error : error while creating database
 *
 * Http status code
 */
define('CREATE_DATABASE_ERROR', 1108);
/**
 *
 * error : INVALID TOKEN
 *
 * Http status code
 */
define('INVALID_TOKEN', 1109);

/**
 *
 * error : UPLOADING_ERROR
 *
 * Http status code
 */
define('UPLOADING_ERROR', 408);
/**
 *
 * error : REQUEST_EXPIRED
 *
 * Http status code
 */
define('REQUEST_EXPIRED', 419);
/**
 *
 * error : ORDER_NOT_FOUND_FINANCIAL
 *
 * Http status code
 */
define('ORDER_NOT_FOUND_FINANCIAL', 1100);
/**
 *
 * error : CAN_NOT_GET_ACCOUNT_CODE
 *
 * Http status code
 */
define('CAN_NOT_GET_ACCOUNT_CODE', 1102);

/**
 *
 * error : ACCOUNT_NOT_FOUND
 *
 * Http status code
 */
define('ACCOUNT_NOT_FOUND', 1103);

/**
 *
 * error : ACCOUNT_NOT_FOUND
 *
 * Http status code
 */
define('NOT_ENOUGH_CREDIT', 1104);


define('STATUS_CANCELED', 1104);

