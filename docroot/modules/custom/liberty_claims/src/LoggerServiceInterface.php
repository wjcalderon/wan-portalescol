<?php

namespace Drupal\liberty_claims;

/**
 * Interface LoggerServiceInterface.
 */
interface LoggerServiceInterface {

  /**
   * Starts a new log activity register.
   *
   * @param string $plate
   *   Plate number.
   * @param string $token
   *   Token id for the activity.
   */
  public function logActivity(string $plate, string $token);

  /**
   * Update fields to an activity log.
   *
   * @param string $field
   *   Field or fields to be updated.
   * @param string $value
   *   New value for the field.
   * @param string $token
   *   Primary key of the field.
   */
  public function set(string $field, string $value, $token);

  /**
   * Update multiple fields in activity logs.
   *
   * @param array $fields
   *   MultiArray in the form field_name => value.
   *   i.e ['plate' => 'XXX123', 'document_id' => 123].
   * @param string $token
   *   Primary key of the fields.
   */
  public function setMultiple(array $fields, string $token);

}
