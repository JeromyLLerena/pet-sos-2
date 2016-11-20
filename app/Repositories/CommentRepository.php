<?php

namespace App\Repositories;

use DB;
use App\Models\Comment;
use App\Repositories\EloquentRepository;

class CommentRepository extends EloquentRepository
{
	protected $model;

	public function __construct()
	{
		$this->model = new Comment;
	}

	public function all()
	{
		return $this->model->all();
	}

	public function save($data)
	{
		$comment = null;
		if (array_key_exists('id', $data)) {
			$comment = $this->model->find($data['id']);
		} else {
			$comment = $this->model;
		}

		if (array_key_exists('text', $data)) {
			$comment->text = $data['text'];
		}

		if (array_key_exists('user_id', $data)) {
			$comment->user_id = $data['user_id'];
		}

		if (array_key_exists('post_id', $data)) {
			$comment->post_id = $data['post_id'];
		}

		if (array_key_exists('status', $data)) {
			$comment->status = $data['status'];
		}

		$comment->save();

		return (object) $comment->toArray();
	}
}