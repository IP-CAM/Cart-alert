<?php
class ControllerCommonCartalert extends Controller {
	public function index() {
		$this->load->language('module/cartalert');
		
		$this->load->model('catalog/cartalert');
		$this->load->model('tool/image');
		$data['text_message'] = $this->config->get('cartalert_message');
		$data['title'] = $this->language->get('title');
		$data['text_product'] = $this->language->get('text_product');
		$data['text_image'] = $this->language->get('text_image');
		$data['text_price'] = $this->language->get('text_price');
				
		if (!defined('HTTPS_SERVER')) {
			$data['link'] = constant('HTTP_CATALOG');
		}else{
			$data['link'] = constant('HTTPS_CATALOG');
		}
			
		$daysno = $this->config->get('cartalert_daysno');		
		
		$customersresult = $this->model_catalog_cartalert->getCartalertcustomers($daysno);
		foreach ($customersresult as $customer) {
				$customerid = $customer['customer_id'];

			$productsresult = $this->model_catalog_cartalert->getCartalert($customerid);
			$data['products'] = array();
			foreach ($productsresult as $product) {
		
				if ($product['image']) {
					$data['thumb'] = $this->model_tool_image->resize($product['image'], $this->config->get('config_image_category_width'), $this->config->get('config_image_category_height'));
				} else {
					$data['thumb'] = '';
				}
			
				$data['products'][] = array(
					'productid'  => $product['product_id'],
					'name'  => $product['name'],
					'image' => $data['thumb'],
					'price' => $product['price']
				);
			}
	
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/mail/cartalert.tpl')) {
				$html = $this->load->view($this->config->get('config_template') . '/mail/cartalert.tpl', $data);
			} else {
				$html = $this->load->view('mail/cartalert.tpl', $data);
			}
			echo($html);

//Send email notification to customer
				$subject = sprintf($this->language->get('text_subject'), html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));

				$message = sprintf($this->language->get('text_message'), html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8')) . "\n\n";
	
				$message .= $this->language->get('text_thanks') . "\n";
				$message .= html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8');

				$mail = new Mail();
				$mail->protocol = $this->config->get('config_mail_protocol');
				$mail->parameter = $this->config->get('config_mail_parameter');
				$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
				$mail->smtp_username = $this->config->get('config_mail_smtp_username');
				$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
				$mail->smtp_port = $this->config->get('config_mail_smtp_port');
				$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

				$mail->setTo($customer['email']);
				$mail->setFrom($this->config->get('config_email'));
				$mail->setSender(html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));
				$mail->setSubject($subject);
				$mail->setText($message);
				$mail->setHtml($html);
				$mail->send();
//Update Date for sending mail
				$this->model_catalog_cartalert->setDateCartalert($customerid);
// End Send email notification to customer
		}	
	}
}
