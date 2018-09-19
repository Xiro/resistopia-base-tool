<?php
file_put_contents(__DIR__ . '/lock.txt', $_GET['lock']);

echo '<br><br><br><br><div style="text-align: center"><h1>';
if($_GET['lock']) {
    echo 'SYSTEM LOCKED';
} else {
    echo 'SYSTEM UNLOCKED';
}
echo '</h1></div>';