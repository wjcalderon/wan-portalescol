<?php

namespace Drupal\lib_core;

/**
 * Chat Manager Interface.
 */
interface ChatManagerInterface {

  /**
   * Injects the chat script and manage variables.
   */
  public function addChat($parameters);

}
