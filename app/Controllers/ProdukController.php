<?php

		namespace App\Controllers;
		use App\Models\ProdukModel;

		class ProdukController extends BaseController
		{
			protected $produk;
            protected $validator;

			function __construct()
			{
				helper('form');
				$this->validator = \Config\Services::validation();
				$this->produk = new ProdukModel();
			}

			public function index()
			{
				$data['produks'] = $this->produk->findAll();
				return view('pages/produk_view', $data);
			}

			public function create()
			{
				$data = $this->request->getPost();
				$validate = $this->validator->run($data, 'brg');
				$errors = $this->validator->getErrors();

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
			
					$this->produk->insert($dataForm); 
			
					return redirect('produk')->with('success','Data Berhasil Ditambah');
				}else{
					return redirect('produk')->with('failed',implode("<br>",$errors));
				}    
			}

			public function edit($id)
			{
				$data = $this->request->getPost();
				$validate = $this->validator->run($data, 'brg');
				$errors = $this->validator->getErrors();

				if(!$errors){
					$dataForm = [
						'nama' => $this->request->getPost('nama'),
						'hrg' => $this->request->getPost('hrg'),
						'stok' => $this->request->getPost('stok'),
						'keterangan' => $this->request->getPost('keterangan')
					];

					if($this->request->getPost('check')){
						$dataFoto = $this->request->getFile('foto');
						if ($dataFoto->isValid()){
							$fileName = $dataFoto->getRandomName();
							$dataFoto->move('public/img/', $fileName);
							$dataForm['foto'] = $fileName;
						}             
					}

					$this->produk->update($id, $dataForm);

					return redirect('produk')->with('success','Data Berhasil Diubah');
				}else{
					return redirect('produk')->with('failed',implode("",$errors));
				}
				
			}

			public function delete($id)
			{
				$dataProduk = $this->produk->find($id);
				unlink("public/img/".$dataProduk['foto']);	

				$this->produk->delete($id);

				return redirect('produk')->with('success','Data Berhasil Dihapus');
			}
		}