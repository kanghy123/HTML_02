<?php
session_start();

require_once('php/simple-php-captcha/simple-php-captcha.php');
require_once('php/php-mailer/PHPMailerAutoload.php');

// Step 1 - Enter your email address below.
$email = 'you@domain.com';

// If the e-mail is not working, change the debug option to 2 | $debug = 2;
$debug = 0;

if(isset($_POST['emailSent'])) {

	$subject = $_POST['subject'];

	// Step 2 - If you don't want a "captcha" verification, remove that IF.
	if (strtolower($_POST['captcha']) == strtolower($_SESSION['captcha']['code'])) {

		// Step 3 - Configure the fields list that you want to receive on the email.
		$fields = array(
			0 => array(
				'text' => 'Name',
				'val' => $_POST['name']
			),
			1 => array(
				'text' => 'Email address',
				'val' => $_POST['email']
			),
			2 => array(
				'text' => 'Message',
				'val' => $_POST['message']
			),
			3 => array(
				'text' => 'Checkboxes',
				'val' => implode($_POST['checkboxes'], ", ")
			),
			4 => array(
				'text' => 'Radios',
				'val' => $_POST['radios']
			)
		);

		$message = '';

		foreach($fields as $field) {
			$message .= $field['text'].": " . htmlspecialchars($field['val'], ENT_QUOTES) . "<br>\n";
		}

		$mail = new PHPMailer(true);

		try {

			$mail->SMTPDebug = $debug;                            // Debug Mode

			// Step 3 (Optional) - If you don't receive the email, try to configure the parameters below:

			//$mail->IsSMTP();                                         // Set mailer to use SMTP
			//$mail->Host = 'mail.yourserver.com';				       // Specify main and backup server
			//$mail->SMTPAuth = true;                                  // Enable SMTP authentication
			//$mail->Username = 'user@example.com';                    // SMTP username
			//$mail->Password = 'secret';                              // SMTP password
			//$mail->SMTPSecure = 'tls';                               // Enable encryption, 'ssl' also accepted
			//$mail->Port = 587;   								       // TCP port to connect to

			$mail->AddAddress($email);	 						       // Add a recipient

			//$mail->AddAddress('person2@domain.com', 'Person 2');     // Add another recipient
			//$mail->AddCC('person3@domain.com', 'Person 3');          // Add a "Cc" address. 
			//$mail->AddBCC('person4@domain.com', 'Person 4');         // Add a "Bcc" address. 

			$mail->SetFrom($email, $_POST['name']);
			$mail->AddReplyTo($_POST['email'], $_POST['name']);

			$mail->IsHTML(true);                                  // Set email format to HTML

			$mail->CharSet = 'UTF-8';

			$mail->Subject = $subject;
			$mail->Body    = $message;

			// Step 4 - If you don't want to attach any files, remove that code below
			if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] == UPLOAD_ERR_OK) {
				$mail->AddAttachment($_FILES['attachment']['tmp_name'], $_FILES['attachment']['name']);
			}

			$mail->Send();

			$arrResult = array ('response'=>'success');

		} catch (phpmailerException $e) {
			$arrResult = array ('response'=>'error','errorMessage'=>$e->errorMessage());
		} catch (Exception $e) {
			$arrResult = array ('response'=>'error','errorMessage'=>$e->getMessage());
		}

	} else {

		$arrResult = array ('response'=>'captchaError');

	}

}
?>
<!DOCTYPE html>
<!-- devcode: !production -->
<html>
<!-- endcode -->
<!-- devcode: production -->
<html>
<!-- endcode -->
	<head>

		<!-- Basic -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">	

		<title> Liên hệ với chúng tôi Advanced | Porto - Responsive HTML5 Template 5.7.2</title>	

		<meta name="keywords" content="HTML5 Template" />
		<meta name="description" content="Porto - Responsive HTML5 Template">
		<meta name="author" content="okler.net">

		<!-- Favicon -->
		<link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon" />
		<link rel="apple-touch-icon" href="img/apple-touch-icon.png">

		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

		<!-- Web Fonts  -->
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800%7CShadows+Into+Light" rel="stylesheet" type="text/css">

		<!-- Vendor CSS -->
		<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="vendor/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="vendor/animate/animate.min.css">
		<link rel="stylesheet" href="vendor/simple-line-icons/css/simple-line-icons.min.css">
		<link rel="stylesheet" href="vendor/owl.carousel/assets/owl.carousel.min.css">
		<link rel="stylesheet" href="vendor/owl.carousel/assets/owl.theme.default.min.css">
		<link rel="stylesheet" href="vendor/magnific-popup/magnific-popup.min.css">

		<!-- Theme CSS -->
		<link rel="stylesheet" href="css/theme.css">
		<link rel="stylesheet" href="css/theme-elements.css">
		<link rel="stylesheet" href="css/theme-blog.css">
		<link rel="stylesheet" href="css/theme-shop.css">

		<!-- Skin CSS -->
		<link rel="stylesheet" href="css/skins/default.css">

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="css/custom.css">

		<!-- Head Libs -->
		<script src="vendor/modernizr/modernizr.min.js"></script>

	</head>
	<body>

		<div class="body">
			<header id="header" data-plugin-options="{'stickyEnabled': true, 'stickyEnableOnBoxed': true, 'stickyEnableOnMobile': true, 'stickyStartAt': 57, 'stickySetTop': '-57px', 'stickyChangeLogo': true}">
				<div class="header-body">
					<div class="header-container container">
						<div class="header-row">
							<div class="header-column">
								<div class="header-logo">
									<a href="index.html">
										<img alt="Porto" width="111" height="54" data-sticky-width="82" data-sticky-height="40" data-sticky-top="33" src="img/logo.png">
									</a>
								</div>
							</div>
							<div class="header-column">
								<div class="header-row">
									<div class="header-search hidden-xs">
										<form id="searchForm" action="page-search-results.html" method="get">
											<div class="input-group">
												<input type="text" class="form-control" name="q" id="q" placeholder="Tìm kiếm..." required>
												<span class="input-group-btn">
													<button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
												</span>
											</div>
										</form>
									</div>
									<nav class="header-nav-top">
										<ul class="nav nav-pills">
											<li class="hidden-xs">
												<a href="about-us.html"><i class="fa fa-angle-right"></i> Về chúng tôi</a>
											</li>
											<li class="hidden-xs">
												<a href="contact-us.html"><i class="fa fa-angle-right"></i> Liên hệ với chúng tôi</a>
											</li>
											<li>
												<span class="ws-nowrap"><i class="fa fa-phone"></i> (123) 456-789</span>
											</li>
										</ul>
									</nav>
								</div>
								<div class="header-row">
									<div class="header-nav">
										<button class="btn header-btn-collapse-nav" data-toggle="collapse" data-target=".header-nav-main">
											<i class="fa fa-bars"></i>
										</button>
										<ul class="header-social-icons social-icons hidden-xs">
											<li class="social-icons-facebook"><a href="http://www.facebook.com/" target="_blank" title="Facebook"><i class="fa fa-facebook"></i></a></li>
											<li class="social-icons-twitter"><a href="http://www.twitter.com/" target="_blank" title="Twitter"><i class="fa fa-twitter"></i></a></li>
											<li class="social-icons-linkedin"><a href="http://www.linkedin.com/" target="_blank" title="Linkedin"><i class="fa fa-linkedin"></i></a></li>
										</ul>
										<div class="header-nav-main header-nav-main-effect-1 header-nav-main-sub-effect-1 collapse">
											<nav>
												<ul class="nav nav-pills" id="mainNav">
													<li class="dropdown">
														<a class="dropdown-toggle" href="index.html">
	Trang Chủ
														</a>
														<ul class="dropdown-menu">
															<li>
																<a href="index.html">
																	Trang đích
																</a>
															</li>
															<li class="dropdown-submenu">
																<a href="index-classic.html"> Cổ điển</a>
																<ul class="dropdown-menu">
																	<li><a href="index-classic.html" data-thumb-preview="img/previews/preview-classic.jpg"> Cổ điển - Original</a></li>
																	<li><a href="index-classic-color.html" data-thumb-preview="img/previews/preview-classic-color.jpg"> Cổ điển - Color</a></li>
																	<li><a href="index-classic-light.html" data-thumb-preview="img/previews/preview-classic-light.jpg"> Cổ điển - Light</a></li>
																	<li><a href="index-classic-video.html" data-thumb-preview="img/previews/preview-classic-video.jpg"> Cổ điển - Video</a></li>
																	<li><a href="index-classic-video-light.html" data-thumb-preview="img/previews/preview-classic-video-light.jpg"> Cổ điển - Video - Light</a></li>
																</ul>
															</li>
															<li class="dropdown-submenu">
																<a href="index-corporate.html"> Công ty <span class="tip tip-dark">hot</span></a>
																<ul class="dropdown-menu">
																	<li><a href="index-corporate.html" data-thumb-preview="img/previews/preview-corporate.jpg"> Công ty - Version 1</a></li>
																	<li><a href="index-corporate-2.html" data-thumb-preview="img/previews/preview-corporate-version2.jpg"> Công ty - Version 2</a></li>
																	<li><a href="index-corporate-3.html" data-thumb-preview="img/previews/preview-corporate-version3.jpg"> Công ty - Version 3</a></li>
																	<li><a href="index-corporate-4.html" data-thumb-preview="img/previews/preview-corporate-version4.jpg"> Công ty - Version 4</a></li>
																	<li><a href="index-corporate-5.html" data-thumb-preview="img/previews/preview-corporate-version5.jpg"> Công ty - Version 5</a></li>
																	<li><a href="index-corporate-6.html" data-thumb-preview="img/previews/preview-corporate-version6.jpg"> Công ty - Version 6</a></li>
																	<li><a href="index-corporate-7.html" data-thumb-preview="img/previews/preview-corporate-version7.jpg"> Công ty - Version 7</a></li>
																	<li><a href="index-corporate-8.html" data-thumb-preview="img/previews/preview-corporate-version8.jpg"> Công ty - Version 8</a></li>
																	<li><a href="index-corporate-hosting.html" data-thumb-preview="img/previews/preview-corporate-hosting.jpg"> Công ty - Hosting</a></li>
																</ul>
															</li>
															<li class="dropdown-submenu">
																<a href="#">One Page</a>
																<ul class="dropdown-menu">
																	<li><a href="index-one-page.html" data-thumb-preview="img/previews/preview-one-page.jpg">One Page Original</a></li>
																</ul>
															</li>
														</ul>
													</li>
													<li class="">
														<a href="demos.html">
	Bản trình diễn
														</a>
													</li>
													<li class="dropdown dropdown-mega">
														<a class="dropdown-toggle" href="#">
	Mã ngắn
														</a>
														<ul class="dropdown-menu">
															<li>
																<div class="dropdown-mega-content">
																	<div class="row">
																		<div class="col-md-3">
																			<span class="dropdown-mega-sub-title"> Mã ngắn 1</span>
																			<ul class="dropdown-mega-sub-nav">
																				<li><a href="shortcodes-accordions.html"> Hiệp định</a></li>
																				<li><a href="shortcodes-toggles.html"> Chuyển đổi</a></li>
																				<li><a href="shortcodes-tabs.html"> Các tab</a></li>
																				<li><a href="shortcodes-icons.html"> Biểu tượng</a></li>
																				<li><a href="shortcodes-icon-boxes.html">Icon Boxes</a></li>
																				<li><a href="shortcodes-carousels.html"> Băng chuyền</a></li>
																				<li><a href="shortcodes-modals.html"> Phương thức</a></li>
																				<li><a href="shortcodes-lightboxes.html"> Hộp đèn</a></li>
																			</ul>
																		</div>
																		<div class="col-md-3">
																			<span class="dropdown-mega-sub-title"> Mã ngắn 2</span>
																			<ul class="dropdown-mega-sub-nav">
																				<li><a href="shortcodes-buttons.html"> Các nút</a></li>
																				<li><a href="shortcodes-labels.html"> Nhãn</a></li>
																				<li><a href="shortcodes-lists.html"> Danh sách</a></li>
																				<li><a href="shortcodes-image-gallery.html">Image Gallery</a></li>
																				<li><a href="shortcodes-image-frames.html">Image Frames</a></li>
																				<li><a href="shortcodes-testimonials.html"> Lời chứng thực</a></li>
																				<li><a href="shortcodes-blockquotes.html"> Dấu ngoặc kép</a></li>
																				<li><a href="shortcodes-word-rotator.html">Word Rotator</a></li>
																			</ul>
																		</div>
																		<div class="col-md-3">
																			<span class="dropdown-mega-sub-title"> Mã ngắn 3</span>
																			<ul class="dropdown-mega-sub-nav">
																				<li><a href="shortcodes-call-to-action.html">Call to Action</a></li>
																				<li><a href="shortcodes-pricing-tables.html">Pricing Tables</a></li>
																				<li><a href="shortcodes-tables.html"> Bảng</a></li>
																				<li><a href="shortcodes-progressbars.html">Progress Bars</a></li>
																				<li><a href="shortcodes-counters.html"> Bộ đếm</a></li>
																				<li><a href="shortcodes-sections-parallax.html"> Phần &amp; Parallax</a></li>
																				<li><a href="shortcodes-tooltips-popovers.html"> Chú giải công cụ &amp; Popovers</a></li>
																				<li><a href="shortcodes-sticky-elements.html">Sticky Elements</a></li>
																			</ul>
																		</div>
																		<div class="col-md-3">
																			<span class="dropdown-mega-sub-title"> Mã ngắn 4</span>
																			<ul class="dropdown-mega-sub-nav">
																				<li><a href="shortcodes-headings.html"> Tiêu đề</a></li>
																				<li><a href="shortcodes-dividers.html"> Bộ chia</a></li>
																				<li><a href="shortcodes-animations.html"> Hoạt ảnh</a></li>
																				<li><a href="shortcodes-medias.html"> Phương tiện</a></li>
																				<li><a href="shortcodes-maps.html"> Bản đồ</a></li>
																				<li><a href="shortcodes-arrows.html"> Mũi tên</a></li>
																				<li><a href="shortcodes-alerts.html"> Cảnh báo</a></li>
																				<li><a href="shortcodes-posts.html"> Bài đăng</a></li>
																			</ul>
																		</div>
																	</div>
																</div>
															</li>
														</ul>
													</li>
													<li class="dropdown">
														<a class="dropdown-toggle" href="#">
	Đặc trưng
														</a>
													
														<ul class="dropdown-menu">
															<li class="dropdown-submenu">
																<a href="#"> Tiêu đề</a>
																<ul class="dropdown-menu">
																	<li class="dropdown-submenu">
																		<a href="#"> Mặc định</a>
																		<ul class="dropdown-menu">
																			<li><a href="index-classic.html"> Mặc định</a></li>
																			<li><a href="index-header-language-dropdown.html"> Mặc định + Language Dropdown</a></li>
																			<li><a href="index-header-big-logo.html"> Mặc định + Big Logo</a></li>
																		</ul>
																	</li>
																	<li class="dropdown-submenu">
																		<a href="#"> Phẳng</a>
																		<ul class="dropdown-menu">
																			<li><a href="index-header-flat.html"> Phẳng</a></li>
																			<li><a href="index-header-flat-top-bar.html"> Phẳng + Top Bar</a></li>
																			<li><a href="index-header-flat-colored-top-bar.html"> Phẳng + Colored Top Bar</a></li>
																			<li><a href="index-header-flat-top-bar-search.html"> Phẳng + Top Bar with Search</a></li>
																		</ul>
																	</li>
																	<li><a href="index-header-center.html"> Trung tâm</a></li>
																	<li><a href="index-header-below-slider.html">Below Slider</a></li>
																	<li><a href="index-header-full-video.html">Full Video</a></li>
																	<li><a href="index-header-narrow.html"> Thu hẹp</a></li>
																	<li><a href="index-header-always-sticky.html">Always Sticky</a></li>
																	<li class="dropdown-submenu">
																		<a href="#"> Trong suốt</a>
																		<ul class="dropdown-menu">
																			<li><a href="index-header-transparent.html"> Trong suốt</a></li>
																			<li><a href="index-header-transparent-bottom-border.html"> Trong suốt - Bottom Border</a></li>
																			<li><a href="index-header-semi-transparent.html">Semi Transparent</a></li>
																			<li><a href="index-header-semi-transparent-light.html">Semi Transparent - Light</a></li>
																		</ul>
																	</li>
																	<li><a href="index-header-full-width.html">Full-Width</a></li>
																	<li class="dropdown-submenu">
																		<a href="#">Navbar</a>
																		<ul class="dropdown-menu">
																			<li><a href="index-header-navbar.html">Navbar</a></li>
																			<li><a href="index-header-navbar-extra-info.html">Navbar + Extra Info</a></li>
																		</ul>
																	</li>
																	<li class="dropdown-submenu">
																		<a href="#">Side Header</a>
																		<ul class="dropdown-menu">
																			<li><a href="index-header-side-header-left.html">Side Header Left</a></li>
																			<li><a href="index-header-side-header-right.html">Side Header Right</a></li>
																			<li><a href="index-header-side-header-semi-transparent.html">Side Header Semi Transparent</a></li>
																		</ul>
																	</li>
																	<li><a href="index-header-signin.html">Sign In / Sign Up</a></li>
																	<li><a href="index-header-logged.html"> Đã ghi nhật ký</a></li>
																</ul>
															</li>
															<li class="dropdown-submenu">
																<a href="#"> Điều hướng</a>
																<ul class="dropdown-menu">
																	<li><a href="index-classic.html"> Mặc định</a></li>
																	<li><a href="index-navigation-stripe.html">Stripe</a></li>
																	<li><a href="index-navigation-top-line.html">Top Line</a></li>
																	<li><a href="index-navigation-dark-dropdown.html">Dark Dropdown</a></li>
																	<li><a href="index-navigation-colors.html">Colors</a></li>
																</ul>
															</li>
															<li class="dropdown-submenu">
																<a href="#"> Chân trang
