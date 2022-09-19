<?php
App::import('Vendor','PHPExcel/Classes/PHPExcel');
/**
 * Solution 6:Load Excel file and Save it into 3 DB.
 */

	class MigrationController extends AppController{
		
		public function q1(){
			
			$this->setFlash('Question: Migration of data to multiple DB table');
				
			$objPHPExcel = new PHPExcel();
			$inputFileName = "../webroot/files/migration_sample_1.xlsx";

			$this->loadModel('Member');
			$this->loadModel('Transaction');
			$this->loadModel('TransactionItem');

			try {
				$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
				$objReader = PHPExcel_IOFactory::createReader($inputFileType);
				$objPHPExcel = $objReader->load($inputFileName);
				// var_dump($objPHPExcel);

			} catch(Exception $e) {
				die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
			}

			//  Get worksheet dimensions
			$sheet = $objPHPExcel->getSheet(0); 
			$highestRow = $sheet->getHighestRow(); 
			$highestColumn = $sheet->getHighestColumn();
			$get_member_data = [];
			$get_transaction_data =[];
			$get_transaction_item_data =[];

			//  Loop through each row of the worksheet in turn
			for ($row = 2; $row <= $highestRow; $row++){ 
				$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
												NULL,
												TRUE,
												FALSE);

				$row_date = Date("Y-m-d", ($rowData[0][0]-25569)*86400);
				$row_date_year = Date("Y", ($rowData[0][0]-25569)*86400);
				$row_date_month = Date("m", ($rowData[0][0]-25569)*86400);
				$type = explode(" ",$rowData[0][3]);
				$get_member_data[]['Member'] = [
					'type' => $type[0],
					'no' => $type[1],
					'name'=> $rowData[0][2],
					'company'=> $rowData[0][5],
					'valid' => 1
				];

				$get_transaction_data[]['Transaction'] =[
					'member_id'=> ($row-1),
					'member_name'=>$rowData[0][2],
					'member_paytype'=>$rowData[0][4],
					'member_company'=>$rowData[0][5],
					'date'=>$row_date,
					'year'=>$row_date_year,
					'month'=>$row_date_month,
					'ref_no'=>$rowData[0][1],
					'receipt_no'=>$rowData[0][8],
					'payment_method'=>$rowData[0][6],
					'batch_no'=>$rowData[0][7],
					'cheque_no'=>$rowData[0][9],
					'payment_type'=>$rowData[0][10],
					'renewal_year'=>$rowData[0][11],
					'remarks'=>'',
					'subtotal'=>$rowData[0][12],
					'tax'=>$rowData[0][13],
					'total'=>$rowData[0][14],
					'valid'=>1
				];
				$get_transaction_item_data[]['TransactionItem'] =[
					'transaction_id'=> ($row-1),
					'description'=>'Being Payment for:'.$rowData[0][10].':'.$rowData[0][11],
					'qunatity'=>1.0,
					'unit_price'=>$rowData[0][12],
					'uom'=>'',
					'sum'=>$rowData[0][12],
					'valid'=>1,
					'table'=>'Member',
					'table_id'=>($row-1),
				];

			}

			$this->Member->SaveAll($get_member_data);
			$this->Transaction->SaveAll($get_transaction_data);
			$this->TransactionItem->SaveAll($get_transaction_item_data);

			$this->setFlash('Import Excel file success!');
			$this->set('title',__('Migration'));
		}
		
		public function q1_instruction(){

			$this->setFlash('Question: Migration of data to multiple DB table');
				
			
			
// 			$this->set('title',__('Question: Please change Pop Up to mouse over (soft click)'));
		}
		
	}