<?php
$input_password = '123456789';
$stored_hash = '$2y$10$89F/v1sDFP09K03e5ZDpZuJGOhqnh18a53mwEWwITt1vH/KFFHjZy';

if (password_verify($input_password, $stored_hash)) {
    echo "Match ✅";
} else {
    echo "Mismatch ❌";
}
?>
