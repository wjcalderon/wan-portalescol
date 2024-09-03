<?php

namespace Drupal\liberty_claims\traits;

use GuzzleHttp\Client;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\GenericProvider;
use League\OAuth2\Client\Token\AccessTokenInterface;

trait GetTokens
{
  /**
   * Gets the car shops service token.
   *
   * @throws Exception
   * @return string CESVI token.
   */
  private function getCesviToken(): string {
    $cid = 'claims:cesvi_token';

    $base_uri = 'base_uri';
    $cesvi_endpoint = 'fnol/autenticacionCesvi';

    if ($cache = $this->cacheManager->get($cid)) {
      return $cache->data;
    }

    $client = new Client([
      'base_uri' => $this->getConnectionData($base_uri),
    ]);

    try {
      $response = $client->request(
        'POST',
        $cesvi_endpoint,
        [
          'http_errors' => true,
          'headers' => [
            'Content-Type' => 'application/json',
            'Authorization' =>
            'Bearer ' . $this->getMainToken(),
          ],
          'body' => json_encode([
            "username" => $this->getConnectionData('username'),
            "password" => $this->getConnectionData('password')
          ]),
        ]
      );

      $body = $response->getBody()->getContents();
      $json = json_decode($body);

      if (@$json->access_token) {
        $request_time = \Drupal::time()->getRequestTime();
        $this->cacheManager->set($cid, $json->access_token, $request_time + $json->expires_in);

        return $json->access_token;
      }
    } catch (\Exception $e) {
      $this->drupalLogger->error($e->getMessage());
      return '';
    }
  }

  /**
   * Gets the main token from cache or request a new one.
   *
   * @access private
   * @return string The token.
   */
  private function getMainToken(): string {
    $cid = 'claims:main_token';
    if ($cache = $this->cacheManager->get($cid)) {
      return $cache->data;
    }
    $access_token = $this->getProviderToken();
    $this->cacheManager->set($cid, $access_token->getToken(), $access_token->getExpires());

    return $access_token->getToken();
  }

  /**
   * Get token from provider.
   *
   * @access private
   * @throws IdentityProviderException
   * @return AccessTokenInterface
   */
  private function getProviderToken(): AccessTokenInterface {
    $client_id = $this->getConnectionData('validate_plate_token');
    $client_secret = $this->getConnectionData('client_secret');
    $token_uri = $this->getConnectionData('token_uri');

    $provider = new GenericProvider([
      'clientId' => $client_id,
      'clientSecret' => $client_secret,
      'redirectUri' => '',
      'urlAuthorize' => '',
      'urlAccessToken' => $token_uri,
      'urlResourceOwnerDetails' => '',
    ]);

    try {
      $accessToken = $provider->getAccessToken('client_credentials');
    } catch (IdentityProviderException $e) {
      $this->drupalLogger->error($e->getMessage());
    }

    return $accessToken;
  }
}

