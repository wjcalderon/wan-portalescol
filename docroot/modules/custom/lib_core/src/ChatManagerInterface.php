<?php

namespace Drupal\lib_core;

/**
 * Chat Manager Interface
 */
interface ChatManagerInterface {

  /**
   * Injects the chat script and manage variables.
   *
   * @param $parameters
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  public function addChat($parameters);

}
