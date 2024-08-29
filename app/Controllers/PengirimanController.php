<?php

		namespace App\Controllers;
		use App\Models\TransaksiModel;

		class PengirimanController extends BaseController
		{
			protected $pengiriman;

			function __construct()
			{
				helper('form');
				$this->pengiriman = new TransaksiModel();
			}

			public function index()
			{
				$data['transaksi'] = $this->pengiriman->findAll();
				return view('pages/pengiriman_view', $data);
			}

			public function create()
			{
				$data = $this->request->getPost();
				$validate = $this->validation->run($data, 'transaksi');
				$errors = $this->validation->getErrors();

				if(!$errors){
					$dataForm = [ 
						'tanggal' => $this->request->getPost('created_date'),
						'username' => $this->request->getPost('username'),
						'total_harga' => $this->request->getPost('total_harga'),
						'ongkos_kirim' => $this->request->getPost('ongkos_kirim'),
                        'status' => $this->request->getPost('status')
					];
			
					$dataFoto = $this->request->getFile('foto');
			
					if ($dataFoto->isValid()){
						$fileName = $dataFoto->getRandomName();
						$dataFoto->move('public/img/', $fileName);
						$dataForm['foto'] = $fileName;
					}  
			
					$this->pengiriman->insert($dataForm); 
			
					return redirect('pengiriman')->with('success','Data Berhasil Ditambah');
				}else{
					return redirect('pengiriman')->with('failed',implode("<br>",$errors));
				}    
			}

			public function edit($id)
			{
				$data = $this->request->getPost();
					$dataForm = [ 
                        'status' => $this->request->getPost('status')
					];

					$this->pengiriman->update($id, $dataForm);

					return redirect('pengiriman')->with('success','Data Berhasil Diubah');
			}

			public function delete($id)
			{
				$dataPengiriman = $this->pengiriman->find($id);
                unlink("public/img/".$dataPengiriman["foto"]);

				$this->pengiriman->delete($id);

				return redirect('pengiriman')->with('success','Data Berhasil Dihapus');
			}
		}