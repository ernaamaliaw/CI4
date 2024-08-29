<?php

		namespace App\Controllers;
		use App\Models\UserModel;

		class UserController extends BaseController
		{
			protected $user;

			function __construct()
			{
				helper('form');
				$this->validation = \Config\Services::validation();
				$this->user = new UserModel();
			}

			public function index()
			{
				$data['users'] = $this->user->findAll();
				return view('pages/user_view', $data);
			}

			public function create()
			{
				$data = $this->request->getPost();
				$validate = $this->validation->run($data, 'barang');
				$errors = $this->validation->getErrors();

				if(!$errors){
					$dataForm = [ 
						'nama' => $this->request->getPost('nama'),
						'hrg' => $this->request->getPost('hrg'),
						'stok' => $this->request->getPost('stok'),
						'keterangan' => $this->request->getPost('keterangan')
					];
			
					$dataFoto = $this->request->getFile('foto');
			
					if ($dataFoto->isValid()){
						$fileName = $dataFoto->getRandomName();
						$dataFoto->move('public/img/', $fileName);
						$dataForm['foto'] = $fileName;
					}  
			
					$this->user->insert($dataForm); 
			
					return redirect('user')->with('success','Data Berhasil Ditambah');
				}else{
					return redirect('user')->with('failed',implode("<br>",$errors));
				}    
			}

			public function edit($id)
			{
				$data = $this->request->getPost();

				if($data>0){
                    if($this->request->getPost('editRole')==1){
                        $dataForm = [
                            'role' => $this->request->getPost('role')
                        ]; 
                    } else {
                        $dataForm = [
                            'status' => $this->request->getPost('status')
                        ];
                    }

					$this->user->update($id, $dataForm);

					return redirect('user')->with('success','Data Berhasil Diubah');
				}else{
					return redirect('user')->with('failed', 'Data Gagal Diubah');
				}
				
			}

			public function delete($id)
			{
				$dataUser = $this->user->find($id);

				$this->user->delete($id);

				return redirect('user')->with('success','Data Berhasil Dihapus');
			}
		}