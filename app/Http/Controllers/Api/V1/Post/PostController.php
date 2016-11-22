<?php

namespace App\Http\Controllers\Api\V1\Post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Repositories\PostRepository;
use App\Repositories\UserRepository;

class PostController extends Controller
{
	protected $post_repository;
	protected $user_repository;
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(PostRepository $post_repository, UserRepository $user_repository)
	{
		$this->post_repository = $post_repository;
		$this->user_repository = $user_repository;
	}

	public function getApplicationPosts(Request $request)
	{
		$filters = [
			'keyword' => $request->has('keyword') ? $request->get('keyword') : null,
			'pet_race' => $request->has('pet_race') ? $request->get('pet_race') : null,
			'pet_height' => $request->has('pet_height') ? $request->get('pet_height') : null,
			'post_type' => $request->has('post_type') ? $request->get('post_type') : null
		];

		return response()->json(['success' => ['posts' => $this->post_repository->getApplicationPosts($filters)]], 200);
	}

	public function getUserPosts(Request $request)
	{
		$current_user = $request->user();

		$posts = $this->user_repository->getUserPosts($current_user->id);

		return response()->json(['success' => ['posts' => $posts]], 200);
	}

	public function create(Request $request)
	{
		$current_user = $request->user();

		$validator = Validator::make($request->all(), [
			'description' => ['required'],
			'post_type' => ['required','numeric'],
			'pet' => ['required', 'exists:pets,id']
		]);

		if ($validator->fails()) {
			return response()->json(['error' => $validator->errors()->getMessages()], 400);
		}

		$data = [
			'description' => $request->get('description'),
			'post_type_id' => $request->get('post_type'),
			'pet_id' => $request->get('pet'),
			'user_id' => $current_user->id,
		];

		$post = $this->post_repository->save($data);

		return response()->json(['success' => 'Post created'], 200);
	}

	public function getPostComments(Request $request, $post_id)
	{
		$post = $this->post_repository->getModel($post_id);

		return response()->json(['success' => ['post' => $post->with(['user', 'pet'])->where('id', $post_id)->first(), 'comments' => $post->comments()->with('user')->get()]], 200);
	}
}
