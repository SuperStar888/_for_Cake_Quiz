<?php
/*
 *Solution 4: Complete Upload Progress and Read data from csv file
 */

class FileUploadController extends AppController {
	public function index() {
		$this->set('title', __('File Upload Answer'));

		$uploadData = '';
		if ($this->request->is('post')) {
			$fileobject = $this->data['FileUpload']['file'];
			
			if(!empty($fileobject['name'])){

				$fileName = $fileobject['name'];
				$extension = pathinfo($fileName, PATHINFO_EXTENSION);
				$uploadFolder = '..\\webroot\\files\\';
				$destination = $uploadFolder.$fileName;		
				
				if(!file_exists($uploadFolder)){
					mkdir($uploadFolder);
				}

				if(in_array($extension, ['csv'])){

					if(move_uploaded_file($fileobject['tmp_name'], $destination)){

						$readfile = new File($destination);
						$contents = $readfile->read();
						$contents_arr = explode("\n",$contents);
						
						if(substr($contents_arr[0],0,10) != "Name,Email"){
							$this->setFlash('Please upload correct data file with name and email.');
						}else{
							$get_file_data = [];
							for($i=1;$i<count($contents_arr);$i++){
								$row_data = explode(",",$contents_arr[$i]);
								if (count($row_data)!=2) continue;
								$get_file_data[]['FileUpload'] = [
									'name' => $row_data[0],
									'email' => $row_data[1],
								];
							}
							$this->FileUpload->SaveAll($get_file_data);
							$this->setFlash('File '.$fileName.' has been uploaded and inserted successfully.');
						}
					}else{
						$this->setFlash('Unable to upload file '.$fileName.', please try again.');
					}
				}else{
					$this->setFlash('Please choose a correct type file:(csv, xlsx, xls).');
				}
			}else{
                $this->setFlash('Please choose a file to upload.');
            }				
		}

		$file_uploads = $this->FileUpload->find('all');
		$this->set(compact('file_uploads'));
	}
}