<?php

namespace App\Repositories;

class EloquentRepository
{
	protected $model;

	public function find($id)
	{
		return $this->model->find($id) ? (object) $this->model->find($id)->toArray() : null;
	}

	public function all()
	{
		return $this->model->all()->transform(function($item, $key){
			return (object) $item->toArray();
		})->toArray();
	}

	public function delete($id)
	{
		$entity = $this->getModel($id);

		if ($entity) {
			$entity->delete();
			$response = $id;
		} else {
			$response = $entity;
		}

		return $response;
	}

	public function getModel($id)
	{
		return $this->model->find($id);
	}
}
