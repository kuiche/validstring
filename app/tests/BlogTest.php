<?php

class BlogTest extends TestCase {

	public function setUp() {
	 	parent::setUp();
	 	$this->postmock = $this->mock('Post');
	}
	
	public function mock($class) {
		$mock = Mockery::mock($class);
		$this->app->instance($class, $mock);
		return $mock;
	}

	public function tearDown() {
		Mockery::close();
	}

	public function testIndex() {
		$testdata = array(
			array(
				'id' => 0,
				'title' => 'A',
				'meta-keywords' => 'a,b ,c, d',
				'body' => 'body text'
				),
			array(
				'id' => 1,
				'title' => 'B',
				'meta-keywords' => 'a',
				'body' => 'body text 2'
				),
			array(
				'id' => 2,
				'title' => 'C',
				'meta-keywords' => 'a',
				'body' => 'body text 3'
				),
			);

		$this->postmock->shouldReceive('all')
		->once()
		->andReturn($testdata);

		$controller = new BlogController($this->postmock);
		$controller->index();

		$this->postmock->shouldReceive('all')
		->once()
		->andReturn($testdata);
		$this->call('GET', 'api/v1/blog');
		$this->assertResponseOk();
	}

	public function testRetrieve() {
		$postmock = $this->postmock;
		$postmock->shouldReceive('findOrFail')
		->with(0)
		->once();
		$this->call('GET', 'api/v1/blog/0');
		$this->assertResponseOk();
		$this->client->restart();

		$postmock->shouldReceive('findOrFail')
		->with(1)
		->once();
		$this->call('GET', 'api/v1/blog/1');
		$this->assertResponseOk();
		$this->client->restart();

		$postmock->shouldReceive('findOrFail')
		->with(2)
		->once();
		$this->call('GET', 'api/v1/blog/2');
		$this->assertResponseOk();
		$this->client->restart();
	}

	public function testInvalidRetrieve() {
		$this->postmock
		->shouldReceive('findOrFail')
		->twice()
		->andThrow(new Illuminate\Database\Eloquent\ModelNotFoundException);
		
		$this->call('GET', 'api/v1/blog/invalidintegerlol');
		$this->assertResponseStatus('404');
		$this->client->restart();

		$this->call('GET', 'api/v1/blog/1');
		$this->assertResponseStatus('404');
	}

	public function testCreate() {
		$pm = $this->postmock;

		$pm->shouldReceive('create')
		->with(array(
			'title' => 'testTitle',
			'meta-keywords' => 'a,b,c',
			'body' => 'main'
			))
		->once()
		->andReturn($pm);

		$this->call('POST', 'api/v1/blog', array(
			'title' => 'testTitle',
			'meta-keywords' => 'a,b,c',
			'body' => 'main'
			));
		$this->assertResponseOk();
		$this->client->restart();

		$pm->shouldReceive('create')
		->never();

		$this->call('POST', 'api/v1/blog');
		$this->assertResponseStatus('400');
	}

	public function testDelete() {
		$pm = $this->postmock;

		$pm->shouldReceive('findOrFail')
		->with(1)
		->once()
		->andReturn($pm);
		$pm->shouldReceive('delete')
		->once();

		$this->call('DELETE', 'api/v1/blog/1');
		$this->assertResponseOk();
	}

	public function testInvalidDelete() {
		$pm = $this->postmock;

		$pm->shouldReceive('findOrFail')
		->with(1)
		->once()
		->andThrow(new Illuminate\Database\Eloquent\ModelNotFoundException);
		$pm->shouldReceive('delete')
		->never();

		$this->call('DELETE', 'api/v1/blog/1');
		$this->assertResponseStatus('404');
	}

	public function testUpdate() {
		$pm = $this->postmock;

		$pm->shouldReceive('findOrFail')
		->with(1)
		->once()
		->andReturn($pm);
		$pm->shouldReceive('setAttribute')
		->times(2);
		$pm->shouldReceive('save')
		->once();

		$this->call('PUT', 'api/v1/blog/1', array(
			'title' => 'testTitle',
			'body' => 'main'
			));
		$this->assertResponseOk();
	}

	public function testInvalidUpdate() {
		$pm = $this->postmock;

		$pm->shouldReceive('findOrFail')
		->with(1)
		->once()
		->andThrow(new Illuminate\Database\Eloquent\ModelNotFoundException);
		$pm->shouldReceive('setAttribute')
		->never();
		$pm->shouldReceive('save')
		->never();

		$this->call('PUT', 'api/v1/blog/1', array(
			'title' => 'testTitle',
			'body' => 'main'
			));
		$this->assertResponseStatus('404');
	}
}
