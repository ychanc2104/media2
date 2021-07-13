

<!doctype html>
<html>
<head>


    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- <meta property="og:title" itemprop="name" content="PLG》共同抗疫！攻城獅捐10％球衣收入給醫護人員 - 籃球">  -->

	<meta property="og:title" itemprop="name" content="1、2字頭占優勢 八德房市交易熱 磁吸北客比價移居 - 財經">

    <!-- CSS -->
    <!-- bootstrap 4.6 css-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous"> 
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css"/>


    <!-- should load js below in order, required for bootbox 5.5.2-->
    <!-- jQuery minified -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!-- popper.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js" integrity="sha512-2rNj2KJ+D8s1ceNasTIex6z4HWyOnEYLVC3FigGOmyQCZc2eBXKgOxQmo3oKLHyfcj53uz4QMsRCWNbLd32Q1g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- bootstrap 4.6 js-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
    <!-- bootbox 5.5.2 js -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js"></script>
   


    <!-- date range picker http://www.daterangepicker.com/#usage -->
    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
 -->



    <style type="text/css" media = "screen">
        .page-link{
        cursor: pointer;
        }

		
		#keyword
		{
			color: #00008B;
			text-align: center;
			font-weight: 500;
			font-size: 18px;

			background-color: #F0FFFF;
			border-radius:20px;
			width:fit-content;
			min-width: 5em;
			margin: auto;
			cursor: pointer; 
			display: inline-block;
			margin: 0 0 0 10px;


		}
    </style>

</head>


<body>








<p>Click the button to demonstrate the prompt box.</p>




<button onclick="myfunction()" >Try it</button>

<p id="demo"></p>

<div class="article-hash-tag">
<span>#台灣</span>

</div>

<!-- <div id="keyword" onclick="redirect_url()" style="background-color:#008cd6; border-radius:20px; width:80px; margin: auto;">關鍵字</div> -->




