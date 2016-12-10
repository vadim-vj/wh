<?php
/**
 * Common footer
 *
 * @author  Vadim Sannikov <vsj.vadim@gmail.com>
 * @version $id$
 * @link    ____link____
 */

if (!defined('BASE_DIR')) {
    error_reporting(E_ALL);
    ini_set('display_errors', true);

    throw new \LogicException('Footer: the "top.inc.php" file is not included.');
}

echo EOL . 'Local directory: ' . (IS_CLI ? '' : '<a href="' . LOCAL_URL . '" target="_blank">') 
    . getRelativeDirPath() . (IS_CLI ? '' : '</a>');
echo EOL . 'GitHub directory: ' . (IS_CLI ? '' : '<a href="' . GITHUB_URL . '" target="_blank">')
    . GITHUB_URL . (IS_CLI ? '' : '</a>') . EOL;
