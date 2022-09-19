<?php
	class OrderReportController extends AppController{

		/**
		 * Solution 5:Multidimensional Array
		 */

		 public function index(){

			$this->setFlash('Multidimensional Array.');

			$this->loadModel('Order');
			$orders = $this->Order->find('all',array('conditions'=>array('Order.valid'=>1),'recursive'=>2));
			
			$this->loadModel('Portion');
			$portions = $this->Portion->find('all',array('conditions'=>array('Portion.valid'=>1),'recursive'=>2));

			$portion_detail_by_item_id = [];
			foreach ($portions as $portion){
				$portion_detail_by_item_id[$portion['Item']['id']] = $portion['PortionDetail'];
			}

			$order_reports = [];
			foreach ($orders as $order){
				$order_name = $order['Order']['name'];
				$tmp = [];
				foreach($order['OrderDetail'] as $order_detail){
					foreach($portion_detail_by_item_id[$order_detail['Item']['id']] as $portion_detail){
						$ingredient_name = $portion_detail['Part']['name'];
						if (array_key_exists($ingredient_name, $tmp))
							$tmp[$ingredient_name] += $order_detail['quantity'] * $portion_detail['value'];
						else
							$tmp[$ingredient_name] = $order_detail['quantity'] * $portion_detail['value'];
					}
				}
				$order_reports[$order_name]=$tmp;
			}
			
			$this->set('order_reports',$order_reports);
			$this->set('title',__('Orders Report'));
		}

		public function Question(){

			$this->setFlash('Multidimensional Array.');

			$this->loadModel('Order');
			$orders = $this->Order->find('all',array('conditions'=>array('Order.valid'=>1),'recursive'=>2));

			// debug($orders);exit;

			$this->set('orders',$orders);

			$this->loadModel('Portion');
			$portions = $this->Portion->find('all',array('conditions'=>array('Portion.valid'=>1),'recursive'=>2));
				
			// debug($portions);exit;

			$this->set('portions',$portions);

			$this->set('title',__('Question - Orders Report'));
		}

	}