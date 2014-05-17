<?php

class BlogController extends \BaseController {

	/**
	 * Constructor. Injects blog object
	 *
	 * @return void
	 */
	public function __construct(Post $blog){
		$this->blog = $blog;
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$title = Input::get('title');
		$keywords = Input::get('meta-keywords');
		$body = Input::get('body');

		$data = array(
			'title' => $title,
			'meta-keywords' => $keywords,
			'body' => $body
			);

		$v = Validator::make($data, array(
			'title' => 'required|max:32',
			'body' => 'required'
			));

		if ($v->fails()) {
			$err = array('errors' => $v->messages());
			$response = Response::json($err, '400');
			return $response;
		}

		$this->blog->create($data);
		return Response::json($data, '200');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$title = Input::get('title');
		$keywords = Input::get('meta-keywords');
		$body = Input::get('body');

		$data = array(
			'title' => $title,
			'meta-keywords' => $keywords,
			'body' => $body
			);

		$v = Validator::make($data, array(
			'title' => 'max:32',
			));

		try{
			$post = $this->blog->findOrFail($id);
			foreach ($data as $key => $value) {
				if (Input::has($key))
					$post->$key = $value;
			}
			$post->save();
		} catch (Illuminate\Database\Eloquent\ModelNotFoundException $e) {
			Log::error($e);
			$errors = array('Post '.$id.' not found');
			return Response::json(array('errors'=> $errors), 404);
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		try{
			$post = $this->blog->findOrFail($id);
			$post->delete();
		} catch (Illuminate\Database\Eloquent\ModelNotFoundException $e) {
			Log::error($e);
			$errors = array('Post '.$id.' not found');
			return Response::json(array('errors'=> $errors), 404);
		}
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$posts = $this->blog->all();
		return Response::json($posts);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		try{
			$post = $this->blog->findOrFail($id);
			return Response::json($post);
		} catch (Illuminate\Database\Eloquent\ModelNotFoundException $e) {
			Log::error($e);
			$errors = array('Post '.$id.' not found');
			return Response::json(array('errors'=> $errors), 404);
		}
	}
}