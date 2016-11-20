<?php

namespace App\Repositories;

use DB;
use App\Models\Post;
use App\Repositories\EloquentRepository;

class PostRepository extends EloquentRepository
{
	protected $model;

	public function __construct()
	{
		$this->model = new Post;
	}

	public function all()
	{
		return $this->model->orderBy('created_at', 'desc')->with(['user', 'pet', 'post_type'])->get();
	}

	public function save($data)
	{
		$post = null;
		if (array_key_exists('id', $data)) {
			$post = $this->model->find($data['id']);
		} else {
			$post = $this->model;
		}

		if (array_key_exists('description', $data)) {
			$post->description = $data['description'];
		}

		if (array_key_exists('user_id', $data)) {
			$post->user_id = $data['user_id'];
		}

		if (array_key_exists('post_type_id', $data)) {
			$post->post_type_id = $data['post_type_id'];
		}

		if (array_key_exists('pet_id', $data)) {
			$post->pet_id = $data['pet_id'];
		}

		if (array_key_exists('status', $data)) {
			$post->status = $data['status'];
		}

		$post->save();

		return (object) $post->toArray();
	}
}