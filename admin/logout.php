<?php
session_start();
session_destroy();
header('Location: /yonetim/giris');
exit;
?>
