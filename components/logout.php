<?php
    session_start();
    session_destroy();
    echo '<script>window.location="../components/login.php"</script>';
?>