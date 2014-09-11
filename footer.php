<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Common footer
 *
 * @author  Vadim Sannikov <vsj.vadim@gmail.com>
 * @version $id$
 * @link    ____link____
 */

if (!defined('BASE_DIR')) {
    throw new \LogicException('Footer: the "top.inc.php" file is not included.');
}

echo EOL . 'Local directory: ' . (IS_CLI ? '' : '<a href="' . LOCAL_URL . '" target="_blank">') 
    . getRelativeDirPath() . (IS_CLI ? '' : '</a>');
echo EOL . 'GitHub directory: ' . (IS_CLI ? '' : '<a href="' . GITHUB_URL . '" target="_blank">')
    . GITHUB_URL . (IS_CLI ? '' : '</a>') . EOL;
