<?php
echo password_hash('123456',PASSWORD_BCRYPT);
	$hash='$2y$10$9jyrYrnLaQ2nlRVLhhPbb.Ud0UtgPVqbMHuXmcoSpNiMPOZQhLl5O';
	$pass='123456';
	if (password_verify('123456', $hash)) {
    echo 'Password is valid!';
} else {
    echo 'Invalid password.';
}
?>
