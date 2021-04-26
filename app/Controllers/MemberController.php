<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class MemberController extends BaseController
{
	public function __construct()
	{
		$this->member = new \App\Models\Member();
	}

	public function index()
	{
		$data['page'] = 'pages/member_view';
		return view("main",$data);
	}

	public function getdata(){
		$this->response->setHeader('Access-Control-Allow-Origin', '*')
            ->setHeader('Access-Control-Allow-Headers', '*')
            ->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE');
		$filter = $this->request->getGet('keyword');
		$data = [];

		if($filter){
			var_dump("tes");
			$data = $this->member->findAll();
		}else
			$data = $this->member->findAll();

		return $this->response->setJSON($data);
	}


	public function show($id){
		$this->response->setHeader('Access-Control-Allow-Origin', '*')
            ->setHeader('Access-Control-Allow-Headers', '*')
            ->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE');
			
		return $this->response->setJSON($this->member->find($id));
	}

	public function store(){
		$input = $this->request->getPost();

		try {
			$foto = $this->request->getFile('foto')->store();
			$input['foto'] = $foto;
		} catch (\Exception $e) { }
			
		if ($this->member->save($input) === false)
		{
			return  $this->response->setStatusCode(422)
				->setJSON([$this->member->errors()]);
		}else
			return $this->response->setJSON(["message"=>"data berhasil di tambahkan"]);
	}

	public function update($id){
		$input = $this->request->getPost();
		$this->member->update($id,$input);
		return $this->response->setJSON(["message"=>"data berhasil di update"]);
	}

	public function delete($id){
		$this->member->delete($id);
		return $this->response->setJSON(["message"=>"data berhasil di hapus"]);
	}

}
