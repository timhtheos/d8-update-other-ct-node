<?php
/**
 * Next service awesome controller.
 */

namespace Drupal\next_service\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class NsController.
 */
class NsController extends ControllerBase {
  
  /**
   * Update CT device.
   *
   * @param object $node
   *   Node entity object.
   *
   * @return null
   *   Nothing is returned.
   */
  function updateDevice($node) {
    // We get the node id referenced in field_device in CT worklog.
    // Not tested. Please check, xD.
    $nid_device = $node->get('field_device')
      ->first() // If multiple. I'm not sure if this is needed or ok if stays as-is if the cardinality is 1.
      ->get('entity')
      ->getTarget()
      ->getValue()
      ->id();

    // Load CT device.
    $node_device = $this->loadNode($nid_device);

    $node_device->set('field_next_step', $node->get('title')->value);

    // Save/update node in CT device.
    $node_device->save();
  }

  /**
   * Load node by node id.
   *
   * @param int $nid
   *   Node id.
   *
   * @return object
   *   Node object.
   */
  function loadNode($nid) {
    $node = \Drupal::entityTypeManager()->getStorage('node')->load($nid);
    return $node;
  }
}
