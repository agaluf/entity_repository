<?php

namespace Drupal\entity_repository\Repository;

use Drupal\Core\Entity\EntityRepository;
use Drupal\Core\Entity\EntityHandlerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Language\LanguageManagerInterface;

/**
 * We would want to implement the EntityHandlerInterface directly,
 * as the EntityRepository would be our default fallback for the handler.
 */
class UserRepository extends EntityRepository implements EntityHandlerInterface {

	/**
	 * @var \Drupal\Core\Entity\EntityStorageInterface
	 *   The user storage
	 */
	protected $storage;

	/**
	 * {@inheritdoc}
	 */
  public function __construct(EntityTypeManagerInterface $entity_type_manager, LanguageManagerInterface $language_manager, EntityTypeInterface $entity_type) {
  	parent::__construct($entity_type_manager, $language_manager);

  	$this->storage = $entity_type_manager->getStorage($entity_type->id());
  }

  /**
   * {@inheritdoc}
   */
	public static function createInstance(ContainerInterface $container, EntityTypeInterface $entity_type) {
		return new static(
			$container->get('entity_type.manager'),
			$container->get('language_manager'),
			$entity_type
		);
	}

	/**
	 * Sample custom loader.
	 */
	public function loadByMail($mail) {
		$users = $this->storage->loadByProperties([
			'mail' => $mail,
		]);
		return $users;
	}

}
