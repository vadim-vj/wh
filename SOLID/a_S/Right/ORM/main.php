<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Usage example
 *
 * @author  Vadim Sannikov <vsj.vadim@gmail.com>
 * @version $id$
 * @link    ____link____
 */

require_once '../../../../top.inc.php';

$entity = new \SOLID\a_S\Right\ORM\Entity();
$repository = $entity->getRepository();

echo 'Entity::PropertyA: "' . $entity->getPropertyA() . '"' . EOL;
echo 'Entity::PropertyB: '  . $entity->getPropertyB() . EOL;

echo EOL . 'Set new values for properties' . EOL . EOL;
$entity->setPropertyA('New value');
$entity->setPropertyB(456);

echo 'Entity::PropertyA: "' . $entity->getPropertyA() . '"' . EOL;
echo 'Entity::PropertyB: '  . $entity->getPropertyB() . EOL;

echo EOL . 'Perform DB operations' . EOL . EOL;

$repository->insert($entity);
echo 'Insert entity...' . EOL;

$repository->update($entity);
echo 'Update entity...' . EOL;

$repository->remove($entity);
echo 'Remove entity...' . EOL;

require_once BASE_DIR . 'footer.php';
