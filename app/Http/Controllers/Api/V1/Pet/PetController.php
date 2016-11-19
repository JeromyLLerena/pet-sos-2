<?php

namespace App\Http\Controllers\Api\V1\Pet;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Repositories\PetRepository;
use App\Repositories\UserRepository;

class PetController extends Controller
{
	protected $pet_repository;
	protected $user_repository;

	public function __construct(PetRepository $pet_repository, UserRepository $user_repository)
	{
		$this->pet_repository = $pet_repository;
		$this->user_repository = $user_repository;
	}

	public function create(Request $request)
	{
		$user = $request->user();

		$validator = Validator::make($request->all(), [
			'pet_name'     => ['required'],
			'pet_age' => ['numeric'],
			'pet_height' => ['numeric']
		]);

		if ($validator->fails()) {
			return response()->json(['error' => $validator->errors()->getMessages()], 400);
		}

		$pet_data = [
			'name' => $request->get('pet_name'),
			'age' => $request->get('pet_age'),
			'height' => $request->get('pet_height'),
			'user_id' => $user->id,
			'race_id' => $request->get('pet_race')
		];

		if ($request->file('pet_photo')) {
			$pet_path = $user->id . '_' . str_random(20) . '.png';
			$request->file('pet_photo')->move('uploads', $pet_path);
			$pet_data ['photo_path'] = 'uploads/' . $pet_path;
		}

		$pet = $this->pet_repository->save($pet_data);

		return response()->json(['success' => 'Pet registered'], 200);
	}

	public function getAllUserPets(Request $request)
	{
		$user_model = $this->user_repository->getUserPets($request->user()->id);

		return $user_model;
	}
}
