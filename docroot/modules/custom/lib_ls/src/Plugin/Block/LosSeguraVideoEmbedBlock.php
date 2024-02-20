<?php

namespace Drupal\lib_ls\Plugin\Block;

use Drupal\Core\Block\BlockBase;
<<<<<<< HEAD
use Drupal\Core\Form\FormInterface;
=======
>>>>>>> main

/**
 * Provides a 'LSVideoEmbedBlock' block.
 *
 * @Block(
 *  id = "ls_video_embed_block",
 *  admin_label = @Translation("LS video embed block"),
 * )
 */
class LosSeguraVideoEmbedBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {

    $build = [];
    $build['#theme'] = 'los_segura_video_embed_block';
    $build['los_segura_video_embed_block']['#markup'] = '';

    return $build;
  }

}
