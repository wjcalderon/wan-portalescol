<?php

namespace Drupal\liberty_claims\Plugin\Oauth2Client;

use Drupal\oauth2_client\Plugin\Oauth2Client\Oauth2ClientPluginBase;

/**
 * OAuth2 Client to authenticate with LibertyMutualTest.
 *
 * @Oauth2Client(
 *   id = "liberty_live",
 *   name = @Translation("LibertyMutualLive"),
 *   grant_type = "client_credentials",
 *   client_id = "Z7jHwGz5AAUYAHXEyECf0ztdwO1Uxngl",
 *   client_secret = "e1QpsyECAEWfUrAA",
 *   authorization_uri = "",
 *   token_uri = "https://apis.libertymutual.com/oauth/access-token",
 *   resource_owner_uri = "",
 *   scope_separator = ",",
 * )
 */
class LibertyMutualLive extends Oauth2ClientPluginBase {}
