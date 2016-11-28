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

	public function getApplicationPosts($filters)
	{
		$res = $this->model->orderBy('created_at', 'desc')->with(['user', 'pet', 'post_type']);

		if ($filters['keyword']) {
			$res = $res->where('description', 'like', '%' . $filters['keyword'] . '%');
		}

		if ($filters['animal'] && !$filters['pet_race']) {
			$res = $res->whereHas('pet', function($query) use ($filters){
				$query->whereHas('race', function($second_query) use ($filters){
					$second_query->where('animal_id', $filters['animal']);
				});
			});
		}

		if ($filters['pet_race']) {
			$res = $res->whereHas('pet', function($query) use ($filters){
				$query->where('race_id', $filters['pet_race']);
			});
		}

		if ($filters['pet_height']) {
			$res = $res->whereHas('pet', function($query) use ($filters){
				$query->where('height', $filters['pet_height']);
			});
		}

		if ($filters['post_type']) {
			$res = $res->where('post_type_id', $filters['post_type']);
		}

		return $res->get()->transform(function($item, $key){
				$tmp = $item;
				$tmp->comments_count = $item->comments()->count();

				return $tmp;
		});
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