<?php

/**
 * @file
 * Contains \Drupal\required_by_role\Tests\Plugin\Required\RequiredByRoleTest.
 */

namespace Drupal\required_by_role\Tests\Plugin\Required;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\Transliteration\PHPTransliteration;
use Drupal\Tests\UnitTestCase;
use Drupal\required_by_role\Plugin\Required\RequiredByRole;

/**
 * Tests the requird_by_role plugin.
 *
 * @group Required API
 * @see \Drupal\required_by_role\Plugin\RequiredByRoleTest
 */
class RequiredByRoleTest extends UnitTestCase {

  /**
   * The required plugin.
   *
   * @var \Drupal\required_by_role\Plugin\Required\RequiredByRole
   */
  protected $plugin;

  /**
   * Method getInfo.
   *
   * @return array
   *   Information regarding to the tests.
   */
  public static function getInfo() {
    return array(
      'name' => 'Required by role plugin',
      'description' => 'Test the required by role logic.',
      'group' => 'Required API',
    );
  }

  /**
   * Caching the plugin instance in the $plugin property.
   */
  public function setUp() {

    $this->plugin = $this->getMockBuilder('Drupal\required_by_role\Plugin\Required\RequiredByRole')
      ->disableOriginalConstructor()
      ->setMethods(NULL)
      ->getMock();
  }

  /**
   * Tests the required by role behavior.
   *
   * @dataProvider getRequiredCases
   */
  public function testRequiredByRole($result, $user_roles, $required_roles) {

    $required = $this->plugin->getMatches($user_roles, $required_roles);
    $this->assertEquals($result, $required);

  }

  /**
   * Provides a cases to test.
   */
  public function getRequiredCases() {

    // array(bool $result, array $user_roles, array $required_roles)
    return array(
      // User with matching roles.
      array(
        TRUE,
        array(
          'authenticated',
          'administrator',
        ),
        array(
          'administrator',
        ),
      ),
      // User with no matching roles.
      array(
        FALSE,
        array(
          'authenticated',
          'administrator',
        ),
        array(
          'anonymous',
        ),
      ),
      // No required roles set.
      array(
        FALSE,
        array(
          'authenticated',
          'administrator',
        ),
        array(),
      ),
      // Required roles is not an array.
      array(
        FALSE,
        array(
          'authenticated',
          'administrator',
        ),
        NULL,
      ),
      // The user has no roles.
      array(
        FALSE,
        NULL,
        array(
          'authenticated',
          'administrator',
        ),
      ),
      // The user has no roles and there is no required roles.
      array(
        FALSE,
        NULL,
        NULL,
      ),
    );
  }

}
