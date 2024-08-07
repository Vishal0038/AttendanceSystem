<?php

// Define the encryption method
define('ENCRYPTION_METHOD', 'aes-256-cbc');

// Define a secret key (ensure this is securely stored and handled)
define('SECRET_KEY', 'your-secret-key');
define('SECRET_IV', 'your-secret-iv'); // Initialization vector

/**
 * Encrypts a string.
 *
 * @param string $data The data to encrypt.
 * @return string The encrypted data.
 */
function encrypt($data) {
    $key = hash('sha256', SECRET_KEY);
    $iv = substr(hash('sha256', SECRET_IV), 0, 16);
    
    $encrypted = openssl_encrypt($data, ENCRYPTION_METHOD, $key, 0, $iv);
    return base64_encode($encrypted);
}

/**
 * Decrypts a string.
 *
 * @param string $data The data to decrypt.
 * @return string The decrypted data.
 */
function decrypt($data) {
    $key = hash('sha256', SECRET_KEY);
    $iv = substr(hash('sha256', SECRET_IV), 0, 16);
    
    $decrypted = openssl_decrypt(base64_decode($data), ENCRYPTION_METHOD, $key, 0, $iv);
    return $decrypted;
}

// Usage example:
$originalData = "Sensitive data to encrypt";
echo "Original Data: " . $originalData . "\n";

$encryptedData = encrypt($originalData);
echo "Encrypted Data: " . $encryptedData . "\n";

$decryptedData = decrypt($encryptedData);
echo "Decrypted Data: " . $decryptedData . "\n";

?>
