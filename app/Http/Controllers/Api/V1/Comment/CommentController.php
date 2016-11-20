<?php

namespace App\Http\Controllers\Api\V1\Comment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Repositories\CommentRepository;

class CommentController extends Controller
{
	protected $comment_repository;

	public function __construct(CommentRepository $comment_repository)
	{
		$this->comment_repository = $comment_repository;
	}

	public function create(Request $request)
	{
		$current_user = $request->user();

		$validator = Validator::make($request->all(), [
			'text' => ['required'],
			'post' => ['required','exists:posts,id'],
		]);

		if ($validator->fails()) {
			return response()->json(['error' => $validator->errors()->getMessages()], 400);
		}

		$data = [
			'text' => $request->get('text'),
			'post_id' => $request->get('post'),
			'user_id' => $current_user->id,
		];

		$post = $this->comment_repository->save($data);

		return response()->json(['success' => 'Comment created'], 200);
	}
}
