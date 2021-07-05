AviviD.url_rules = function(keys,settings){
  // var url = window.location.href; // get current url
  var url = "https://www.ohohfresh.com/"; // get current url

  var url_match = 0;
  if (parseInt(settings["force_domain"]) == 1) {
    jQuery.each(settings["domain_list"],function(k,v){
      if (url == v || url.indexOf(v+"?") != -1) { // indexOf: get index of an array, if not found, return -1
        url_match = 1;
        return false;
      }  
    });
  } else {
    if (url.indexOf(settings["check_rule"]) != -1){
      url_match = 1;
    }  
  }
  var log = "ignore " + keys;
  console.log(log)
  if (url_match){
    var ab_test_mark = AviviD.check_ab_test_mark();
    jQuery.each(settings["block"],function(k,v){
      if (parseInt(v["enabled"]) == 1){
        if (ab_test_mark){
          if (AviviD.rec_module_abtest({[k]:0})[k]){
            AviviD.create_block(k,v,settings);  // AviviD.get_ajax_data = function(block_name,ajax_setting,block_setting,origin_setting), ajax_setting = AviviD.block_data_setting[block_name];
            AviviD.gtm_event_send(k,"likr_event_a",keys+"_"+location.href);
          } else {
            AviviD.gtm_event_send(k,"likr_event_b",keys+"_"+location.href);
          }
        } else {
          AviviD.create_block(k,v,settings);
        }
      } else {
        if (parseInt(v["preview_mode"]) == 1){
          if (url.indexOf("AviviD_debug_mode") != -1){
            AviviD.create_block(k,v,settings);
          } 
        }
      }  
    });
    log = "match " + keys;
  }
  AviviD.console_logs(log);
  // AviviD.console_logs('gogogo');

  return url_match;
  // return 1;

};
AviviD.check_ab_test_mark = function(){
  var log = "ab test off!";
  var return_value = false;
  if (("ad_block_abtest_enabled" in AviviD["settings"]) && 
      parseInt(AviviD.settings.ad_block_abtest_enabled) == 1){
    var start_time = AviviD.Date(AviviD["settings"]["ad_block_abtest_start_time"]);
    var end_time = AviviD.Date(AviviD["settings"]["ad_block_abtest_end_time"]);
    var now_time = new Date();
    if (now_time >= start_time && now_time < end_time){
      log = "test on!";
      return_value = true;
    }
  }
  AviviD.console_logs(log);
  return return_value;
};
AviviD.create_block = function(block_name,block_setting,origin_setting){
  var ajax_setting = AviviD.block_data_setting[block_name];
  AviviD[block_name](block_name,ajax_setting,block_setting,origin_setting);
};
AviviD.get_ajax_data = function(block_name,ajax_setting,block_setting,origin_setting){
  var return_data = "_";
  jQuery.ajax({
    type : ajax_setting["http_method"],
    async : ajax_setting["async"],
    data : ajax_setting["payload"],
    url : ajax_setting["data_url"],
    headers : ajax_setting["headers"],
    crossDomain: true,
    cache : ajax_setting["cache"],
    timeout : ajax_setting["timeout"],
    success : function (data) {
      if (data != '' && data != '_'){
        return_data = JSON.parse(data);
        if (ajax_setting["async"]){
          var delay_time = (parseInt(block_setting["old_type_no"]) * 250);
          setTimeout(function(){
            AviviD[block_setting["tpl_render_function"]](block_name,return_data,block_setting,origin_setting);

            // AviviD[block_setting.block_like["tpl_render_function"]](block_name,return_data,block_setting,origin_setting);
            // AviviD.navigation_bar(block_name,return_data,block_setting,origin_setting);
            console.log(block_setting["tpl_render_function"])
            // AviviD.navigation_bar(block_name,return_data,block_setting,origin_setting);

          },delay_time);
        }
      }
    },
    complete : function(XMLHttpRequest,textStatus){
      if (textStatus == "timeout"){
        AviviD.console_logs(block_name + " ajax timeout!");
      }
    },
    error : function (jqXHR, textStatus, errorThrown) {
      AviviD.console_logs(block_name + " ajax error");
    }
  });
  return return_data;
};
AviviD.isMobileDevice = function(){
  const mobileDevice = ['Android', 'webOS', 'iPhone', 'iPad',
                        'iPod', 'BlackBerry', 'Windows Phone'];
  let isMobileDevice = mobileDevice.some(e => navigator.userAgent.match(e));
  if (!isMobileDevice){
    if (navigator.platform === "MacIntel" && navigator.maxTouchPoints > 0){
      return true;
    }
  }
  return isMobileDevice;
};
AviviD.get_top_domain = function get_top_domain() {
  var domain = window.location.host;
  var length = domain.split('.').length;
  var domain_split_reverse = domain.split('.').reverse();
  if (length <= '2') {
    return domain;
  } else if (length == '3') {
    if (domain_split_reverse[1] === 'com') {
      return domain;
    } else {
      return domain_split_reverse[1] + "." + domain_split_reverse[0];
    }
  } else if (length == '4') {
    if (domain_split_reverse[0] === 'com') { 
      return domain_split_reverse[1] + "." + domain_split_reverse[0];
    } else {
      return domain_split_reverse[2] + "." + domain_split_reverse[1] + "." + domain_split_reverse[0];
    }
  } else {
    return domain_split_reverse[2] + "." + domain_split_reverse[1] + "." + domain_split_reverse[0];
  }
};
AviviD.get_cookie_data = function(cname) {
  var name = cname + "=";
  var ca = document.cookie.split(';');
  for (var i = 0; i < ca.length; i++) {
    var c = ca[i].trim();
    if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
  }
  return "";
};
AviviD.set_cookie_data = function(name, value, days) {
  var domain = AviviD.get_top_domain();
  var Days = days || 3650;
  var exp = new Date();
  exp.setTime(exp.getTime() + Days * 24 * 60 * 60 * 1000);
  document.cookie = name + "=" + encodeURIComponent(value) + 
                           ";expires=" + exp.toGMTString() + 
                           ";domain=" + domain + 
                           ";path=/";
};
AviviD.set_cookie_data_by_seconds = function(name, value, seconds) {
  var domain = AviviD.get_top_domain();
  var exp = new Date();
  exp.setTime(exp.getTime() + seconds);
  document.cookie = name + "=" + encodeURIComponent(value) +
                           ";expires=" + exp.toGMTString() +
                           ";domain=" + domain +
                           ";path=/";
};
AviviD.imp_event = {
  "block_like" : "guess_imp",
  "block_other" : "otherlike_imp",
  "block_history" : "footprint_imp",
  "block_keyword" : "keyword_word_hot_imp",
  "block_uuid_keyword" : "keyword_word_uuid_imp",
  "block_other_keyword" : "keyword_word_other_imp",
  "block_sider_bar" : "keyword_side_hot_imp",
  "block_sider_bar_history" : "keyword_side_footprint_imp"
};
AviviD.click_event = {
  "block_keyword" : "keyword_word_hot",
  "block_uuid_keyword" : "keyword_word_uuid",
  "block_other_keyword" : "keyword_word_other",
  "block_sider_bar" : "keyword_side_hot",
  "block_sider_bar_history" : "keyword_side_footprint"
};
AviviD.block_like = function(block_name,ajax_setting,block_setting,origin_setting){
  var avivid_foot_print = AviviD.get_cookie_data('AviviD_footprint'); 
  var lastFoot = "";
  if (avivid_foot_print != ""){
    avivid_foot_print = decodeURIComponent(avivid_foot_print);
    avivid_foot_print = JSON.parse(avivid_foot_print)
    lastFoot = avivid_foot_print[(avivid_foot_print.length -1)]
  }
  var meta_title = document.querySelector("meta[property='og:title']") !== null ? document.querySelector("meta[property='og:title']").getAttribute('content') : '_';
  if (meta_title == '_'){
     meta_title = document.querySelector("meta[name='og:title']") !== null ? document.querySelector("meta[name='og:title']").getAttribute('content') : '_';
  }
  var meta_url = document.querySelector("meta[property='og:url']") !== null ? document.querySelector("meta[property='og:url']").getAttribute('content') : '_';
  var payload = {
        "web_id": AviviD.web_id,
        "uuid" : AviviD.uuid,
        "title" : meta_title,
        "url" : location.href,
        "meta_url" : meta_url,
        "footId" : lastFoot,
        "type" : "belt1"
      };
  ajax_setting["payload"] = payload;
  AviviD.get_ajax_data(block_name,ajax_setting,block_setting,origin_setting);
};
AviviD.block_keyword = function(block_name,ajax_setting,block_setting,origin_setting){
  var cache_time = new Date().getHours();
  ajax_setting["payload"] = {"web_id" : AviviD.web_id,"cache_time" : cache_time}; /* Object.assign(obj1,obj2) */
  ajax_setting["cache"] = true;
  AviviD.get_ajax_data(block_name,ajax_setting,block_setting,origin_setting);
  ajax_setting["cache"] = false;
};
AviviD.block_uuid_keyword = function(block_name,ajax_setting,block_setting,origin_setting){
  var cache_time = new Date().getHours();
  ajax_setting["payload"] = {"web_id" : AviviD.web_id,"cache_time" : cache_time};
  ajax_setting["cache"] = true;
  AviviD.get_ajax_data(block_name,ajax_setting,block_setting,origin_setting);
  ajax_setting["cache"] = false;
};
AviviD.block_other_keyword = function(block_name,ajax_setting,block_setting,origin_setting){
  var cache_time = new Date().getHours();
  var meta_title = document.querySelector("meta[property='og:title']") !== null ? document.querySelector("meta[property='og:title']").getAttribute('content') : '_';
  if (meta_title == '_'){
     meta_title = document.querySelector("meta[name='og:title']") !== null ? document.querySelector("meta[name='og:title']").getAttribute('content') : '_';
  }
  ajax_setting["payload"] = {"web_id" : AviviD.web_id,"cache_time" : cache_time,"title" : meta_title};
  ajax_setting["cache"] = true;
  AviviD.get_ajax_data(block_name,ajax_setting,block_setting,origin_setting);
  ajax_setting["cache"] = false;
};
AviviD.block_other = function(block_name,ajax_setting,block_setting,origin_setting){
  var meta_title = document.querySelector("meta[property='og:title']") !== null ? document.querySelector("meta[property='og:title']").getAttribute('content') : '_';
  if (meta_title == '_'){
    meta_title = document.querySelector("meta[name='og:title']") !== null ? document.querySelector("meta[name='og:title']").getAttribute('content') : '_';
  }
  if (meta_title == '_'){
    meta_title = document.querySelector("title") !== null ? document.querySelector("title").textContent : '_';
  }
  var payload = {
        "web_id" : AviviD.web_id,
        "uuid" : AviviD.uuid,
        "title" : meta_title,
        "url" : location.href,
        "type" : "belt2"
      };
  ajax_setting["payload"] = payload;
  AviviD.get_ajax_data(block_name,ajax_setting,block_setting,origin_setting);
};
AviviD.block_history = function(block_name,ajax_setting,block_setting,origin_setting){
  var meta_title = document.querySelector("meta[property='og:title']") !== null ? document.querySelector("meta[property='og:title']").getAttribute('content') : '_';
  if (meta_title == '_'){
    meta_title = document.querySelector("meta[name='og:title']") !== null ? document.querySelector("meta[name='og:title']").getAttribute('content') : '_';
  }
  if (meta_title == '_'){
    meta_title = document.querySelector("title") !== null ? document.querySelector("title").textContent : '_';
  }
  var payload = {
        "web_id" : AviviD.web_id,
        "data" : meta_title,
        "url" : location.href,
        "type" : "id"
      };
  ajax_setting["async"] = false;  
  ajax_setting["payload"] = payload;
  var block_data = AviviD.get_ajax_data(block_name,ajax_setting,block_setting,origin_setting);
  var item_data = AviviD.get_product_items_for_block_history(block_data);
  var payload = {
        "web_id" : AviviD.web_id,
        "data" : item_data.toString(),
        "type" : "item"
      };
  ajax_setting["async"] = true;
  ajax_setting["payload"] = payload;
  AviviD.get_ajax_data(block_name,ajax_setting,block_setting,origin_setting);
};
AviviD.block_sider_bar = function(block_name,ajax_setting,block_setting,origin_setting){
  ajax_setting["payload"] = {"web_id" : AviviD.web_id};
  ajax_setting["cache"] = true;
  AviviD.get_ajax_data(block_name,ajax_setting,block_setting,origin_setting);
  ajax_setting["cache"] = false;
};
AviviD.get_history_for_sdider_bar = function(block_name,ajax_setting,block_setting,origin_setting){
  var meta_title = document.querySelector("meta[property='og:title']") !== null ? document.querySelector("meta[property='og:title']").getAttribute('content') : '_';
  if (meta_title == '_'){
    meta_title = document.querySelector("meta[name='og:title']") !== null ? document.querySelector("meta[name='og:title']").getAttribute('content') : '_';
  }
  if (meta_title == '_'){
    meta_title = document.querySelector("title") !== null ? document.querySelector("title").textContent : '_';
  }
  var payload = {
        "web_id" : AviviD.web_id,
        "data" : meta_title,
        "url" : location.href,
        "type" : "id"
      };
  var reuse_block_name = "block_history";
  ajax_setting = AviviD.block_data_setting[reuse_block_name];
  ajax_setting["payload"] = payload;
  ajax_setting["async"] = false;
  var history_block_data = AviviD.get_ajax_data(block_name,ajax_setting,block_setting,origin_setting);
  var item_data = AviviD.get_product_items_for_block_history(history_block_data);
  var payload = {
        "web_id" : AviviD.web_id,
        "data" : item_data.toString(),
        "type" : "item"
      };
  ajax_setting["async"] = true;
  ajax_setting["payload"] = payload;
  block_setting["tpl_render_function"] = "sider_bar_history";
  AviviD.get_ajax_data(block_name,ajax_setting,block_setting,origin_setting);
};
AviviD.languages = "zh_TW";
// navigator bar in the below
AviviD.navigation_bar = function (block_name,block_data,block_setting,origin_setting){
  var device = AviviD.isMobileDevice();
  try {
    var item_array = block_data["item_list"].split(",");
  } catch (e) {
    console.log(block_name + " data error!");
    return false; 
  }
  var data = block_data;
  var bar_html = "";
  var bar_width = AviviD.bar_setting["bar_width"];
  var prod_item_width = AviviD.bar_setting["product_item_width"];
  if (parseInt(block_setting["overwrite_bar_width"]) > 0){
    bar_width = parseInt(block_setting["overwrite_bar_width"]);
    prod_item_width = bar_width / 4;
  }
  var bar_half_width = bar_width / 2;
  var color = AviviD.bar_setting["title_text_color"];
  var prod_name_text_height = AviviD.bar_setting["product_mobile_text_height"];
  if ("overwrite_product_mobile_text_height" in block_setting &&
      parseInt(block_setting["overwrite_product_mobile_text_height"]) > 0){
      prod_name_text_height = block_setting["overwrite_product_mobile_text_height"];
  }
  var title_str = AviviD.language_settings[AviviD.languages][block_name];
  var bar_type = block_setting["old_type_no"];
  var nav_r_arrow_image = "https://rhea.advividnetwork.com/imagefile/arrowright.png";
  var force_image_style = "avivid_other_image";
  var bar_top = 0;
  var max_item_padding = 10;
  if ("overwrite_bar_top" in block_setting && 
      parseInt(block_setting["overwrite_bar_top"]) != 0){
    bar_top = block_setting["overwrite_bar_top"];
  }
  AviviD.console_logs("device : " + device + " html type : " + block_setting["tpl_render_function"]);
  var show_price = 1;
  if ("show_product_price" in AviviD.bar_setting &&
      parseInt(AviviD.bar_setting["show_product_price"]) == 0){
    show_price = 0;
  }
  if (device){ /* mobile */
    var mobile_width = document.body.clientWidth;
    var tag_id = '';
    AviviD.row_width = (mobile_width - max_item_padding) / 2 * (Object.values(item_array).length)
    var row_wid = AviviD.row_width
    if (bar_type == 2){
      var tag_id = 'avivid_recommend_tag';
      AviviD.row_width_foot = (mobile_width - max_item_padding) / 2 * (Object.values(item_array).length);
      if ((Object.values(item_array).length - 1) < 2){
        AviviD.row_width_foot = (mobile_width - max_item_padding) / 2 * 2
      }
      row_wid = AviviD.row_width_foot
    }
    AviviD.view_width = mobile_width - max_item_padding
    var item_width = (mobile_width) / 2 - (max_item_padding * 2)
    var bar_html = "";
    var force_image_height = "";
    if (document.body.clientWidth >= 600){ /* tablet */
      item_width = prod_item_width - (max_item_padding * 2);
      force_image_height = "height:200px;";
      bar_html = `<div id="`+tag_id+`" class="avivid_border" 
                       style="width:`+bar_width+`px;margin:auto;top:`+bar_top+`px;"> 
                    <div class="avivid_title_text" style="background-color:`+color+`">`+title_str+`</div>
                    <div id="avivid_bar_`+bar_type+`" class="avivid_row_bar_v2" 
                         style="width:auto;transform: translateX(0px); overflow: auto;">
                    </div>
                    <div id="arrow_right_`+bar_type+`" class="avivid_right_arrow_div">
                      <img class="avivid_right_arrow" src="`+nav_r_arrow_image+`" 
                           onclick="AviviD.mobile_move_scroll(`+bar_type+`,0)" />
                    </div>
                    <div id="arrow_left_`+bar_type+`" class="avivid_left_arrow_div">
                      <img class="avivid_left_arrow" src="`+nav_r_arrow_image+`" 
                           onclick="AviviD.mobile_move_scroll(`+bar_type+`,1)" />
                    </div>
                  </div>`;
    } else { /* cellphone */
      force_image_style = "avivid_mobile_image";
      bar_html = `<div class="avivid_border" style="width: auto;">
                    <div class="avivid_title_text" style="background-color:`+color+`">`+title_str+`</div>
                    <div id="avivid_bar_`+bar_type+`" class="avivid_row_bar_v2" 
                         style="width: auto;transform: translateX(0px); overflow: auto;">
                    </div>
                    <div id="arrow_right_`+bar_type+`" class="avivid_right_arrow_div">
                      <img class="avivid_right_arrow" src="`+nav_r_arrow_image+`" 
                           onclick="AviviD.mobile_move_scroll(`+bar_type+`,0)" />
                    </div>
                    <div id="arrow_left_`+bar_type+`" class="avivid_left_arrow_div" style="display: none;">
                      <img class="avivid_left_arrow" src="`+nav_r_arrow_image+`" 
                           onclick="AviviD.mobile_move_scroll(`+bar_type+`,1)" />
                    </div>
                  </div>`;
    }
    if (block_setting["css_html_force_append"]) {
      jQuery(block_setting["css_selector"]).append(bar_html); 
    } else {
      if (block_setting["css_html_insert_before"]) {
        jQuery(bar_html).insertBefore(block_setting["css_selector"]);
      } else {
        jQuery(bar_html).insertAfter(block_setting["css_selector"]);
      }
    }
    for (let i = 0; i < item_array.length; i++){
      if (block_data[item_array[i]] !== undefined){
        if ((data[item_array[i]]['image'] && 
             data[item_array[i]]['url'] && 
             data[item_array[i]]['title'] && 
             data[item_array[i]]['sale_price'] && 
             data[item_array[i]]['price']) !== undefined){
          var pr = "";
          /*if (data[item_array[i]]['sale_price'] != data[item_array[i]]['price']){*/
            /*pr = `<div class="avivid_price">$`+data[item_array[i]]['price']+`</div>`;*/
          /*}*/
          if (parseInt(data[item_array[i]]['sale_price']) == 0){
            data[item_array[i]]['sale_price'] = data[item_array[i]]['price'];
          }
          var extra_css = "font-size: 13px;color: rgb(102, 102, 102);";
          var avivid_item = `<div class="avivid_item" 
                                  style="width:`+item_width+`px;" 
                                  name="avivid_item" 
                                  onclick="AviviD.click_href('`+data[item_array[i]]['url']+`',`+bar_type+`);">
                               <div class="avivid_item_image" style="text-align: center;">
                                 <div class="`+force_image_style+`" 
                                      style="background-image: url('`+data[item_array[i]]['image']+`');`+force_image_height+`">
                                 </div>
                               </div>
                               <div class="avivid_mob_item_title" 
                                    style="height:`+prod_name_text_height+`px;`+extra_css+`">`+data[item_array[i]]['title']+`</div>
                                 <div class="avivid_sale_price">$`+data[item_array[i]]['sale_price']+`</div>`+pr+`</div>`;
          jQuery('#avivid_bar_'+bar_type).append(avivid_item)
        }
      }
    }
    AviviD.mobile_move_v2(bar_type)
  } else { /* pc */
    AviviD.row_width = prod_item_width * (Object.values(item_array).length);
    if (item_array.length < 4){
      AviviD.row_width = prod_item_width * 4;
    }
    AviviD["bar_scroll"][bar_type]["row_width"] = AviviD.row_width;
    var extra_css = "transform: translateX(0px);";
    var item_width = prod_item_width - (max_item_padding * 2);
    var prod_name_text_height = AviviD.bar_setting["product_pc_text_height"];
    if ("overwrite_product_pc_text_height" in block_setting && 
        parseInt(block_setting["overwrite_product_pc_text_height"]) > 0){
      prod_name_text_height = block_setting["overwrite_product_pc_text_height"];
    }
    bar_html = `<div class="avivid_border" style="width:`+bar_width+`px; margin:auto;top:`+bar_top+`px;">
                  <div class="avivid_title_text" style="background-color:`+color+`">`+title_str+`</div>
                  <div id="avivid_bar_`+bar_type+`" class="avivid_row_bar" 
                       style="width:`+AviviD.row_width+`px;`+extra_css+`">
                  </div>
                  <div class="avivid_right_arrow_div">
                    <img class="avivid_right_arrow" src="`+nav_r_arrow_image+`" 
                         onclick="AviviD.move(0,`+bar_half_width+`,`+bar_width+`,`+bar_type+`)" />
                  </div>
                  <div class="avivid_left_arrow_div">
                    <img class="avivid_left_arrow" src="`+nav_r_arrow_image+`" 
                         onclick="AviviD.move(1,`+bar_half_width+`,`+bar_width+`,`+bar_type+`)">
                  </div>
                </div>`;
    if (block_setting["css_html_force_append"]) {
      jQuery(block_setting["css_selector"]).append(bar_html);
    } else {
      if (block_setting["css_html_insert_before"]) {
        jQuery(bar_html).insertBefore(block_setting["css_selector"]);
      } else {
        jQuery(bar_html).insertAfter(block_setting["css_selector"]);
      }
    }
    for (let i = 0; i < item_array.length; i++){
      if (data[item_array[i]] !== undefined){
        if ((data[item_array[i]]['image'] && 
             data[item_array[i]]['url'] && 
             data[item_array[i]]['title'] && 
             data[item_array[i]]['sale_price'] && 
             data[item_array[i]]['price']) !== undefined){
          var pr = "";
          /*if (data[item_array[i]]['sale_price'] != data[item_array[i]]['price']){*/
            /* pr = `<div class="avivid_price">$`+data[item_array[i]]['price']+`</div>`;*/
          /*}*/
          if (parseInt(data[item_array[i]]['sale_price']) == 0){
            data[item_array[i]]['sale_price'] = data[item_array[i]]['price'];
          }
          var extra_css = "font-size: 13px;color: rgb(102, 102, 102);";
          var avivid_item = `<div class="avivid_item" style="width:`+item_width+`px;" 
                                  name="avivid_item" 
                                  onclick="AviviD.click_href('`+data[item_array[i]]['url']+`',`+bar_type+`);">
                               <div class="avivid_item_image">
                                 <div class="avivid_other_image" 
                                      style="background-image: url('`+data[item_array[i]]['image']+`')"></div>                                           </div>
                               <div class="avivid_item_title" 
                                    style="height:`+prod_name_text_height+`px;`+extra_css+`">`+data[item_array[i]]['title']+`</div>
                               <div class="avivid_sale_price">$`+data[item_array[i]]['sale_price']+`</div>`+pr+`</div>`;
          jQuery('#avivid_bar_'+bar_type).append(avivid_item);
        }
      }
    }
  }
  if (block_name in AviviD.imp_event) {
    //AviviD.gtm_event_send(AviviD.imp_event[block_name],"likr_event",location.href);
  }
  if (show_price == 0){
    jQuery(".avivid_sale_price").hide(); 
  }
  return true;
};
AviviD.button_bar = function (block_name,block_data,block_setting,origin_setting){
  var device = AviviD.isMobileDevice();
  var search_width = document.body.clientWidth;
  var icon_left = search_width - 30;
  var color = AviviD.bar_setting["title_text_color"];
  var title_str = AviviD.language_settings[AviviD.languages][block_name];
  try {
    if (parseInt(block_data["status"]) == 200){
      var data = block_data["data"];
    } else {
      console.log(block_name + " data error!");
      return false;
    }
  } catch (e) {
    console.log(block_name + " api connect error!");
    return false;
  }
  var wid = AviviD.bar_setting["bar_width"];
  if (parseInt(block_setting["overwrite_bar_width"]) > 0){
    wid = parseInt(block_setting["overwrite_bar_width"]);
  }
  var row = 0;
  var search_image = "https://rhea.advividnetwork.com/search_icon_1.png";
  var search_title = AviviD.language_settings[AviviD.languages]["search_title_text"];
  AviviD.console_logs("device : " + device + " html type : " + block_setting["tpl_render_function"]);
  if (device){ /* mobile */
    wid = search_width;
    if (document.body.clientWidth > 600){ /* tablet */
      search_width = 300;
      icon_left = 270;
    } 
  } else { /* pc */
  }
  var bar_top = 0;
  if ("overwrite_bar_top" in block_setting &&
      parseInt(block_setting["overwrite_bar_top"]) > 0){
    bar_top = parseInt(block_setting["overwrite_bar_top"]);
  }
  var bar_html = `<div id="search_bottom" style="width:`+wid+`px;top:`+bar_top+`px;">
                    <div class="avivid_keyword_title_text" 
                         style="background-color:`+color+`">`+title_str+`</div>
                      <div id="Avivid_search_keyword_bot_`+row+`" 
                           name="bottom_search" style="position:relative;">
                        <div id="Avivid_search_keyword_bot_searchArea">
                          <input id="avivid_search_box_bottom" 
                                 type="search" placeholder="`+search_title+`" 
                                 class="avivid_search_box_bottom" style="" 
                                 autocomplete="on" onsearch="AviviD.search_enter('bottom');" />
                          <img src="`+search_image+`" class="avivid_search_box_bottom_icon" style="">
                        </div>
                      </div>
                    </div>
                  </div>`;
  if (block_setting["css_html_force_append"]) {
    jQuery(block_setting["css_selector"]).append(bar_html);
  } else {
    if (block_setting["css_html_insert_before"]) {
      jQuery(bar_html).insertBefore(block_setting["css_selector"]);
    } else {
      jQuery(bar_html).insertAfter(block_setting["css_selector"]);
    }
  }
  var key_content = "";
  var data_cnt = data.length;
  for (let i = 0; i < data_cnt; i++){
    var search_word = data[i];
    key_content += `<div name="key_block" 
                         class="avivid_keyword_item" 
                         style="background-color:`+color+`" 
                         onclick="AviviD.search_word_click('`+search_word+`','`+block_name+`')">`+search_word+`</div>`;
  }
  jQuery('#Avivid_search_keyword_bot_'+row).append(key_content);
  if (block_name in AviviD.imp_event) {
    //AviviD.gtm_event_send(AviviD.imp_event[block_name],"likr_event",location.href);
  }
  return true;
};
AviviD.sider_bar = function (block_name,block_data,block_setting,origin_setting){
  AviviD.sider_bar_css(origin_setting); /* css loading */
  var device = AviviD.isMobileDevice();
  var title_str = AviviD.language_settings[AviviD.languages][block_name];
  var more_reading = AviviD.language_settings[AviviD.languages]["more_reading_text"];
  AviviD.console_logs("device : " + device + " html type : " + block_setting["tpl_render_function"]);
  var keyword_module = '';
  try {
    var data = block_data["data"];
    data.forEach(function (element) {
      keyword_module += `
        <div data-url="https://rhea-cdn.advividnetwork.com/itemPage/`+ AviviD.web_id + `/` + element + `" 
             onclick="AviviD.search_word_click('`+ element +`','`+block_name+`')">` + element + `</div>`;
    });
  } catch (e) {
    AviviD.console_logs("sider bar keyword data error");
    return false;
  }
  var bar_html = `
        <div id="SearchKeywordSide">
          <div id="SearchKeywordSide-switchBtn" 
               data-status="1" 
               onclick="AviviD.sidebarSwitchBtn();">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 11.38">
              <defs><style>.cls-1{fill:#fff;}</style></defs>
              <title>雙箭頭</title>
              <g id="圖層_2" data-name="圖層 2">
                <g id="圖層_1-2" data-name="圖層 1">
                  <polygon class="cls-1" 
                   points="14 5.69 4.57 0 4.57 2.75 0 0 0 11.38 4.57 8.62 4.57 11.38 14 5.69" />
                </g>
              </g>
            </svg>
          </div>
          <div id="SearchKeywordSide-up-tag" class="disappear search_sider_bar"
               onclick="AviviD.sidebarSwitchBtn();">` + title_str + `</div>
          <div id="SearchKeywordSide-up">
            <form action id="SearchKeywordSide-up-searchBar">
              <h4>` + title_str + `</h4>
              <input id="SearchKeywordSide-up-searchBar-input" type="search" 
                     name="" aria-label="" placeholder="` + more_reading + `" 
                     maxlength="20" autocomplete="off" 
                     onsearch="AviviD.search_enter('sider');" />
              <div id="SearchKeywordSide-up-searchBar-keyword">`+ keyword_module +`</div>
            </form>
            <div id="SearchKeywordSide-keyword"></div>
          </div>
        </div>`;
  jQuery("#SearchKeywordSide").remove();/* remove old element */
  if (keyword_module != "") {
    jQuery(block_setting["css_selector"]).append(bar_html);
    AviviD.get_history_for_sdider_bar(block_name,{},block_setting,origin_setting);
    if ("autoCloseIfWidth" in AviviD.bar_setting &&
        window.innerWidth <= parseInt(AviviD.bar_setting['autoCloseIfWidth'])) {
      AviviD.sidebarSwitchBtn(1);
    }
    if (block_name in AviviD.imp_event) {
      //AviviD.gtm_event_send(AviviD.imp_event[block_name],"likr_event",location.href);
    }
  }
  return true;
};
AviviD.sider_bar_history = function(block_name,block_data,block_setting,origin_setting){
  var device = AviviD.isMobileDevice();
  AviviD.console_logs("device : " + device + " html type : " + block_setting["tpl_render_function"]);
  var item_module = "";
  var viewed = AviviD.language_settings[AviviD.languages]["viewed_text"];
  var product_viewed = AviviD.language_settings[AviviD.languages]["product_viewed_text"];
  var force_show_mark = 0;
  var default_show_mark = 1;
  try {
    var test_data = block_data;
    force_show_mark = 1;
    jQuery.each(test_data,function(key,value){
      if (key != 'item_list') {
        item_module += `
          <div class="carouselItem" onclick="AviviD.click_href('`+value['url']+`',0);"
               data-url="`+ value['url'] + `">
            <div class="carouselItem-up">
              <img src="`+ value['image'] + `" alt="" />
            </div>
            <div class="carouselItem-down">`+ value['title'] + `</div>
          </div>`;
      }
    });
  } catch (e) {
    AviviD.console_logs("sider bar history data error");
  }
  AviviD.console_logs(item_module);
  if (item_module != ""){
    var bar_html = `<div id="SearchKeywordSide-down-tag"
                         class="disappear search_sider_bar" 
                         onclick="AviviD.sidebarSwitchBtn();">` + viewed + `</div>
                      <div id="SearchKeywordSide-down">
                        <div id="SearchKeywordSide-down-history">
                          <h4>` + product_viewed + `</h4>
                          <div id="SearchKeywordSide-down-history-carousel">
                            <div id="carouselSwitchUp" onclick="AviviD.carouselMove('up');"></div>
                            <div id="carouselContent">` + item_module + `</div>
                            <div id="carouselSwitchDown" onclick="AviviD.carouselMove('down');"></div>
                          </div>
                        </div>
                      </div>
                    </div>`;
    jQuery(bar_html).insertAfter("#SearchKeywordSide-up");
  }
  if ("autoCloseIfWidth" in AviviD.bar_setting &&
      window.innerWidth <= parseInt(AviviD.bar_setting['autoCloseIfWidth'])) {
    AviviD.sidebarSwitchBtn(1);
    default_show_mark = 0; 
  }
  block_name = "block_sider_bar_history";
  if (block_name in AviviD.imp_event) {
    //AviviD.gtm_event_send(AviviD.imp_event[block_name],"likr_event",location.href);
  }
  if (default_show_mark == 0) {
    AviviD.force_display_sider_bar(force_show_mark);
  }
  return true;
};
AviviD.force_display_sider_bar = function(show_mark){
  console.log('run')
  var cookie_name = "AviviD_display_sider_bar";
  var cookie_value = AviviD.get_cookie_data(cookie_name);
  var show_seconds = 3000;//ms
  AviviD.console_logs("sider bar display cookie : " + cookie_value);
  if (cookie_value == ""){
    if (show_mark == 1){
      AviviD.set_cookie_data(cookie_name,"1",1);
      AviviD.sidebarSwitchBtn();
      setTimeout(function(){AviviD.sidebarSwitchBtn(1);},show_seconds);
    }
  }
  return true; 
};
AviviD.sidebarSwitchBtn = function(close_flag) {
  close_flag = (typeof close_flag !== 'undefined') ?  close_flag : 0;
  var status = jQuery('#SearchKeywordSide-switchBtn').data('status'); // status: 1開啟,  0收合
  if (status == 1 || close_flag == 1) { /* close */
    jQuery('#SearchKeywordSide-switchBtn').addClass('SearchKeywordSide-switchBtn-transform');
    jQuery('#SearchKeywordSide-up, #SearchKeywordSide-down').addClass('disappear');
    jQuery('#SearchKeywordSide-up-tag, #SearchKeywordSide-down-tag').removeClass('disappear');
    jQuery('#SearchKeywordSide').addClass('SearchKeywordSide-closed');
    jQuery('#SearchKeywordSide-switchBtn').data('status', 0);
  } else { /* open */
    jQuery('#SearchKeywordSide-switchBtn').removeClass('SearchKeywordSide-switchBtn-transform');
    jQuery('#SearchKeywordSide-up-tag, #SearchKeywordSide-down-tag').addClass('disappear');
    jQuery('#SearchKeywordSide').removeClass('SearchKeywordSide-closed');
    jQuery('#SearchKeywordSide-up, #SearchKeywordSide-down').removeClass('disappear');
    jQuery('#SearchKeywordSide-switchBtn').data('status', 1);
  }
};
AviviD.carouselMove = function(choose) {
  var selector = jQuery("#carouselContent");
  var current_position = selector.scrollTop();
  var offset = selector.height();
  var scroll_dis = {"up" : current_position - offset,"down" : current_position + offset};
  selector.stop().animate({
    scrollTop: scroll_dis[choose]
  }, 200);
};
AviviD.gtm_event_send = function(event_name,event_category,event_label){
  try {
    if ("event_ga_id" in AviviD){
      gtag("config", AviviD.event_ga_id);
    }
    gtag("event",
         event_name, {
           "event_category" : event_category,
           "event_label" : event_label,
           "nonInteraction" : true
         });
  } catch (e) {
    AviviD.console_logs(e); 
  }
  try {
    if ("event_ga_id" in AviviD){
      ga('create', AviviD.event_ga_id, 'auto');
    }
    ga("send", {
         hitType : "event",
         eventCategory : event_category,
         eventAction : event_name,
         eventLabel : event_label,
         nonInteraction : true
       }); 
  } catch (e) {
    AviviD.console_logs(e);
  }
};
AviviD.search_word_click = function(word,block_type){
  if (block_type in AviviD.click_event){
    //AviviD.gtm_event_send(AviviD.click_event[block_type],"likr_event",word);
  }
  url = 'https://rhea-cdn.advividnetwork.com/itemPage/'+AviviD.web_id+'/'+word;
  url = AviviD.new_redirect_url_by_source(url,AviviD.click_event[block_type],word);
  window.open(url);
};
AviviD.new_redirect_url_by_source = function(url,source,word){
  return 'https://rhea-cdn.advividnetwork.com/itemPage/'+AviviD.web_id+'/'+source+'/'+word;
};
AviviD.search_enter = function(sw){
  var search_map = {
                     "pc" : "#avivid_search_box",
                     "mobile" : "#avivid_search_box_mobile",
                     "bottom" : "#avivid_search_box_bottom",
                     "sider" : "#SearchKeywordSide-up-searchBar-input"
                   };
  var word = jQuery(search_map[sw]).val();
  var event_key = "keyword_side_search";
  if (word != ""){
    if (sw != "sider"){
      event_key = "keyword_search";
    }
    //AviviD.gtm_event_send(event_key,"likr_event",word);
    url = 'https://rhea-cdn.advividnetwork.com/itemPage/'+AviviD.web_id+'/'+word;
    url = AviviD.new_redirect_url_by_source(url,event_key,word);
    window.open(url);
  }
};
AviviD.bar_scroll = [{
                       "row_width" : 0,
                       "transform_foot" : 0
                     },
                     {
                       "row_width" : 0,
                       "transform_foot" : 0
                     },
                     {
                       "row_width" : 0,
                       "transform_foot" : 0
                     },
                     {
                       "row_width" : 0,
                       "transform_foot" : 0
                     },
                     {
                       "row_width" : 0,
                       "transform_foot" : 0
                     }
                    ];