<script type="text/javascript" defer>

	function render_ad_keyword()
	{
		const title = getMeta('og:title');
		console.log('title is '+title)
		$.ajax({
			type: 'get',
			url: 'http://35.194.177.54/api/clare/ad_key.php',
			dateType: 'json',
			data:
			{
				'title': title,
			}, 
			success: function(url_keyword_json)
			{
				console.log(url_keyword_json);

				const url = String(JSON.parse(url_keyword_json)[0]);
				console.log(url);
				const keyword = JSON.parse(url_keyword_json)[1];
				console.log('keyword is '+keyword);

				const kw_block = 
				`
				<div id="keyword" onclick="redirect_url('`+url+`')"># `+keyword+`</div>
				`;

				$(kw_block).insertAfter(".article-hash-tag");
				// $(kw_block).appendChild(".article-hash-tag");


			},
		});
	}



	function getMeta(metaName) {
	const metas = document.getElementsByTagName('meta');

	for (let i = 0; i < metas.length; i++) {
		if (metas[i].getAttribute('property') === metaName) {
		return metas[i].getAttribute('content');
		}
	}
	return 'not found';
	}

	// console.log(getMeta('og:title'));



	function redirect_url(url)
	{
		window.location.assign(url);
	}



	$(document).ready(function(){
		render_ad_keyword();
	});








	// 上傳檔案顯示檔名
	function upload_video() {
		$('#ad_video').click();
	}

	function upload_small_image() {
		$('#ad_small_image').click();
	}

	function upload_onpage_big_image() {
		$('#ad_onpage_big_image').click();
	}

	function upload_big_image() {
		$('#ad_big_image').click();
	}

	function upload_logo() {
		$('#ad_logo').click();
	}


	function change_sample_image(ad_type)
	{
		if (ad_type == 'clip_ad') // 夾報
		{
			sample_ad_type = 'clip_ad';
			$("#sample_device").css("display", "inline");
			$("#sample_device_icon").css("display", "inline");
			if (sample_device == 'mobile') { // 夾報 手機版
				$('#preview_sample_img').attr("src", "https://sun.advividnetwork.com/ad_replace/public/img/new_upload_sample/android_clip.png");
			} else { // 夾報 電腦版
				$('#preview_sample_img').attr("src", "https://sun.advividnetwork.com/ad_replace/public/img/new_upload_sample/pc_clip.png");
			}
			$("#sample_title").text("夾報廣告");
			$("#sample_content").text("建議使用橫向(2:1)的圖片");
		}
		else if (ad_type == 'direct_ad_no_image')
		{
			sample_ad_type = 'direct_ad_no_image';
			$("#sample_device").css("display", "none");
			$("#sample_device_icon").css("display", "none");
			$('#preview_sample_img').attr("src", "https://sun.advividnetwork.com/ad_replace/public/img/new_upload_sample/mac_no_image.png");
			$("#sample_title").text("直推無圖廣告");
			$("#sample_content").text("建議使用方形(1:1)的圖片");
		}

		else if (ad_type == 'clip_ad_no_image')
		{
			sample_ad_type = 'clip_ad_no_image';
			$("#sample_device").css("display", "inline");
			$("#sample_device_icon").css("display", "inline");
			if (sample_device == 'mobile') { // 夾報 手機版
				$('#preview_sample_img').attr("src", "https://sun.advividnetwork.com/ad_replace/public/img/new_upload_sample/android_clip_no_image.png");
			} else { // 夾報 電腦版
				$('#preview_sample_img').attr("src", "https://sun.advividnetwork.com/ad_replace/public/img/new_upload_sample/pc_clip_no_image.png");
			}
			$("#sample_title").text("夾報無圖廣告");
			$("#sample_content").text("建議使用方形(1:1)的圖片");
		}

		else if (ad_type == 'onpage')
		{
			sample_ad_type = 'onpage';
			$("#sample_device").css("display", "inline");
			$("#sample_device_icon").css("display", "inline");
			if (sample_device == 'mobile') { // onpage 手機版
				$('#preview_sample_img').attr("src", "https://sun.advividnetwork.com/ad_replace/public/img/new_upload_sample/onpageios.png");
			} else { // onpage 電腦版
				$('#preview_sample_img').attr("src", "https://sun.advividnetwork.com/ad_replace/public/img/new_upload_sample/onpagepc.png");
			}
			$("#sample_title").text("Onpage 推播");
			$("#sample_content").html("<div style='margin-bottom:-4px;'>跨越平台、裝置的推播,支援ios手機、平板,</div>與所有不支援原生推播廣告的瀏覽器");
		}
		else // default is direct_ad (直推廣告)
		{
			sample_ad_type = 'direct_ad';
			$("#sample_device").css("display", "inline");
			$("#sample_device_icon").css("display", "inline");
			if (sample_device == 'mobile') { // 直推 手機版
				$('#preview_sample_img').attr("src", "https://sun.advividnetwork.com/ad_replace/public/img/new_upload_sample/android_direct.png");
			} else { // 直推 電腦版
				$('#preview_sample_img').attr("src", "https://sun.advividnetwork.com/ad_replace/public/img/new_upload_sample/pc_direct.png");
			}
			$("#sample_title").text("直推廣告");
			$("#sample_content").text("建議使用橫向(2:1)的圖片");

		}



	}



	function myfunction()
	{
		bootbox.dialog({
				size: 'extra-large',
				onEscape: true,
				backdrop: true,
				message:`

				<div id="template_window" style="background_white">
					<div class='row py-4'>
						<div class='form-row'>

							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div>
									<p>廣告上稿設定</p>
									<hr style="border: 0;height: 1px;background-color: #a7b9c6;margin: 0px;">
								</div>
							</div>

							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div class="out_line_upper">
									<!-- 廣告版位 左 -->
									<div class="col-lg-5 col-md-6 col-sm-12 col-xs-12">

										<div style="margin-top: 10px;padding-left: 10px;">
											<span>廣告版位</span>
											<span style="color:gray;font-size:80%;">(選擇效果最好的位置向適合的對象投遞廣告。)</span>
											<br>
											<br>
											<span style="padding-left: 10px;font-size:90%;">編輯版位</span>
											<div class="inner_out_line">
												<!-- 倒三角形 -->
												<div
													style="display: inline-block;width: 0px;height: 0px;border-top: 8px solid #A0A0A0;border-left: 5px solid transparent;border-right: 5px solid transparent;margin-left: 10px;margin-top: 10px;">
												</div>
												<span style="font-size:90%;margin-left: -4px;">|推播廣告</span>
												<input style="float: right;margin-right:20px;margin-top:8px;"
													type="checkbox" name="all_ad" value="all_ad"
													onchange="select_all_ad_type()">
												<br>
												<div style="width:80%;margin-left:27px;">
													<span
														style="color:#C0C0C0;font-size:80%;">發送推薦商品及最新消息的通知給訂閱您的用戶,讓他們接受到第一手消息</span>
												</div>
												<div class="multi_selection"
													onmouseover="change_sample_image('direct_ad')">
													<span class="check_box_text">直推廣告</span>
													<input style="margin-right: 20px;float: right;" type="checkbox"
														name="direct_ad" value="direct_ad" onclick="detect_all()">
												</div>
												<div class="multi_selection"
													onmouseover="change_sample_image('clip_ad')">
													<span class="check_box_text">夾報廣告</span>
													<input style="margin-right: 20px;float: right;" type="checkbox"
														name="clip_ad" value="clip_ad" onclick="detect_all()">
												</div>
												<div class="multi_selection"
													onmouseover="change_sample_image('direct_ad_no_image')">
													<span class="check_box_text">直推無圖廣告</span>
													<input style="margin-right: 20px;float: right;" type="checkbox"
														name="direct_ad_no_image" value="direct_ad_no_image"
														onclick="detect_all()">
												</div>
												<div class="multi_selection"
													onmouseover="change_sample_image('clip_ad_no_image')">
													<span class="check_box_text">夾報無圖廣告</span>
													<input style="margin-right: 20px;float: right;" type="checkbox"
														name="clip_ad_no_image" value="clip_ad_no_image"
														onclick="detect_all()">
												</div>


												<div class="multi_selection"
													onmouseover="change_sample_image('onpage')">
													<span class="check_box_text">Onpage 推播</span>
													<input style="margin-right: 20px;float: right;" type="checkbox"
														name="onpage" value="onpage" onclick="detect_all()">
												</div>

												<hr style="border-top: 1px solid black;margin:0;">

												<div class="multi_selection_title"
													onmouseover="change_sample_image('onpage_video')">
													<span style="font-size:90%;">影音廣告</span>
													<input style="float: right;margin-right:20px;" type="checkbox"
														name="video_ad" value="video_ad"
														onclick="select_video_onpage()">
												</div>

												<div style="width:80%;margin-left:27px;">
													<span
														style="color:#C0C0C0;font-size:80%;">跨平台的影音廣告,隨時曝光您的品牌</span>
												</div>



											</div>
										</div>
									</div>
									<!-- 廣告版位 右 -->
									<div class="col-lg-7 col-md-6 col-sm-12 col-xs-12">

										<div style="margin-top: 10px;">
											<span id="sample_device_icon"
												style="color:gray;font-size:90%;float:right;">
												<i class="fa fa-exchange" aria-hidden="true"></i>
											</span>
											<span id="sample_device"
												style="color:gray;font-size:80%;float:right;margin-left:5px;cursor: pointer;"
												value="desktop" onclick="switch_device()">切換預覽手機版</span>
										</div>

										<br>
										<div style="text-align: center">
											<img id="preview_sample_img"
												src="https://sun.advividnetwork.com/ad_replace/public/img/new_upload_sample/pc_direct.png"
												alt="preview_sample_img" height="290px">
										</div>

										<div style="text-align: center;">
											<span id="sample_title">直推廣告</span>
											<br>
											<span id="sample_content"
												style="color:gray;font-size:80%;">建議使用橫向(2:1)的圖片</span>
										</div>
									</div>
								</div>
							</div>

							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div class="out_line_lower">

									<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
										<div style="margin-top: 10px;padding-left: 10px;">
											<span>編輯廣告</span><br>

											<div class="edit_fields">
												<div class="edit_field close_preview">
													<span style="font-size:90%;display:block">@lang('default.set_name')：</span>
													<input type="text" id="template_name" class="text_input" value=""/>
												</div>

												<div class="edit_field">
													<span style="font-size:90%;display:block">@lang('default.ad_title')：</span>
													<input class="text_input" type="text" name="ad_title" id="template_title"
														placeholder="建議輸入13字以內" value=""
														oninput="change_preview_title(this)">
												</div>

												<div class="edit_field">
													<span style="font-size:90%;display:block">@lang('default.ad_inner_text')：</span>
													<input class="text_input" type="text" name="ad_content" id="template_msg"
														placeholder="建議輸入19字以內" value=""
														oninput="change_preview_content(this)">
												</div>

												<div class="edit_field">
													<span style="font-size:90%;display:block">@lang('default.target_url')：
														<span style="color:gray;font-size:60%;">可填寫商品頁面</span>
													</span>

													<input class="text_input" type="text" name="ad_url" id="template_url"
														placeholder="https://" value="">
												</div>
												<div class="edit_field">
													<span style="font-size:90%;display:block">LOGO上傳：
														<span style="color:gray;font-size:60%;">100*100px,jpg,jpeg,png</span>
													</span>

													<div class="file_input">
														<input type="file" name="ad_logo" id="ad_logo"
															style="display:inline;width:0.1px;height:0.1px;"
															onchange="push_preview.preview_icon_change(this)"
															accept="image/jpg, image/jpeg, image/png">
															
														<span style="color:#C0C0C0;font-size: 90%;line-height: 25px;vertical-align: middle;"
															id="ad_logo_file_name">選擇檔案</span>
														<span
															style="font-size:110%;float:right;cursor: pointer;color:#C0C0C0;margin-top: -1.0%;font-size: 170%;margin-right: 5px;"
															onclick="upload_logo()">
															<div style="position:absolute;left: 81.525%;border: 0.8px solid #C0C0C0;margin-top: 3.8%;width: 10px;"> </div>
															<i class="fa fa-folder-o" aria-hidden="true"></i>
														</span>
													</div>
												</div>

												<div class="edit_field">
													<span style="font-size:90%;display:block">主圖上傳：
														<span style="color:gray;font-size:60%;">300*150px,jpg,jpeg,png</span>
													</span>

													<div class="file_input">
														<input type="file" name="ad_big_image" id="ad_big_image"
															style="display:inline;width:0.1px;height:0.1px;"
															onchange="push_preview.preview_bigimage_change(this)"
															accept="image/jpg, image/jpeg, image/png">
														<span style="color:#C0C0C0;font-size: 90%;line-height: 25px;vertical-align: middle;"
															id="ad_big_image_file_name">選擇檔案</span>
														<span
															style="font-size:110%;float:right;cursor: pointer;color:#C0C0C0;margin-top: -1.0%;font-size: 170%;margin-right: 5px;"
															onclick="upload_big_image()">
															<div style="position:absolute;left: 81.525%;border: 0.8px solid #C0C0C0;margin-top: 3.8%;width: 10px;"> </div>
															<i class="fa fa-folder-o" aria-hidden="true"></i>
														</span>
													</div>
												</div>

												<div class="edit_field">
													<span style="font-size:90%;display:block">小圖上傳：
														<span style="color:gray;font-size:60%;">100*100px,jpg,jpeg,png</span>
													</span>

													<div class="file_input">
														<input type="file" name="ad_small_image" id="ad_small_image"
															style="display:inline;width:0.1px;height:0.1px;"
															onchange="push_preview.preview_smallimage_change(this)"
															accept="image/jpg, image/jpeg, image/png">
														<span style="color:#C0C0C0;font-size: 90%;line-height: 25px;vertical-align: middle;"
															id="ad_small_image_file_name">選擇檔案</span>
														<span
															style="font-size:110%;float:right;cursor: pointer;color:#C0C0C0;margin-top: -1.0%;font-size: 170%;margin-right: 5px;"
															onclick="upload_small_image()">
															<div style="position:absolute;left: 81.525%;border: 0.8px solid #C0C0C0;margin-top: 3.8%;width: 10px;"> </div>
															<i class="fa fa-folder-o" aria-hidden="true"></i>
														</span>
													</div>
												</div>


												<div class="edit_field">
													<span style="font-size:90%;display:block">Onpage主圖上傳：
														<span
															style="color:gray;font-size:60%;">362*130px,jpg,jpeg,png</span>
													</span>

													<div class="file_input">
														<input type="file" name="ad_onpage_big_image"
															id="ad_onpage_big_image"
															style="display:inline;width:0.1px;height:0.1px;"
															onchange="push_preview.preview_onpage_bigimage_change(this)"
															accept="image/jpg, image/jpeg, image/png">
														<span style="color:#C0C0C0;font-size: 90%;line-height: 25px;vertical-align: middle;"
															id="ad_onpage_big_image_file_name">選擇檔案</span>
														<span
															style="font-size:110%;float:right;cursor: pointer;color:#C0C0C0;margin-top: -1.0%;font-size: 170%;margin-right: 5px;"
															onclick="upload_onpage_big_image()">
															<div style="position:absolute;left: 81.525%;border: 0.8px solid #C0C0C0;margin-top: 3.8%;width: 10px;"> </div>
															<i class="fa fa-folder-o" aria-hidden="true"></i>
														</span>
													</div>
												</div>

												<div class="edit_field">
													<span style="font-size:90%;display:block">影音檔案上傳：
														<span style="color:gray;font-size:60%;">16:9,HD,mp4</span>
													</span>

													<div class="file_input">
														<input type="file" name="ad_video" id="ad_video"
															style="display:inline;width:0.1px;height:0.1px;"
															onchange="change_onpage_video(this)" accept="video/mp4"
															>
														<span style="color:#C0C0C0;font-size: 90%;line-height: 25px;vertical-align: middle;"
															id="video_file_name">選擇檔案</span>
														<span
															style="font-size:110%;float:right;cursor: pointer;color:#C0C0C0;margin-top: -1.0%;font-size: 170%;margin-right: 5px;"
															onclick="upload_video()">
															<div style="position:absolute;left: 81.525%;border: 0.8px solid #C0C0C0;margin-top: 3.8%;width: 10px;"> </div>
															<i class="fa fa-folder-o" aria-hidden="true"></i>
														</span>
													</div>
													<div class="warning_msg">*請填寫正確資料!</div>
												</div>
											</div>
										</div>
									</div>


									<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
										<div style="margin-top: 10px;">
											<br>
											<span>預覽廣告</span><br>
											<hr style="border-top: 1px solid black;margin:0;">
											<!-- <select id="preview_ad_type" onchange="change_preview_ad_type()">
													<option value="direct">直推廣告</option>
													<option value="clip">夾報廣告</option>
													<option value="direct_no_image">直推無圖廣告</option>
													<option value="clip_no_image">夾報無圖廣告</option>
												</select> -->
										</div>
									</div>

									<div class="ad_select_options">
										<div onclick="show_normal_ad_options()">
											<span id="current_normal_ad_selection">推播廣告 </span>
											<i id="normall_ad_arrow" class="down_arrow"></i>
										</div>
										<ul class="normal_ad_options">
											<li class="ad_option"
												onclick="change_current_normal_ad_selection(this)">
												直推廣告</li>
											<li class="ad_option"
												onclick="change_current_normal_ad_selection(this)">
												夾報廣告</li>
											<li class="ad_option"
												onclick="change_current_normal_ad_selection(this)">
												直推無圖廣告</li>
											<li class="ad_option"
												onclick="change_current_normal_ad_selection(this)">
												夾報無圖廣告</li>
											<li class="ad_option"
												onclick="change_current_normal_ad_selection(this)">
												Onpage推播</li>
										</ul>
										<div class="" onclick="change_current_normal_ad_selection(this)">
											影音廣告
										</div>
									</div>

									<div id="platform" class="platform_options">
										<span id="platform_windows" class="platform_option selected"
											onclick="detect_preview_platform('Windows')">Windows</span> <span
											class="platform_option_divider">|</span>
										<span id="platform_android" class="platform_option"
											onclick="detect_preview_platform('Android')">Android</span>
									</div>
									<div class="preview_window_group_new" id="windows_preview_group">
									</div>								
								</div>
							</div>
						</div>
					</div>
				</div>

				<div style="display: flex;justify-content: center;">
					<input
						type="button"
						class="btn btn-info"
						style="background-color:#426481;border-color:#426481;margin-top:15px;" 
						onclick="add_or_edit_push_tempatle_to_table('','',document.querySelector('.edit_field #template_title').value,document.querySelector('.edit_field #template_title').value,document.querySelector('.edit_field #template_msg').value,document.querySelector('.edit_field #template_url').value,logo_img,big_img,small_img,'_','_','','','',onpage_big_img,original_video,check_onpage_video, check_big_img)"
						value="@lang('default.submit')">
				</div>

			`
			});
	}

