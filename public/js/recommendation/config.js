/* å‡å‡é®® settings */
AviviD.utm_mode = 1;
AviviD.preview_mode = 0;
AviviD.online_mode = 1;
AviviD.show_logs = 0;
AviviD.css_setting = [
  "https://rhea.advividnetwork.com/css/avivid_common_v2.css",
  "https://rhea.advividnetwork.com/include_js/" + AviviD.web_id + "/avivid_recModule_costom.css"
];
AviviD.block_data_setting = {
  "block_like": {
    "data_url": "https://rhea-cdn.advividnetwork.com/api/ecomEmbeddedRecommendation",
    "http_method": "GET",
    "async": true,
    "timeout": 5000,
    "cache": false,
    "headers": {},
    "payload": {
      "web_id": "",
      "uuid": "",
      "title": "",
      "url": "",
      "meta_url": "",
      "footId": "",
      "type": "belt1"
    }
  },
  "block_uuid_keyword": {
    "data_url": "https://rhea-cdn.advividnetwork.com/api/getUuidLikeWordCdn",
    "http_method": "GET",
    "async": true,
    "timeout": 5000,
    "cache": false,
    "headers": {},
    "payload": {
      "web_id": ""
    }
  },
  "block_other_keyword": {
    "data_url": "https://rhea-cdn.advividnetwork.com/api/seoItemWord",
    "http_method": "GET",
    "async": true,
    "timeout": 5000,
    "cache": false,
    "headers": {},
    "payload": {
      "web_id": ""
    }
  },
  "block_keyword": {
    "data_url": "https://rhea-cdn.advividnetwork.com/api/getHotWordCdn",
    "http_method": "GET",
    "async": true,
    "timeout": 5000,
    "cache": false,
    "headers": {},
    "payload": {
      "web_id": ""
    }
  },
  "block_other": {
    "data_url": "https://rhea-cdn.advividnetwork.com/api/ecomEmbeddedRecommendation",
    "http_method": "GET",
    "async": true,
    "timeout": 5000,
    "cache": false,
    "headers": {},
    "payload": {
      "web_id": "",
      "uuid": "",
      "title": "",
      "url": "",
      "type": "belt2"
    }
  },
  "block_history": {
    "data_url": "https://rhea-cdn.advividnetwork.com/api/ecomHistory",
    "http_method": "GET",
    "async": true,
    "timeout": 5000,
    "cache": false,
    "headers": {},
    "payload": {
      "web_id": "",
      "data": "",
      "url": "",
      "type": ""
    }
  },
  "block_sider_bar": {
    "data_url": "https://rhea-cdn.advividnetwork.com/api/getHotWordCdn",
    "http_method": "GET",
    "async": true,
    "timeout": 5000,
    "cache": true,
    "headers": {},
    "payload": {
      "web_id": ""
    }
  }
};
AviviD.block_setting = {
  "index": {
    "force_domain": 1,
    "domain_list": ["https://www.ohohfresh.com/"],
    "check_rule": "",
    "product_page_mark": 0,
    "block": {
      "block_like": {
        "enabled": 1,
        "preview_mode": 0,
        "overwrite_bar_width": 0,
        "overwrite_bar_top": 0,
        "overwrite_product_pc_text_height": 0,
        "overwrite_product_mobile_text_height": 0,
        "css_html_force_append": 0,
        "css_html_insert_before": 1,
        "css_selector": "#footer",
        "tpl_render_function": "navigation_bar",
        "old_type_no": 4
      },
      "block_other": {
        "enabled": 0,
        "preview_mode": 0,
        "overwrite_bar_width": 0,
        "overwrite_bar_top": 0,
        "overwrite_product_pc_text_height": 0,
        "overwrite_product_mobile_text_height": 0,
        "css_html_force_append": 0,
        "css_html_insert_before": 1,
        "css_selector": "",
        "tpl_render_function": "navigation_bar",
        "old_type_no": 3
      },
      "block_history": {
        "enabled": 0,
        "preview_mode": 0,
        "overwrite_bar_width": 0,
        "overwrite_bar_top": 0,
        "overwrite_product_pc_text_height": 0,
        "overwrite_product_mobile_text_height": 0,
        "css_html_force_append": 0,
        "css_html_insert_before": 1,
        "css_selector": "",
        "tpl_render_function": "navigation_bar",
        "old_type_no": 2
      },
      "block_keyword": {
        "enabled": 1,
        "preview_mode": 0,
        "overwrite_bar_width": 0,
        "overwrite_bar_top": 0,
        "overwrite_product_pc_text_height": 0,
        "overwrite_product_mobile_text_height": 0,
        "css_html_force_append": 0,
        "css_html_insert_before": 1,
        "css_selector": "#footer",
        "tpl_render_function": "button_bar",
        "old_type_no": 1
      },
      "block_uuid_keyword": {
        "enabled": 0,
        "preview_mode": 0,
        "overwrite_bar_width": 0,
        "overwrite_bar_top": 0,
        "overwrite_product_pc_text_height": 0,
        "overwrite_product_mobile_text_height": 0,
        "css_html_force_append": 0,
        "css_html_insert_before": 1,
        "css_selector": ".layout-footer",
        "tpl_render_function": "button_bar",
        "old_type_no": 4
      },
      "block_other_keyword": {
        "enabled": 0,
        "preview_mode": 0,
        "overwrite_bar_width": 0,
        "overwrite_bar_top": 0,
        "overwrite_product_pc_text_height": 0,
        "overwrite_product_mobile_text_height": 0,
        "css_html_force_append": 0,
        "css_html_insert_before": 1,
        "css_selector": ".layout-footer",
        "tpl_render_function": "button_bar",
        "old_type_no": 4
      },
      "block_sider_bar": {
        "enabled": 1,
        "preview_mode": 0,
        "overwrite_bar_width": 0,
        "overwrite_bar_top": 0,
        "overwrite_product_pc_text_height": 0,
        "overwrite_product_mobile_text_height": 0,
        "css_html_force_append": 1,
        "css_html_insert_before": 0,
        "css_selector": "body",
        "tpl_render_function": "new_sider_bar",
        "old_type_no": 5
      }
    }
  },
  "category": {
    "force_domain": 0,
    "domain_list": [],
    "check_rule": "https://www.ohohfresh.com/",
    "product_page_mark": 0,
    "block": {
      "block_like": {
        "enabled": 1,
        "preview_mode": 0,
        "overwrite_bar_width": 880,
        "overwrite_bar_top": 0,
        "overwrite_product_pc_text_height": 0,
        "overwrite_product_mobile_text_height": 0,
        "css_html_force_append": 0,
        "css_html_insert_before": 1,
        "css_selector": "#footer",
        "tpl_render_function": "navigation_bar",
        "old_type_no": 4
      },
      "block_other": {
        "enabled": 0,
        "preview_mode": 0,
        "overwrite_bar_width": 0,
        "overwrite_bar_top": 0,
        "overwrite_product_pc_text_height": 0,
        "overwrite_product_mobile_text_height": 0,
        "css_html_force_append": 0,
        "css_html_insert_before": 1,
        "css_selector": "",
        "tpl_render_function": "navigation_bar",
        "old_type_no": 3
      },
      "block_history": {
        "enabled": 0,
        "preview_mode": 0,
        "overwrite_bar_width": 0,
        "overwrite_bar_top": 0,
        "overwrite_product_pc_text_height": 0,
        "overwrite_product_mobile_text_height": 0,
        "css_html_force_append": 0,
        "css_html_insert_before": 1,
        "css_selector": "",
        "tpl_render_function": "navigation_bar",
        "old_type_no": 2
      },
      "block_keyword": {
        "enabled": 1,
        "preview_mode": 0,
        "overwrite_bar_width": 880,
        "overwrite_bar_top": 0,
        "overwrite_product_pc_text_height": 0,
        "overwrite_product_mobile_text_height": 0,
        "css_html_force_append": 0,
        "css_html_insert_before": 1,
        "css_selector": "#footer",
        "tpl_render_function": "button_bar",
        "old_type_no": 1
      },
      "block_uuid_keyword": {
        "enabled": 0,
        "preview_mode": 0,
        "overwrite_bar_width": 880,
        "overwrite_bar_top": 0,
        "overwrite_product_pc_text_height": 0,
        "overwrite_product_mobile_text_height": 0,
        "css_html_force_append": 0,
        "css_html_insert_before": 1,
        "css_selector": ".product-container",
        "tpl_render_function": "button_bar",
        "old_type_no": 4
      },
      "block_other_keyword": {
        "enabled": 0,
        "preview_mode": 0,
        "overwrite_bar_width": 880,
        "overwrite_bar_top": 0,
        "overwrite_product_pc_text_height": 0,
        "overwrite_product_mobile_text_height": 0,
        "css_html_force_append": 0,
        "css_html_insert_before": 1,
        "css_selector": ".product-container",
        "tpl_render_function": "button_bar",
        "old_type_no": 4
      },
      "block_sider_bar": {
        "enabled": 1,
        "preview_mode": 0,
        "overwrite_bar_width": 0,
        "overwrite_bar_top": 0,
        "overwrite_product_pc_text_height": 0,
        "overwrite_product_mobile_text_height": 0,
        "css_html_force_append": 1,
        "css_html_insert_before": 0,
        "css_selector": "body",
        "tpl_render_function": "new_sider_bar",
        "old_type_no": 5
      }
    }
  },
  "product": {
    "force_domain": 0,
    "domain_list": [],
    "check_rule": "Product-_",
    "product_page_mark": 1,
    "block": {
      "block_like": {
        "enabled": 0,
        "preview_mode": 0,
        "overwrite_bar_width": 0,
        "overwrite_bar_top": 0,
        "overwrite_product_pc_text_height": 0,
        "overwrite_product_mobile_text_height": 0,
        "css_html_force_append": 0,
        "css_html_insert_before": 1,
        "css_selector": "",
        "tpl_render_function": "navigation_bar",
        "old_type_no": 1
      },
      "block_other": {
        "enabled": 1,
        "preview_mode": 0,
        "overwrite_bar_width": 880,
        "overwrite_bar_top": 0,
        "overwrite_product_pc_text_height": 0,
        "overwrite_product_mobile_text_height": 0,
        "css_html_force_append": 0,
        "css_html_insert_before": 1,
        "css_selector": "#footer",
        "tpl_render_function": "navigation_bar",
        "old_type_no": 3
      },
      "block_history": {
        "enabled": 1,
        "preview_mode": 0,
        "overwrite_bar_width": 880,
        "overwrite_bar_top": 0,
        "overwrite_product_pc_text_height": 0,
        "overwrite_product_mobile_text_height": 0,
        "css_html_force_append": 0,
        "css_html_insert_before": 1,
        "css_selector": "#footer",
        "tpl_render_function": "navigation_bar",
        "old_type_no": 2
      },
      "block_keyword": {
        "enabled": 1,
        "preview_mode": 0,
        "overwrite_bar_width": 880,
        "overwrite_bar_top": 0,
        "overwrite_product_pc_text_height": 0,
        "overwrite_product_mobile_text_height": 0,
        "css_html_force_append": 0,
        "css_html_insert_before": 1,
        "css_selector": "#footer",
        "tpl_render_function": "button_bar",
        "old_type_no": 4
      },
      "block_uuid_keyword": {
        "enabled": 0,
        "preview_mode": 0,
        "overwrite_bar_width": 880,
        "overwrite_bar_top": 0,
        "overwrite_product_pc_text_height": 0,
        "overwrite_product_mobile_text_height": 0,
        "css_html_force_append": 0,
        "css_html_insert_before": 1,
        "css_selector": "",
        "tpl_render_function": "button_bar",
        "old_type_no": 4
      },
      "block_other_keyword": {
        "enabled": 0,
        "preview_mode": 0,
        "overwrite_bar_width": 880,
        "overwrite_bar_top": 0,
        "overwrite_product_pc_text_height": 0,
        "overwrite_product_mobile_text_height": 0,
        "css_html_force_append": 0,
        "css_html_insert_before": 1,
        "css_selector": "#salepage-more-recommendation",
        "tpl_render_function": "button_bar",
        "old_type_no": 4
      },
      "block_sider_bar": {
        "enabled": 1,
        "preview_mode": 0,
        "overwrite_bar_width": 0,
        "overwrite_bar_top": 0,
        "overwrite_product_pc_text_height": 0,
        "overwrite_product_mobile_text_height": 0,
        "css_html_force_append": 1,
        "css_html_insert_before": 0,
        "css_selector": "body",
        "tpl_render_function": "new_sider_bar",
        "old_type_no": 5
      }
    }
  }
};
AviviD.bar_setting = {
  "autoCloseIfWidth": 99999,
  "bar_width": 980,
  "product_item_width": 245,
  "product_pc_text_height": 26,
  "product_mobile_text_height": 28,
  "title_text_color": "#008cd6"
};
