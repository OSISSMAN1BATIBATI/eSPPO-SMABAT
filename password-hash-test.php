<?php
/**
 * We just want to hash our password using the current DEFAULT algorithm.
 * This is presently BCRYPT, and will produce a 60 character result.
 *
 * Beware that DEFAULT may change over time, so you would want to prepare
 * By allowing your storage to expand past 60 characters (255 would be good)
 */

$password = "5y5t3m";
echo "Kata Sandi: " . $password . "<br>";
echo "Hash Kata Sandi: " . password_hash($password, PASSWORD_DEFAULT);

?>