</a>
																<ul class="dropdown-menu">
																	<li><a href="index-classic.html#footer"> Mặc định</a></li>
																	<li><a href="index-footer-advanced.html#footer">Advanced</a></li>
																	<li><a href="index-footer-simple.html#footer">Simple</a></li>
																	<li><a href="index-footer-light.html#footer">Light</a></li>
																	<li><a href="index-footer-light-narrow.html#footer">Light Narrow</a></li>
																	<li class="dropdown-submenu">
																		<a href="#">Colors</a>
																		<ul class="dropdown-menu">
																			<li><a href="index-footer-color-primary.html#footer">Primary Color</a></li>
																			<li><a href="index-footer-color-secondary.html#footer">Secondary Color</a></li>
																			<li><a href="index-footer-color-tertiary.html#footer">Tertiary Color</a></li>
																			<li><a href="index-footer-color-quaternary.html#footer">Quaternary Color</a></li>
																		</ul>
																	</li>
																	<li><a href="index-footer-latest-work.html#footer">Latest Work</a></li>
																	<li><a href="index-footer-contact-form.html#footer"> Liên hệ Form</a></li>
																</ul>
															</li>
															<li class="dropdown-submenu">
																<a href="#"> Tiêu đề trang</a>
																<ul class="dropdown-menu">
																	<li><a href="index-page-header-default.html"> Mặc định</a></li>
																	<li class="dropdown-submenu">
																		<a href="#">Colors</a>
																		<ul class="dropdown-menu">
																			<li><a href="index-page-header-color-primary.html">Primary Color</a></li>
																			<li><a href="index-page-header-color-secondary.html">Secondary Color</a></li>
																			<li><a href="index-page-header-color-tertiary.html">Tertiary Color</a></li>
																			<li><a href="index-page-header-color-quaternary.html">Quaternary Color</a></li>
																		</ul>
																	</li>
																	<li><a href="index-page-header-light.html">Light</a></li>
																	<li><a href="index-page-header-light-reverse.html">Light - Reverse</a></li>
																	<li><a href="index-page-header-custom-background.html">Custom Background</a></li>
																	<li><a href="index-page-header-parallax.html">Parallax</a></li>
																	<li><a href="index-page-header-center.html"> Trung tâm</a></li>
																</ul>
															</li>
															<li class="dropdown-submenu">
																<a href="#"> Tiện ích mở rộng quản trị viên <span class="tip tip-dark">hot</span> <em class="not-included">(Not Included)</em></a>
																<ul class="dropdown-menu">
																	<li><a href="feature-admin-forms-basic.html"> Biểu mẫu Basic</a></li>
																	<li><a href="feature-admin-forms-advanced.html"> Biểu mẫu Advanced</a></li>
																	<li><a href="feature-admin-forms-wizard.html"> Biểu mẫu Wizard</a></li>
																	<li><a href="feature-admin-forms-code-editor.html">Code Editor</a></li>
																	<li><a href="feature-admin-tables-advanced.html"> Bảng Advanced</a></li>
																	<li><a href="feature-admin-tables-responsive.html"> Bảng Responsive</a></li>
																	<li><a href="feature-admin-tables-editable.html"> Bảng Editable</a></li>
																	<li><a href="feature-admin-tables-ajax.html"> Bảng Ajax</a></li>
																	<li><a href="feature-admin-charts.html">Charts</a></li>
																</ul>
															</li>
															<li class="dropdown-submenu">
																<a href="#"> Thanh trượt</a>
																<ul class="dropdown-menu">
																	<li><a href="index-classic.html">Revolution Slider</a></li>
																	<li><a href="index-slider-nivo.html">Nivo Slider</a></li>
																</ul>
															</li>
															<li class="dropdown-submenu">
																<a href="#"> Bố cục Options</a>
																<ul class="dropdown-menu">
																	<li><a href="feature-layout-boxed.html">Boxed</a></li>
																	<li><a href="feature-layout-dark.html">Dark</a></li>
																	<li><a href="feature-layout-rtl.html">RTL</a></li>
																</ul>
															</li>
															<li class="dropdown-submenu">
																<a href="#"> Thêm</a>
																<ul class="dropdown-menu">
																	<li><a href="feature-typography.html">Typography</a></li>
																	<li><a href="feature-grid-system.html">Grid System</a></li>
																	<li><a href="feature-page-loading.html">Trang Loading</a></li>
																	<li><a href="feature-lazy-load.html">Lazy Load</a></li>
																</ul>
															</li>
														</ul>
													</li>
													<li class="dropdown">
														<a class="dropdown-toggle" href="#">
	Trang
														</a>
														<ul class="dropdown-menu">
															<li class="dropdown-submenu">
																<a href="#"> Về chúng tôi</a>
																<ul class="dropdown-menu">
																	<li><a href="about-us.html"> Về chúng tôi</a></li>
																	<li><a href="about-us-basic.html"> Về chúng tôi - Basic</a></li>
																	<li><a href="about-me.html"> Giới thiệu Me</a></li>
																</ul>
															</li>
															<li class="dropdown-submenu">
																<a href="#"> Cửa hàng</a>
																<ul class="dropdown-menu">
																	<li><a href="shop-full-width.html"> Cửa hàng - Full Width</a></li>
																	<li><a href="shop-sidebar.html"> Cửa hàng - Sidebar</a></li>
																	<li><a href="shop-product-full-width.html"> Cửa hàng - Product Full Width</a></li>
																	<li><a href="shop-product-sidebar.html"> Cửa hàng - Product Sidebar</a></li>
																	<li><a href="shop-cart.html"> Cửa hàng - Cart</a></li>
																	<li><a href="shop-login.html"> Cửa hàng - Login</a></li>
																	<li><a href="shop-checkout.html"> Cửa hàng - Checkout</a></li>
																</ul>
															</li>
															<li class="dropdown-submenu">
																<a href="#">Blog</a>
																<ul class="dropdown-menu">
																	<li><a href="blog-full-width.html">Blog Full Width</a></li>
																	<li><a href="blog-large-image.html">Blog Large Image</a></li>
																	<li><a href="blog-medium-image.html">Blog Medium Image</a></li>
																	<li><a href="blog-timeline.html">Blog Timeline</a></li>
																	<li><a href="blog-post.html">Single Post</a></li>
																</ul>
															</li>
															<li class="dropdown-submenu">
																<a href="#"> Bố cụcs</a>
																<ul class="dropdown-menu">
																	<li><a href="page-full-width.html">Full Width</a></li>
																	<li><a href="page-left-sidebar.html">Left Sidebar</a></li>
																	<li><a href="page-right-sidebar.html">Right Sidebar</a></li>
																	<li><a href="page-left-and-right-sidebars.html">Left and Right Sidebars</a></li>
																	<li><a href="page-sticky-sidebar.html">Sticky Sidebar</a></li>
																	<li><a href="page-secondary-navbar.html">Secondary Navbar</a></li>
																</ul>
															</li>
															<li class="dropdown-submenu">
																<a href="#"> Thêm</a>
																<ul class="dropdown-menu">
																	<li><a href="page-404.html">404 Error</a></li>
																	<li><a href="page-coming-soon.html">Coming Soon</a></li>
																	<li><a href="page-maintenance-mode.html"> Bảo trì Mode</a></li>
																	<li><a href="sitemap.html">Sitemap</a></li>
																</ul>
															</li>
															<li><a href="page-custom-header.html"> Tiêu đề tùy chỉnh</a></li>
															<li><a href="page-team.html">Team</a></li>
															<li><a href="page-services.html"> Dịch vụ</a></li>
															<li><a href="page-careers.html"> Nghề nghiệp</a></li>
															<li><a href="page-our-office.html"> Văn phòng của chúng tôi</a></li>
															<li><a href="page-faq.html">FAQ</a></li>
															<li><a href="page-login.html"> Đăng nhập / Đăng ký</a></li>
														</ul>
													</li>
													<li class="dropdown">
														<a class="dropdown-toggle" href="#">
	Danh mục đầu tư
														</a>
														<ul class="dropdown-menu">
															<li class="dropdown-submenu">
																<a href="#">Single Project</a>
																<ul class="dropdown-menu">
																	<li><a href="portfolio-single-small-slider.html">Small Slider</a></li>
																	<li><a href="portfolio-single-wide-slider.html">Wide Slider</a></li>
																	<li><a href="portfolio-single-full-width-slider.html">Full Width Slider</a></li>
																	<li><a href="portfolio-single-gallery.html">Gallery</a></li>
																	<li><a href="portfolio-single-carousel.html">Carousel</a></li>
																	<li><a href="portfolio-single-medias.html"> Phương tiện</a></li>
																	<li><a href="portfolio-single-full-width-video.html">Full Width Video</a></li>
																	<li><a href="portfolio-single-masonry-images.html">Masonry Images</a></li>
																	<li><a href="portfolio-single-left-sidebar.html">Left Sidebar</a></li>
																	<li><a href="portfolio-single-right-sidebar.html">Right Sidebar</a></li>
																	<li><a href="portfolio-single-left-and-right-sidebars.html">Left and Right Sidebars</a></li>
																	<li><a href="portfolio-single-sticky-sidebar.html">Sticky Sidebar</a></li>
																	<li><a href="portfolio-single-extended.html">Extended</a></li>
																</ul>
															</li>
															<li class="dropdown-submenu">
																<a href="#">Grid Bố cục</a>
																<ul class="dropdown-menu">
																	<li><a href="portfolio-grid-1-column.html">1 Column</a></li>
																	<li><a href="portfolio-grid-2-columns.html">2 Columns</a></li>
																	<li><a href="portfolio-grid-3-columns.html">3 Columns</a></li>
																	<li><a href="portfolio-grid-4-columns.html">4 Columns</a></li>
																	<li><a href="portfolio-grid-5-columns.html">5 Columns</a></li>
																	<li><a href="portfolio-grid-6-columns.html">6 Columns</a></li>
																	<li><a href="portfolio-grid-no-margins.html">No Margins</a></li>
																	<li><a href="portfolio-grid-full-width.html">Full Width</a></li>
																	<li><a href="portfolio-grid-full-width-no-margins.html">Full Width No Margins</a></li>
																	<li><a href="portfolio-grid-1-column-title-and-description.html">Title and Description</a></li>
																</ul>
															</li>
															<li class="dropdown-submenu">
																<a href="#">Masonry Bố cục</a>
																<ul class="dropdown-menu">
																	<li><a href="portfolio-masonry-2-columns.html">2 Columns</a></li>
																	<li><a href="portfolio-masonry-3-columns.html">3 Columns</a></li>
																	<li><a href="portfolio-masonry-4-columns.html">4 Columns</a></li>
																	<li><a href="portfolio-masonry-5-columns.html">5 Columns</a></li>
																	<li><a href="portfolio-masonry-6-columns.html">6 Columns</a></li>
																	<li><a href="portfolio-masonry-no-margins.html">No Margins</a></li>
																	<li><a href="portfolio-masonry-full-width.html">Full Width</a></li>
																</ul>
															</li>
															<li class="dropdown-submenu">
																<a href="#">Sidebar Bố cục</a>
																<ul class="dropdown-menu">
																	<li><a href="portfolio-sidebar-left.html">Left Sidebar</a></li>
																	<li><a href="portfolio-sidebar-right.html">Right Sidebar</a></li>
																	<li><a href="portfolio-sidebar-left-and-right.html">Left and Right Sidebars</a></li>
																	<li><a href="portfolio-sidebar-sticky.html">Sticky Sidebar</a></li>
																</ul>
															</li>
															<li class="dropdown-submenu">
																<a href="#">Ajax</a>
																<ul class="dropdown-menu">
																	<li><a href="portfolio-ajax-page.html">Ajax on Page</a></li>
																	<li><a href="portfolio-ajax-modal.html">Ajax on Modal</a></li>
																</ul>
															</li>
															<li class="dropdown-submenu">
																<a href="#"> Thêm</a>
																<ul class="dropdown-menu">
																	<li><a href="portfolio-extra-timeline.html">Timeline</a></li>
																	<li><a href="portfolio-extra-lightbox.html">Lightbox</a></li>
																	<li><a href="portfolio-extra-load-more.html">Load More</a></li>
																	<li><a href="portfolio-extra-infinite-scroll.html">Infinite Scroll</a></li>
																	<li><a href="portfolio-extra-pagination.html">Pagination</a></li>
																	<li><a href="portfolio-extra-combination-filters.html">Combination Filters</a></li>
																</ul>
															</li>
														</ul>
													</li>
													<li class="dropdown active">
														<a class="dropdown-toggle" href="#">
	Liên hệ chúng tôi
														</a>
														<ul class="dropdown-menu">
															<li><a href="contact-us.html"> Liên hệ với chúng tôi - Basic</a></li>
															<li><a href="contact-us-advanced.php"> Liên hệ với chúng tôi - Advanced</a></li>
														</ul>
													</li>
												</ul>
											</nav>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</header>

			<div role="main" class="main">

				<section class="page-header">
					<div class="container">
						<div class="row">
							<div class="col-md-12">
								<ul class="breadcrumb">
									<li><a href="#">Trang chính</a></li>
									<li class="active"> Liên hệ với chúng tôi</li>
								</ul>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<h1> Liên hệ với chúng tôi Advanced</h1>
							</div>
						</div>
					</div>
				</section>

				<!-- Google Maps - Go to the bottom of the page to change settings and map location. -->
				<div id="googlemaps" class="google-map"></div>

				<div class="container">

					<div class="row">
						<div class="col-md-6">

							<div class="offset-anchor" id="contact-sent"></div>

							<?php
							if (isset($arrResult)) {
								if($arrResult['response'] == 'success') {
								?>
								<div class="alert alert-success" id="contactSuccess">
									<strong> Thành công</strong> Your message has been sent to us.
								</div>
								<?php
								} else if($arrResult['response'] == 'error') {
								?>
								<div class="alert alert-danger" id="contactError">
									<strong>Error!</strong> There was an error sending your message.
									<span class="font-size-xs mt-sm display-block" id="mailErrorMessage"><?php echo $arrResult['errorMessage'];?></span>
								</div>
								<?php
								} else if($arrResult['response'] == 'captchaError') {
								?>
								<div class="alert alert-danger" id="contactError">
									<strong>Error!</strong> Verification failed.
								</div>
								<?php
								}
							}
							?>

							<h2 class="mb-sm mt-sm"><strong> Liên hệ</strong> Us</h2>
							<form id="contactFormAdvanced" action="<?php echo basename($_SERVER['PHP_SELF']); ?>#contact-sent" method="POST" enctype="multipart/form-data">
								<input type="hidden" value="true" name="emailSent" id="emailSent">
								<div class="row">
									<div class="form-group">
										<div class="col-md-6">
											<label>Your name *</label>
											<input type="text" value="" data-msg-required="Please enter your name." maxlength="100" class="form-control" name="name" id="name" required>
										</div>
										<div class="col-md-6">
											<label>Your email address *</label>
											<input type="email" value="" data-msg-required="Please enter your email address." data-msg-email="Please enter a valid email address." maxlength="100" class="form-control" name="email" id="email" required>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="form-group">
										<div class="col-md-12">
											<label>Subject</label>
											<select data-msg-required="Please enter the subject." class="form-control" name="subject" id="subject" required>
												<option value="">...</option>
												<option value="Option 1">Option 1</option>
												<option value="Option 2">Option 2</option>
												<option value="Option 3">Option 3</option>
												<option value="Option 4">Option 4</option>
											</select>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="form-group">
										<div class="col-md-6">
											<div class="row">
												<div class="col-md-12">
													<label>Checkboxes</label>
												</div>
											</div>
											<div class="row">
												<div class="col-md-12">
													<div class="checkbox-group" data-msg-required="Please select at least one option.">
														<label class="checkbox-inline">
															<input type="checkbox" name="checkboxes[]" id="inlineCheckbox1" value="option1"> 1
														</label>
														<label class="checkbox-inline">
															<input type="checkbox" name="checkboxes[]" id="inlineCheckbox2" value="option2"> 2
														</label>
														<label class="checkbox-inline">
															<input type="checkbox" name="checkboxes[]" id="inlineCheckbox3" value="option3"> 3
														</label>
														<label class="checkbox-inline">
															<input type="checkbox" name="checkboxes[]" id="inlineCheckbox4" value="option4"> 4
														</label>
														<label class="checkbox-inline">
															<input type="checkbox" name="checkboxes[]" id="inlineCheckbox5" value="option5"> 5
														</label>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="row">
												<div class="col-md-12">
													<label>Radios</label>
												</div>
											</div>
											<div class="row">
												<div class="col-md-12">
													<div class="radio-group" data-msg-required="Please select one option.">
														<label class="radio-inline">
															<input type="radio" name="radios" id="inlineRadio1" value="option1"> 1
														</label>
														<label class="radio-inline">
															<input type="radio" name="radios" id="inlineRadio2" value="option2"> 2
														</label>
														<label class="radio-inline">
															<input type="radio" name="radios" id="inlineRadio3" value="option3"> 3
														</label>
														<label class="radio-inline">
															<input type="radio" name="radios" id="inlineRadio4" value="option4"> 4
														</label>
														<label class="radio-inline">
															<input type="radio" name="radios" id="inlineRadio5" value="option5"> 5
														</label>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="form-group">
										<div class="col-md-12">
											<label>Attachment</label>
											<input type="file" name="attachment" id="attachment">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="form-group">
										<div class="col-md-12">
											<label>Message *</label>
											<textarea maxlength="5000" data-msg-required="Please enter your message." rows="6" class="form-control" name="message" id="message" required></textarea>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<label>Human Verification *</label>
									</div>
								</div>
								<div class="row">
									<div class="form-group">
										<div class="col-md-4">
											<div class="captcha form-control">
												<div class="captcha-image">
													<?php
													$_SESSION['captcha'] = simple_php_captcha(array(
														'min_length' => 6,
														'max_length' => 6,
														'min_font_size' => 22,
														'max_font_size' => 22,
														'angle_max' => 3
													));

													$_SESSION['captchaCode'] = $_SESSION['captcha']['code'];

													echo '<img id="captcha-image" src="' . "php/simple-php-captcha/simple-php-captcha.php/" . $_SESSION['captcha']['image_src'] . '" alt="CAPTCHA code">';
													?>
												</div>
												<div class="captcha-refresh">
													<a href="#" id="refreshCaptcha"><i class="fa fa-refresh"></i></a>
												</div>
											</div>
										</div>
										<div class="col-md-8">
											<input type="text" value="" maxlength="6" data-msg-captcha="Wrong verification code." data-msg-required="Please enter the verification code." placeholder="Type the verification code." class="form-control input-lg captcha-input" name="captcha" id="captcha" required>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<hr>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<input type="submit" id="contactFormSubmit" value="Send Message" class="btn btn-primary btn-lg pull-right" data-loading-text="Loading...">
									</div>
								</div>
							</form>
						</div>
						<div class="col-md-6">

							<h4 class="heading-primary mt-lg">Get in <strong>Touch</strong></h4>
							<p class="lead">Nội dung mô tả của website. <br /> Ut feugiat urna arcu, vel molestie nunc commodo non. Nullam vestibulum odio vitae fermentum rutrum.</p>

							<p>Mauris lobortis nulla ut aliquet interdum. Donec commodo ac elit sed placerat. Mauris rhoncus est ac sodales gravida. In eros felis, elementum aliquam nisi vel, pellentesque faucibus nulla.</p>

							<hr>

							<h4 class="heading-primary">The <strong>Office</strong></h4>
							<ul class="list list-icons list-icons-style-3 mt-xlg">
								<li><i class="fa fa-map-marker"></i> <strong> Địa chỉ:</strong> 1234 Street Name, City Name, United States</li>
								<li><i class="fa fa-phone"></i> <strong>Phone:</strong> (123) 456-789</li>
								<li><i class="fa fa-envelope"></i> <strong>Email:</strong> <a href="mailto:mail@example.com">mail@example.com</a></li>
							</ul>

							<div class="row lightbox mt-xl" data-plugin-options="{'delegate': 'a', 'type': 'image', 'gallery': {'enabled': true}}">
								<div class="col-md-4">
									<a class="img-thumbnail" href="img/office/our-office-1.jpg" data-plugin-options="{'type':'image'}">
										<img class="img-responsive" src="img/office/our-office-1.jpg" alt="Office">
										<span class="zoom">
											<i class="fa fa-search"></i>
										</span>
									</a>
								</div>
								<div class="col-md-4">
									<a class="img-thumbnail" href="img/office/our-office-2.jpg" data-plugin-options="{'type':'image'}">
										<img class="img-responsive" src="img/office/our-office-2.jpg" alt="Office">
										<span class="zoom">
											<i class="fa fa-search"></i>
										</span>
									</a>
								</div>
								<div class="col-md-4">
									<a class="img-thumbnail" href="img/office/our-office-3.jpg" data-plugin-options="{'type':'image'}">
										<img class="img-responsive" src="img/office/our-office-3.jpg" alt="Office">
										<span class="zoom">
											<i class="fa fa-search"></i>
										</span>
									</a>
								</div>
							</div>

							<hr>

							<h4 class="heading-primary">Business <strong>Hours</strong></h4>
							<ul class="list list-icons list-dark mt-xlg">
								<li><i class="fa fa-clock-o"></i> Monday - Friday - 9am to 5pm</li>
								<li><i class="fa fa-clock-o"></i> Saturday - 9am to 2pm</li>
								<li><i class="fa fa-clock-o"></i> Sunday - Closed</li>
							</ul>

						</div>
					</div>

				</div>

			</div>

			<footer id="footer">
				<div class="container">
					<div class="row">
						<div class="footer-ribbon">
							<span> Liên lạc</span>Công nghệ
						</div>
						<div class="col-md-3">
							<div class="newsletter">
								<h4> Bản tin</h4>
								<p>Keep up on our always evolving product features and technology. Enter your e-mail and subscribe to our newsletter.</p>
			
								<div class="alert alert-success hidden" id="newsletterSuccess">
									<strong> Thành công</strong> Bạn đã được thêm vào danh sách email của chúng tôi.
								</div>
			
								<div class="alert alert-danger hidden" id="newsletterError"></div>
			
								<form id="newsletterForm" action="php/newsletter-subscribe.php" method="POST">
									<div class="input-group">
										<input class="form-control" placeholder="Email Address" name="newsletterEmail" id="newsletterEmail" type="text">
										<span class="input-group-btn">
											<button class="btn btn-default" type="submit">Go!</button>
										</span>
									</div>
								</form>
							</div>
						</div>
						<div class="col-md-3">
							<h4> Tweet mới nhất</h4>
							<div id="tweet" class="twitter" data-plugin-tweets data-plugin-options="{'username': '', 'count': 2}">
								<p> Vui lòng đợi...</p>
							</div>
						</div>
						<div class="col-md-4">
							<div class="contact-details">
								<h4> Liên hệ với chúng tôi</h4>
								<ul class="contact">
									<li><p><i class="fa fa-map-marker"></i> <strong> Địa chỉ:</strong> 1234 Street Name, City Name, United States</p></li>
									<li><p><i class="fa fa-phone"></i> <strong>Phone:</strong> (123) 456-789</p></li>
									<li><p><i class="fa fa-envelope"></i> <strong>Email:</strong> <a href="mailto:mail@example.com">mail@example.com</a></p></li>
								</ul>
							</div>
						</div>
						<div class="col-md-2">
							<h4>Follow Us</h4>
							<ul class="social-icons">
								<li class="social-icons-facebook"><a href="http://www.facebook.com/" target="_blank" title="Facebook"><i class="fa fa-facebook"></i></a></li>
								<li class="social-icons-twitter"><a href="http://www.twitter.com/" target="_blank" title="Twitter"><i class="fa fa-twitter"></i></a></li>
								<li class="social-icons-linkedin"><a href="http://www.linkedin.com/" target="_blank" title="Linkedin"><i class="fa fa-linkedin"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
				<div class="footer-copyright">
					<div class="container">
						<div class="row">
							<div class="col-md-1">
								<a href="index.html" class="logo">
									<img alt="Porto Website Template" class="img-responsive" src="img/logo-footer.png">
								</a>
							</div>
							<div class="col-md-7">
								<p>© Copyright 2017. All Rights Reserved.</p>
							</div>
							<div class="col-md-4">
								<nav id="sub-menu">
									<ul>
										<li><a href="page-faq.html">FAQ's</a></li>
										<li><a href="sitemap.html">Sitemap</a></li>
										<li><a href="contact-us.html"> Liên hệ</a></li>
									</ul>
								</nav>
							</div>
						</div>
					</div>
				</div>
			</footer>
		</div>

		<!-- Vendor -->
		<script src="vendor/jquery/jquery.min.js"></script>
		<script src="vendor/jquery.appear/jquery.appear.min.js"></script>
		<script src="vendor/jquery.easing/jquery.easing.min.js"></script>
		<script src="vendor/jquery-cookie/jquery-cookie.min.js"></script>
		<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
		<script src="vendor/common/common.min.js"></script>
		<script src="vendor/jquery.validation/jquery.validation.min.js"></script>
		<script src="vendor/jquery.easy-pie-chart/jquery.easy-pie-chart.min.js"></script>
		<script src="vendor/jquery.gmap/jquery.gmap.min.js"></script>
		<script src="vendor/jquery.lazyload/jquery.lazyload.min.js"></script>
		<script src="vendor/isotope/jquery.isotope.min.js"></script>
		<script src="vendor/owl.carousel/owl.carousel.min.js"></script>
		<script src="vendor/magnific-popup/jquery.magnific-popup.min.js"></script>
		<script src="vendor/vide/vide.min.js"></script>
		
		<!-- Theme Base, Components and Settings -->
		<script src="js/theme.js"></script>

		<!-- Current Page Vendor and Views -->
		<script src="js/views/view.contact.js"></script>
		
		<!-- Theme Custom -->
		<script src="js/custom.js"></script>
		
		<!-- Theme Initialization Files -->
		<script src="js/theme.init.js"></script>

		<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY"></script>
		<script>

			/*
			Map Settings

				Find the Latitude and Longitude of your address:
					- http://universimmedia.pagesperso-orange.fr/geo/loc.htm
					- http://www.findlatitudeandlongitude.com/find-address-from-latitude-and-longitude/

			*/

			// Map Markers
			var mapMarkers = [{
				address: "217 Summit Boulevard, Birmingham, AL 35243",
				html: "<strong>Alabama Office</strong><br>217 Summit Boulevard, Birmingham, AL 35243<br><br><a href='#' onclick='mapCenterAt({latitude: 33.44792, longitude: -86.72963, zoom: 16}, event)'>[+] zoom here</a>",
				icon: {
					image: "img/pin.png",
					iconsize: [26, 46],
					iconanchor: [12, 46]
				}
			},{
				address: "645 E. Shaw Avenue, Fresno, CA 93710",
				html: "<strong>California Office</strong><br>645 E. Shaw Avenue, Fresno, CA 93710<br><br><a href='#' onclick='mapCenterAt({latitude: 36.80948, longitude: -119.77598, zoom: 16}, event)'>[+] zoom here</a>",
				icon: {
					image: "img/pin.png",
					iconsize: [26, 46],
					iconanchor: [12, 46]
				}
			},{
				address: "New York, NY 10017",
				html: "<strong>New York Office</strong><br>New York, NY 10017<br><br><a href='#' onclick='mapCenterAt({latitude: 40.75198, longitude: -73.96978, zoom: 16}, event)'>[+] zoom here</a>",
				icon: {
					image: "img/pin.png",
					iconsize: [26, 46],
					iconanchor: [12, 46]
				}
			}];

			// Map Initial Location
			var initLatitude = 37.09024;
			var initLongitude = -95.71289;

			// Map Extended Settings
			var mapSettings = {
				controls: {
					panControl: true,
					zoomControl: true,
					mapTypeControl: true,
					scaleControl: true,
					streetViewControl: true,
					overviewMapControl: true
				},
				scrollwheel: false,
				markers: mapMarkers,
				latitude: initLatitude,
				longitude: initLongitude,
				zoom: 5
			};

			var map = $('#googlemaps').gMap(mapSettings),
				mapRef = $('#googlemaps').data('gMap.reference');

			// Map Center At
			var mapCenterAt = function(options, e) {
				e.preventDefault();
				$('#googlemaps').gMap("centerAt", options);
			}

			// Styles from https://snazzymaps.com/
			var styles = [{"featureType":"water","elementType":"geometry","stylers":[{"color":"#e9e9e9"},{"lightness":17}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":20}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ffffff"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#ffffff"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":16}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":21}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#dedede"},{"lightness":21}]},{"elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#ffffff"},{"lightness":16}]},{"elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#333333"},{"lightness":40}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#f2f2f2"},{"lightness":19}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#fefefe"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#fefefe"},{"lightness":17},{"weight":1.2}]}];

			var styledMap = new google.maps.StyledMapType(styles, {
				name: 'Styled Map'
			});

			mapRef.mapTypes.set('map_style', styledMap);
			mapRef.setMapTypeId('map_style');

		</script>

		<!-- Google Analytics: Change UA-XXXXX-X to be your site's ID. Go to http://www.google.com/analytics/ for more information.
		<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		
			ga('create', 'UA-12345678-1', 'auto');
			ga('send', 'pageview');
		</script>
		 -->

	</body>
</html>
