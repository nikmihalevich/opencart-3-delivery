<?php
class ModelExtensionModuleDeliveryNik extends Model {
    public function getDelivery($delivery_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "delivery WHERE delivery_id = '" . (int)$delivery_id . "'");

        return $query->row;
    }

    public function getDeliveryDescription($delivery_id) {
        $delivery_description_data = array();
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "delivery_description WHERE delivery_id = '" . (int)$delivery_id . "'");

        foreach ($query->rows as $result) {
            $delivery_description_data[$result['language_id']] = array(
                'name'            => $result['name'],
            );
        }

        return $delivery_description_data;
    }

    public function getDeliveries($data = array()) {
        $sql = "SELECT * FROM " . DB_PREFIX . "delivery d LEFT JOIN " . DB_PREFIX . "delivery_description dd ON (d.delivery_id = dd.delivery_id) WHERE dd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

        $sort_data = array(
            'dd.name',
            'd.sort_order'
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];
        } else {
            $sql .= " ORDER BY dd.name";
        }

        if (isset($data['order']) && ($data['order'] == 'DESC')) {
            $sql .= " DESC";
        } else {
            $sql .= " ASC";
        }

        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function getQuote($delivery_id, $address) {
        $this->load->language('extension/shipping/flat');

        $delivery_info = $this->db->query("SELECT * FROM " . DB_PREFIX . "delivery d LEFT JOIN " . DB_PREFIX . "delivery_description dd ON (d.delivery_id = dd.delivery_id) WHERE dd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND d.delivery_id = '" . (int)$delivery_id . "'");

        var_dump($delivery_info);

//        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('shipping_flat_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");
//
//        if (!$this->config->get('shipping_flat_geo_zone_id')) {
//            $status = true;
//        } elseif ($query->num_rows) {
//            $status = true;
//        } else {
//            $status = false;
//        }
//
//        $method_data = array();
//
//        if ($status) {
//            $quote_data = array();
//
//            $quote_data['flat'] = array(
//                'code'         => 'flat.flat',
//                'title'        => $this->language->get('text_description'),
//                'cost'         => $this->config->get('shipping_flat_cost'),
//                'tax_class_id' => $this->config->get('shipping_flat_tax_class_id'),
//                'text'         => $this->currency->format($this->tax->calculate($this->config->get('shipping_flat_cost'), $this->config->get('shipping_flat_tax_class_id'), $this->config->get('config_tax')), $this->session->data['currency'])
//            );
//
//            $method_data = array(
//                'code'       => 'flat',
//                'title'      => $this->language->get('text_title'),
//                'quote'      => $quote_data,
//                'sort_order' => $this->config->get('shipping_flat_sort_order'),
//                'error'      => false
//            );
//        }
//
//        return $method_data;
    }
}