AviviD.move = function(type,distance,view,bar_type){
  var row = AviviD["bar_scroll"][bar_type]["row_width"];
  if (type == 0){
    AviviD["bar_scroll"][bar_type]["transform_foot"] -= distance;
    if (AviviD["bar_scroll"][bar_type]["transform_foot"] < -row + view){
      AviviD["bar_scroll"][bar_type]["transform_foot"] = -row + view;
    }
    var fin_trans = AviviD["bar_scroll"][bar_type]["transform_foot"];
  } else {
    AviviD["bar_scroll"][bar_type]["transform_foot"] += distance;
    if (AviviD["bar_scroll"][bar_type]["transform_foot"] > 0){
        AviviD["bar_scroll"][bar_type]["transform_foot"] = 0;
    }
    var fin_trans = AviviD["bar_scroll"][bar_type]["transform_foot"];
  }
  document.getElementById('avivid_bar_'+bar_type).style.transform = 'translateX('+fin_trans+'px)';
};
AviviD.mobile_move_scroll = function(id,button_type){
  var window_width = jQuery('#avivid_bar_'+id).width();
  var scroll_left = jQuery('#avivid_bar_'+id).scrollLeft();
  var scroll_width = document.getElementById('avivid_bar_'+id).scrollWidth;
  var div_amount = 0;
  if (scroll_left != 0){
    div_amount = Math.ceil(scroll_left / window_width);
  }
  if (button_type == 0){
    var move_amount = Math.ceil(div_amount);
    if (div_amount % 1 == 0){
      move_amount = div_amount + 1;
    }
    if (move_amount > scroll_width / window_width){
      move_amount = scroll_width / window_width
    }
    var move = move_amount * window_width;
    var dis = move - scroll_left;
    jQuery("#avivid_bar_"+id).animate( { scrollLeft: '+='+dis }, 200);
  } else {
    var move_amount = Math.floor(div_amount);
    if (div_amount % 1 == 0){
      move_amount = div_amount - 1;
    }
    if (move_amount < 0){
      move_amount = 0
    }
    var move = move_amount * window_width;
    var dis = scroll_left - move
    jQuery("#avivid_bar_"+id).animate( { scrollLeft: '-='+dis }, 200);
  }
};
AviviD.mobile_move_v2 = function(id){
  jQuery('#avivid_bar_'+id).scroll(function(){
    var scroll_left = jQuery('#avivid_bar_'+id).scrollLeft();
    var window_width = jQuery('#avivid_bar_'+id).width();
    var scroll_width = document.getElementById('avivid_bar_'+id).scrollWidth;
    var l_display = "block";
    if (scroll_left == 0){
      l_display = "none";
    }
    document.getElementById('arrow_left_'+id).style.display = l_display;
    var r_display = "none";
    if (Math.floor(scroll_left) <= scroll_width - window_width && 
        Math.floor(scroll_left) >= scroll_width - window_width - 5){
      r_display = "none";
    }
    document.getElementById('arrow_right_'+id).style.display = r_display;
  });
};
AviviD.click_href = function(url,type){
  var meta_title = document.querySelector("meta[property='og:title']") !== null ? document.querySelector("meta[property='og:title']").getAttribute('content') : '_';
  if (meta_title == '_'){
    meta_title = document.querySelector("meta[name='og:title']") !== null ? document.querySelector("meta[name='og:title']").getAttribute('content') : '_';
  }
  var tag_map = ["","guess","footprint","otherlike"]; 
  var tag_str = tag_map[parseInt(type)];
  var tag_map = ["keyword_side_footprint","guess_click","footprint_click","otherlike_click"];
  //AviviD.gtm_event_send(tag_map[type],"likr_event",meta_title);
  var URLs = 'https://cobra.likr.tw/api/onpage_click.php?web_id='+AviviD.web_id+
             '&os_type=&uuid='+AviviD.uuid+'&position=&type='+type+'&title='+meta_title;
  var ajax_setting = {
                      "data_url" : URLs,
                      "http_method" : "GET",
                      "async" : false,
                      "cache" : false,
                      "header" : {},
                      "timeout" : 5000,
                      "payload" : {}
                     };
  AviviD.get_ajax_data("click href record",ajax_setting,{},{});
  url = url+"&utm_content="+tag_map[type];
  if (AviviD.utm_mode == 0){
    AviviD.console_logs("origin utm params : " + url);
    url = AviviD.replace_utm_paramters(url);
    AviviD.console_logs("replace utm params : " + url);
  }
  window.open(url);
};
AviviD.replace_utm_paramters = function(url){
  let renewURL = new URL(url);
  let params = renewURL.searchParams;
  for (let pair of params.entries()) {
    if (pair[0] in AviviD.utm_replace){
      url = url.replace(pair[0]+"="+pair[1], AviviD.utm_replace[pair[0]]);
    }
  }
  return url;
};
AviviD.get_product_items_for_block_history = function(block_data){
  var footprint_id = '';
  var data = block_data;
  var cookie_value = AviviD.get_cookie_data('AviviD_footprint');
  footprint_id_str = decodeURIComponent(cookie_value);
  /* AviviD.checkFootprint(decodeURIComponent(cookie_value),1,data); */
  if (footprint_id_str == ''){ /*history is empty*/
    if (data != '_'){
      var temp_array = [data];
      AviviD.set_cookie_data('AviviD_footprint',JSON.stringify(temp_array),2);
      footprint_id = temp_array;
    }
  } else {
    if (data != '_'){
      footprint_id_str = AviviD.checkFootprint(footprint_id_str,0,data)
      footprint_id = JSON.parse(footprint_id_str);
      footprint_id.push(data);
      if (footprint_id.length > 10){
        footprint_id.splice(10,10);
      }
      AviviD.set_cookie_data('AviviD_footprint',JSON.stringify(footprint_id),2);
    } else {
      footprint_id = JSON.parse(footprint_id_str);
    }
  }
  return footprint_id;
};
AviviD.checkFootprint = function (json_str,format_mode,check_id){
  if (json_str != ''){ 
    var history_arr = JSON.parse(json_str);
    var exec_arr = history_arr;
    var regx = /[a-zA-Z]/;
    exec_arr.forEach(function(value, index, array){
      if (format_mode){
        if (regx.exec(value)){
          history_arr.splice(index, 1);
        }
      } else {
        if(value == check_id){
          history_arr.splice(index, 1);
        }
      }
    });
    return JSON.stringify(history_arr);
  }
  return json_str;
};
AviviD.transform = 0;
AviviD.transform_foot = 0;
AviviD.row_width = 0;
AviviD.row_width_foot = 0;
AviviD.console_logs = function(msg){
  if (AviviD.show_logs){
    console.log(msg);
  }
};
AviviD.loadJavaScript = function(url, callback, callbackError) {
  var script = document.createElement("script");
  script.type = "text/javascript";
  try {
    if (script.readyState) {
      script.onreadystatechange = function () {
        if (script.readyState === "loaded" || 
            script.readyState === "complete") {
          script.onreadystatechange = null;
          callback();
        }
      };
    } else {
      script.onload = function () {
        callback();
      };
    }
    script.src = url;
    document.getElementsByTagName("head")[0].appendChild(script);
  } catch (e) {
    console.log(e);
    if (null !== callbackError) callbackError(e);
  }
};
AviviD.check_allow_url = function(){
  var unlock_block = 0;
  if (AviviD.online_mode){
    unlock_block = 1;
  } else {
    if (AviviD.preview_mode){
      var url = window.location.href;
      if (url.indexOf("AviviD_debug_mode") != -1) {
        unlock_block = 1;
      }
    }
  }
  if (unlock_block){
    jQuery.each(AviviD.css_setting,function(k,v){
      jQuery('head').append('<link rel="stylesheet" type="text/css" href="'+v+'">');
    });
    jQuery.each(AviviD.block_setting,function(keys,values){
      /*window[keys](values);*/
      var check_url = AviviD.url_rules(keys,values);
      if (check_url){
        return false;
      }
    });
  }
  return true;
};
AviviD.sider_bar_css = function(block_setting){
  var url_domain = "https://rhea.advividnetwork.com/";
  var web_id = AviviD.web_id;
  var nineyi_css = 0; 
  if (web_id.indexOf("nineyi") != -1){
    nineyi_css = 1;
  }
  var css_setting = 
  [[[ url_domain + 'include_js/' + web_id + '/AviviD_sidebar_module_custom_onbuild.css',
      url_domain + 'css/AviviD_sidebar_module_origin.css'
    ],[
      url_domain + 'include_js/' + web_id + '/AviviD_sidebar_module_custom_onbuild.css',
      url_domain + 'css/AviviD_sidebar_module_origin.css'
    ]],[[
      url_domain + 'include_js/' + web_id + '/AviviD_sidebar_module_custom_v2.css',
      url_domain + 'css/AviviD_sidebar_module_origin_v2.css'
    ],[
      url_domain + 'include_js/' + web_id + '/AviviD_sidebar_module_custom_itemPage.css',
      url_domain + 'css/AviviD_sidebar_module_origin_v2.css']]];
  var css_binding = css_setting[nineyi_css][parseInt(block_setting["product_page_mark"])];
  AviviD.console_logs(css_binding);
  jQuery.each(css_binding,function(k,v){
    jQuery('head').append('<link rel="stylesheet" type="text/css" href="'+v+'">');
  });
  return true;
};
AviviD.rec_module_abtest = function(block_setting){
  var global_ratio = ('ad_block_abtest_ratio' in AviviD['settings']) ? AviviD['settings']['ad_block_abtest_ratio'] : {};
  var return_block_setting = {};
  var cookie_name = '';
  var time_range = AviviD.Date(AviviD["settings"]["ad_block_abtest_end_time"]) - new Date();
  var random_value = AviviD.get_cookie_data('AviviD_abtest_random_value') != '' ? parseInt(AviviD.get_cookie_data('AviviD_abtest_random_value')) : Math.random() * 100;
  AviviD.set_cookie_data_by_seconds('AviviD_abtest_random_value', random_value, time_range);
  for(block_type in block_setting){
    cookie_name = 'AviviD_ab_test_' + block_type;
    if (AviviD.get_cookie_data(cookie_name) != ''){
      return_block_setting[block_type] = (AviviD.get_cookie_data(cookie_name)) == 'true' ? true : false;
    } else {
      if (parseInt(block_setting[block_type]) > 0){
        return_block_setting[block_type] = (parseInt(block_setting[block_type]) >= random_value) ? true : false;
      } else {
        var ratio = (block_type in global_ratio) ? global_ratio[block_type] : 100;
        return_block_setting[block_type] = (parseInt(ratio) >= random_value) ? true : false;
      }
      AviviD.console_logs("ab test expire : " + time_range);
      if (time_range > 0){
        AviviD.set_cookie_data_by_seconds(cookie_name, return_block_setting[block_type], time_range);
      }
    }
  }
  return return_block_setting;
};
AviviD.Date = function (Date) {
  MyDate.prototype = Date.prototype;
  return MyDate;
  function MyDate() {
    if (arguments.length === 1) {
      let arg = arguments[0];
      if (Object.prototype.toString.call(arg) === '[object String]' && 
          arg.indexOf('T') === -1) {
        arguments[0] = arg.replace(/-/g, "/");
        /*console.log(arguments[0]);*/
      }
    }
    let bind = Function.bind;
    let unbind = bind.bind(bind);
    return new (unbind(Date, null).apply(null, arguments));
  }
}(Date);
AviviD.utm_replace = {"utm_source":"","utm_medium":"","utm_campaign":"","utm_term":"","utm_content":""};
AviviD.language_settings = {
                             "zh_TW" : {
                               "block_like" : "猜你喜歡",
                               "block_keyword" : "你喜歡的分類",
                               "block_other" : "其他人也看了",
                               "block_history" : "你剛剛看了",
                               "block_uuid_keyword" : "你喜歡的分類",
                               "block_other_keyword" : "你喜歡的分類",
                               "search_title_text" : "點我搜尋",
                               "block_sider_bar" : "猜你喜歡",
                               "more_reading_text" : "我還想看...",
                               "viewed_text" : "你看過的",
                               "product_viewed_text" : "你看過的商品"
                             },
                             "en_US" : {
                               "block_like" : "Recommended For You",
                               "block_keyword" : "Recommended Category",
                               "block_other" : "Frequently bought together",
                               "block_history" : "Browsing History",
                               "block_uuid_keyword" : "Recommended Category",
                               "block_other_keyword" : "Recommended Category",
                               "search_title_text" : "Search",
                               "block_sider_bar" : "Recommended For You",
                               "more_reading_text" : "More...",
                               "viewed_text" : "Browsing History",
                               "product_viewed_text" : "Browsing History"
                             },
                             "vi_VN" : {
                               "block_like" : "Gợi ý dành cho bạn",
                               "block_keyword" : "Phân loại bạn yêu thích",
                               "block_other" : "Thường xuyên mua cùng",
                               "block_history" : "Đã xem gần đây",
                               "block_uuid_keyword" : "Phân loại bạn yêu thích",
                               "block_other_keyword" : "Phân loại bạn yêu thích",
                               "search_title_text" : "Tìm kiếm",
                               "block_sider_bar" : "Gợi ý dành cho bạn",
                               "more_reading_text" : "hơn...",
                               "viewed_text" : "Đã xem gần đây",
                               "product_viewed_text" : "Đã xem gần đây"
                             }
                           };
/* check permission and call function after config loading */
if (("ad_block_enabled" in AviviD["settings"]) && 
    parseInt(AviviD.settings.ad_block_enabled) == 1){
  var url = "https://rhea.advividnetwork.com/include_js/"+AviviD.web_id+"/config.js";
  AviviD.loadJavaScript(url, function(){
    console.log(AviviD.web_id + " config.js is loaded");
    AviviD.check_allow_url(); 

  });
} else {
  console.log("ignore config");
}
