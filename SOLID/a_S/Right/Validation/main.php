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

/**
 * validate
 *
 * @param mixed                                            $value     Value to validate
 * @param \SOLID\a_S\Right\Validation\Validator\IValidator $validator Certain validator
 *
 * @return string|void
 */
function validate($value, \SOLID\a_S\Right\Validation\Validator\IValidator $validator)
{
    return $validator->validate($value);
}

$errors = array();

if ('post' === strtolower($_SERVER['REQUEST_METHOD'])) {
    $profile = new \SOLID\a_S\Right\Validation\Profile();

    $errors['phone'] = empty($_POST['phone']) 
        ? 'Required field' 
        : validate($_POST['phone'], new \SOLID\a_S\Right\Validation\Validator\Phone());
    $errors['email'] = empty($_POST['email']) 
        ? 'Required field' 
        : validate($_POST['email'], new \SOLID\a_S\Right\Validation\Validator\Email());
    $errors = array_filter($errors);

    if (empty($errors)) {
        $profile->setPhone($_POST['phone']);
        $profile->setEmail($_POST['email']);

        $profile->getRepository()->insert($profile);
        $topMessage = 'Profile has been successfully created';
    }
}

?>

<!DOCTYPE html>
<html>
  <body>
    <?php if (!empty($topMessage)): ?>
      <span style="color: green;"><?php echo ($topMessage); ?></span>
    <?php endif; ?>
    <form method="post">
      <table cellpadding="2" cellspacing="2">
        <tr>
          <td><label for="phone">Phone:</label></td>
          <td><input id="phone" name="phone" value="<?php echo (isset($_POST['phone']) ? $_POST['phone'] : ''); ?>" /></td>
          <td>
            <?php if (!empty($errors['phone'])): ?>
              <span style="color: red;"><?php echo ($errors['phone']); ?></span>
            <?php endif; ?>
          </td>
        </tr>
        <tr>
          <td><label for="email">Email:</label></td>
          <td><input id="email" name="email" value="<?php echo (isset($_POST['email']) ? $_POST['email'] : ''); ?>" /></td>
          <td>
            <?php if (!empty($errors['email'])): ?>
              <span style="color: red;"><?php echo ($errors['email']); ?></span>
            <?php endif; ?>
          </td>
        </tr>
        <tr>
          <td colspan="3"><input type="Submit" value="Submit" /></td>
        </tr>
      </table>
    </form>
  </body>
</html>

<?php

require_once BASE_DIR . 'footer.php';
