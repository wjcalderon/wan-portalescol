# SFTP Client

The SFTP client for programmatic use.
<!--break-->

## Usage

- Configure SFTP connections in `settings.php`.

  ```php
  /* @see \Drupal\sftp_client\SftpClientInterface::setSettings() */
  $settings['sftp'] = [
    // The default connection (the `sftp` key is mandatory to be the default).
    'sftp' => [
      'server' => 'sftp.example.com',
      'username' => 'john',
      'password' => '',
      // Requires `key` module to be installed and enabled.
      'key_id' => 'sftp_identity',
    ],
    'my_connection' => [
      'server' => 'sftp.example.com',
      'username' => 'john',
      'password' => 'Passw0rd!',
    ],
  ];
  ```

- Use the client.

  ```php
  // May throw if one or more connections have non-empty `key_id`
  // and the `key` module is not enabled.
  /* @var \Drupal\sftp_client\SftpClientInterface $sftp_client */
  $sftp_client = \Drupal::service('sftp_client');

  // Check whether the path is a directory using the default connection.
  var_dump($sftp_client->isDir('/path/to/file.txt'));

  // Switch the connection.
  $sftp_client->setSettings('my_connection');

  // Download the file using the `my_connection`.
  var_dump($sftp_client->downloadFile('/path/to/file.txt', '/tmp'));

  // Switch back to the default connection.
  $sftp_client->setSettings();
  ```
