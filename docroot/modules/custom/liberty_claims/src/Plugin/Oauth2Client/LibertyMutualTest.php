<?php

namespace Drupal\liberty_claims\Plugin\Oauth2Client;

use Drupal\oauth2_client\Plugin\Oauth2Client\Oauth2ClientPluginBase;

/**
 * OAuth2 Client to authenticate with LibertyMutualTest.
 *
 * @Oauth2Client(
 *   id = "liberty_test",
 *   name = @Translation("LibertyMutualTest"),
 *   grant_type = "client_credentials",
 *   client_id = "Bp5lhCcuSY7BTGooiJTHCKCBJ5cR6tZg",
 *   client_secret = "4eYe3Av0plTQMVkH",
 *   authorization_uri = "",
 *   token_uri = "https://test-apis.libertymutual.com/oauth/access-token",
 *   resource_owner_uri = "",
 *   scope_separator = ",",
 * )
 */
class LibertyMutualTest extends Oauth2ClientPluginBase {}
