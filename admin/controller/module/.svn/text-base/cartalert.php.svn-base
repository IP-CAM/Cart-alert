<?php
class ControllerModuleCartalert extends Controller {
  private $error = array(); 

  public function index() {
    $this->load->language('module/cartalert');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			//echo "mohit";
			$this->model_setting_setting->editSetting('cartalert', $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}
    
    $texts = array(
      'heading_title',
      'text_module',
      'text_success',
      'text_edit',
      'text_yes',
      'text_no',
      'text_enabled',
      'text_disabled',
      'daysno',
      'message',
      'btn_mail',     
      'entry_daysno',
      'entry_message',
      'entry_status',
      'button_save',
      'button_cancel'
    );
    
    foreach($texts as $text) {
      $data[$text] = $this->language->get($text);
    }
    
    if (isset($this->error['warning'])) {
      $data['error_warning'] = $this->error['warning'];
    } else {
      $data['error_warning'] = '';
    }
    
    if (isset($this->error['daysno'])) {
      $data['error_daysno'] = $this->error['daysno'];
    } else {
      $data['error_daysno'] = '';
    }
    
    if (isset($this->error['message'])) {
      $data['error_message'] = $this->error['message'];
    } else {
      $data['error_message'] = '';
    }    
     
    $data['breadcrumbs'] = array();

    $data['breadcrumbs'][] = array(
      'text'      => $this->language->get('text_home'),
      'href'      => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
    );

    $data['breadcrumbs'][] = array(
      'text'      => $this->language->get('text_module'),
      'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL')
    );

    $data['breadcrumbs'][] = array(
      'text'      => $this->language->get('heading_title'),
      'href'      => $this->url->link('module/cartalert', 'token=' . $this->session->data['token'], 'SSL')
    );
    
    $data['action'] = $this->url->link('module/cartalert', 'token=' . $this->session->data['token'], 'SSL');
    $data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
    $data['sendmail'] = $this->url->link('module/cartalert/alertmail', 'token=' . $this->session->data['token'], 'SSL');
    
    $datas = array(
      'cartalert_daysno' => '',
      'cartalert_message' => '',
      'cartalert_status' => 0
    );
    
    foreach ($datas as $key => $value) {
      if (isset($this->request->post[$key])) {
        $data[$key] = $this->request->post[$key];
      } elseif ($this->config->get($key)) {
        $data[$key] = $this->config->get($key);
      } else $data[$key] = $value;
    }
    
    $data['header'] = $this->load->controller('common/header');
    $data['column_left'] = $this->load->controller('common/column_left');
    $data['footer'] = $this->load->controller('common/footer');

    $this->response->setOutput($this->load->view('module/cartalert.tpl', $data));
  }
  
  protected function validate() {
    if (!$this->user->hasPermission('modify', 'module/cartalert')) {
      $this->error['warning'] = $this->language->get('error_permission');
    }
    
    if (!$this->request->post['cartalert_daysno']) {
      $this->error['daysno'] = $this->language->get('error_daysno');
    }
    
    if (!$this->request->post['cartalert_message']) {
      $this->error['message'] = $this->language->get('error_message');
    }    
    
   return !$this->error;
  }
  
  
	public function alertmail() {
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
