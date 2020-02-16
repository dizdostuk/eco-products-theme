<?php
class ControllerExtensionModuleLatest extends Controller {
	public function index($setting) {
		$this->load->language('extension/module/latest');

		$this->load->model('account/wishlist');
		$this->load->model('catalog/product');

		$this->load->model('tool/image');

		$results = $this->model_account_wishlist->getWishlist();
		$data['logged'] = $this->customer->isLogged();
		$data['wishlists'] = array();

		foreach ($results as $result) {
			$product_info = $this->model_catalog_product->getProduct($result['product_id']);

			if ($product_info) {

				array_push($data['wishlists'], $product_info['product_id']);
				// $data['wishlists'][] = array(
				// 	'product_id' => $product_info['product_id'],
				// 	'remove'     => $this->url->link('account/wishlist', 'remove=' . $product_info['product_id'])
				// );
			} else {
				$this->model_account_wishlist->deleteWishlist($result['product_id']);
			}
		}

		$this->load->model('catalog/product');

		$this->load->model('tool/image');

		$data['products'] = array();
		$filter_data = array(
			'sort'  => 'p.date_added',
			'order' => 'DESC',
			'start' => 0,
			'limit' => $setting['limit']
		);

		$results = $this->model_catalog_product->getProducts($filter_data);

		if ($results) {
			foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height']);
				} else {
					$image = $this->model_tool_image->resize('placeholder.png', $setting['width'], $setting['height']);
				}

				if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				} else {
					$price = false;
				}

				if ((float)$result['special']) {
					$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				} else {
					$special = false;
				}

				if ($this->config->get('config_tax')) {
					$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price'], $this->session->data['currency']);
				} else {
					$tax = false;
				}

				if ($this->config->get('config_review_status')) {
					$rating = $result['rating'];
				} else {
					$rating = false;
				}

				$data['products'][] = array(
					'product_id'  => $result['product_id'],
					'thumb'       => $image,
					'name'        => $result['name'],
					'description' => utf8_substr(trim(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'))), 0, $this->config->get('theme_' . $this->config->get('config_theme') . '_product_description_length')) . '..',
					'price'       => $price,
					'sku'					=> $result['sku'],
					'upc'					=> $result['upc'],
					'special'     => $special,
					'specPercent'	=> round((intval($price) - intval($special)) / intval($price) * 100),
					'tax'         => $tax,
					'rating'      => $rating,
					'href'        => $this->url->link('product/product', 'product_id=' . $result['product_id'])
				);
				// if($special) {
				// 	$data['percentFromSpecial'] = ;
				// }
			}

			return $this->load->view('extension/module/latest', $data);
		}
	}
}
