<?php

use FintechFab\Pepper\Slack\Models\User;

/**
 * @var User $user
 */

$redmine = $user->redmine;
if (!$redmine) {
    $redmine = (object)[
        'key'     => '',
        'user_id' => 0,
    ];
}

?>


<!--suppress ALL -->
<form action="/web/user/<?= $user->id ?>/settings" method="POST">

    <table style="border: 0; border-collapse: collapse;">
        <tr>
            <td>Ключ Redmine [<?= $redmine->user_id ?>]</td>
            <td><input type="text" name="redmine-key" value="<?= $redmine->key ?>"></td>
        </tr>
        <tr>
            <td></td>
            <td>
                <button type="submit">submit</button>
            </td>
        </tr>
    </table>

</form>


<style>
    td {
        padding: 5px;
        margin: 0;
    }

    input {
        width: 400px;
    }
</style>