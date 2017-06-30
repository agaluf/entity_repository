<?php

namespace Drupal\entity_repository\Controller;

use Drupal\Core\Controller\ControllerBase;

class ExperimentController extends ControllerBase {

	public function experiment() {

		$repository = $this->entityTypeManager()->getHandler('user', 'repository');

		$mail = ''; // Insert your user's mail here;

		$users = $repository->loadByMail($mail);

		$names = [];
		foreach ($users as $user) {
			$names[] = $user->label();
		}

		$output['items'] = [
			'#theme' => 'item_list',
			'#title' => 'Found users',
			'#items' => $names,
			'#list_type' => 'ol',
			'#cache' => [
				'max-age' => 0,
			],
		];

		return $output;
	}

}
