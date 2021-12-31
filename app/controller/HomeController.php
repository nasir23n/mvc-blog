<?php

namespace App\Controller;

use System\Core\DB;
use System\Core\Request;

class HomeController extends Controller {
	public Request $request;
	public function index() {
		$post = $this->db->query('SELECT * FROM post');
		$this->data['title'] = 'This is page title';
		$this->data['posts'] = $post;
		view('inc/header');
		view('inc/nav');
		view('pages/home', $this->data);
		view('inc/footer');
	}
	public function show() {
		if (isset($_GET['id'])) {
			$post = $this->db->get_where('post', ['id' => $_GET['id']]);
			$this->data['title'] = 'This is page title';
			$this->data['post'] = $post[0];
			view('inc/header');
			view('inc/nav');
			view('pages/single', $this->data);
			view('inc/footer');
		}
	}
	public function store(Request $request) {
		$body = $request->getBody();
		$this->db->insert('post', [
			'title' => $body['title'],
			'body' => $body['body']
		]);
		redirect(base_url())->with('message', 'Post Create Successfully!');
	}

	public function edit(Request $request) {
		if (isset($_GET['id'])) {
			$body = $request->getBody();
			$result = $this->db->get_where('post', ['id' => $body['id']]);
			$post = $this->db->query('SELECT * FROM post');
			$this->data['title'] = 'This is page title';
			$this->data['posts'] = $post;
			$this->data['edit_post'] = $result[0];
			view('inc/header');
			view('inc/nav');
			view('pages/home', $this->data);
			view('inc/footer');
		}
	}
	public function update(Request $request) {
		if (isset($_POST['_post_id'])) {
			$body = $request->getBody();
			$this->db->update('post', [
				'title' => $body['title'],
				'body' => $body['body']
			], ['id' => $body['_post_id']]);
			redirect(base_url())->with('message', 'Post updated Successfully!');
		}
	}
	public function delete(Request $request) {
		if (isset($_GET['id'])) {
			$id = $_GET['id'];
			
			$this->db->delete('post', [
				'id' => $id,
			]);
			redirect(base_url())->with('message', 'Post deleted Successfully!');
		}
	}
}

