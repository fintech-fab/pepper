<?php

use FintechFab\Pepper\Slack\Models\User;

/**
 * @var User[] $users
 */

?>

<?php
foreach ($users as $user) { ?>
    <a href="/web/user/<?= $user->_id ?>/settings"><?= $user->name ?></a>
<?php } ?>