</script>





	<!-- default insert uppon #footer -->
	<footer id="footer">

	</footer>


</body>






<!-- <script type="text/javascript">
	var AviviD = {
		settings: {
			ad_block_enabled: 1
		},
		web_id: "ohohfresh",

		status: {
			avivid_css: 1,
		},

	};

    $.ajax({
        type: 'get',
        url: '/render_url',
        dateType: 'json',
        data:
        {
            'title': "國安特勤夾帶萬條私菸回台 吳宗憲遭重判10年4月 - 社會",
		}, 
        success: function(url_keyword_json)
        {
            const url = JSON.parse(url_keyword_json)[0];
			const keyword = JSON.parse(url_keyword_json)[1];

			console.log(keyword)
        },
    });


</script> -->




<!-- <script type="text/javascript" src="https://avivid.likr.tw/api/ios_water_webpush_v19.min.js"></script> -->
<!-- 
<script type="text/javascript" src="{{ asset('/js/recommendation/recommendation_core.js')}}"></script>
<script type="text/javascript" src="{{ asset('/js/recommendation/config.js')}}"></script> -->

<!-- <script type="text/javascript">
	console.log(AviviD.block_setting.index.block.block_like.tpl_render_function);
	AviviD.navigation_bar()
	AviviD.force_display_sider_bar(1)
</script>  -->
