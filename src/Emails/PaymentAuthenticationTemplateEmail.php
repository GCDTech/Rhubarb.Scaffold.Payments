<?php

namespace Gcd\Scaffold\Payments\Emails;

use Gcd\Scaffold\Payments\UI\Entities\PaymentEntity;
use Rhubarb\Crown\Sendables\Email\Email;
use Rhubarb\Crown\Sendables\Email\TemplateEmail;

abstract class PaymentAuthenticationTemplateEmail extends TemplateEmail
{
    /**
     * @var PaymentEntity
     */
    private $paymentEntity;

    public function __construct(PaymentEntity $paymentEntity, array $recipientData = [])
    {
        parent::__construct($recipientData);
        $this->paymentEntity = $paymentEntity;
    }

    protected function getTextTemplateBody()
    {
        return strip_tags($this->getHtmlTemplateBody());
    }

    /**
     * @return string
     */
    protected function getSubjectTemplate()
    {
        return "A payment requires your authentication.";
    }

    protected abstract function getBaseUrl();

    protected function getContent()
    {
        $link = $this->getBaseUrl().'/payments/'.$this->paymentEntity->id;
        return <<<HTML
         <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Your bank needs you to authorise a payment</title>
	<style type="text/css" rel="stylesheet" media="all">
		/* Base ------------------------------ */
		@import url("https://fonts.googleapis.com/css?family=Open+Sans:400,700&display=swap");

		body {
			width: 100% !important;
			height: 100%;
			margin: 0;
			-webkit-text-size-adjust: none;
		}

		a {
			color: #0fb4ac;
		}

		a img {
			border: none;
		}

		td {
			word-break: break-word;
		}

		.preheader {
			display: none !important;
			visibility: hidden;
			mso-hide: all;
			font-size: 1px;
			line-height: 1px;
			max-height: 0;
			max-width: 0;
			opacity: 0;
			overflow: hidden;
		}

		/* Type ------------------------------ */

		body,
		td,
		th {
			font-family: "Open Sans", Helvetica, Arial, sans-serif;
		}

		h1 {
			margin-top: 0;
			color: #333333;
			font-size: 22px;
			font-weight: bold;
			text-align: left;
		}

		h2 {
			margin-top: 0;
			color: #333333;
			font-size: 16px;
			font-weight: bold;
			text-align: left;
		}

		h3 {
			margin-top: 0;
			color: #333333;
			font-size: 14px;
			font-weight: bold;
			text-align: left;
		}

		td,
		th {
			font-size: 16px;
		}

		p,
		ul,
		ol,
		blockquote {
			margin: .4em 0 1.1875em;
			font-size: 16px;
			line-height: 1.625;
		}

		p.sub {
			font-size: 13px;
		}

		/* Utilities ------------------------------ */

		.align-right {
			text-align: right;
		}

		.align-left {
			text-align: left;
		}

		.align-center {
			text-align: center;
		}

		/* Buttons ------------------------------ */

		.button {
			background-color: #0fb4ac;
			border-top: 10px solid #0fb4ac;
			border-right: 18px solid #0fb4ac;
			border-bottom: 10px solid #0fb4ac;
			border-left: 18px solid #0fb4ac;
			display: inline-block;
			color: #FFF;
			text-decoration: none;
			border-radius: 3px;
			box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16);
			-webkit-text-size-adjust: none;
			box-sizing: border-box;
		}

		@media only screen and (max-width: 500px) {
			.button {
				width: 100% !important;
				text-align: center !important;
			}
		}

		/* Attribute list ------------------------------ */

		.attributes {
			margin: 0 0 21px;
		}

		.attributes_content {
			background-color: #F4F4F7;
			padding: 16px;
		}

		.attributes_item {
			padding: 0;
		}

		/* Related Items ------------------------------ */

		.related {
			width: 100%;
			margin: 0;
			padding: 25px 0 0 0;
			-premailer-width: 100%;
			-premailer-cellpadding: 0;
			-premailer-cellspacing: 0;
		}

		.related_item {
			padding: 10px 0;
			color: #CBCCCF;
			font-size: 15px;
			line-height: 18px;
		}

		.related_item-title {
			display: block;
			margin: .5em 0 0;
		}

		.related_item-thumb {
			display: block;
			padding-bottom: 10px;
		}

		.related_heading {
			border-top: 1px solid #CBCCCF;
			text-align: center;
			padding: 25px 0 10px;
		}

		/* Discount Code ------------------------------ */

		.discount {
			width: 100%;
			margin: 0;
			padding: 24px;
			-premailer-width: 100%;
			-premailer-cellpadding: 0;
			-premailer-cellspacing: 0;
			background-color: #F4F4F7;
			border: 2px dashed #CBCCCF;
		}

		.discount_heading {
			text-align: center;
		}

		.discount_body {
			text-align: center;
			font-size: 15px;
		}

		/* Social Icons ------------------------------ */

		.social {
			width: auto;
		}

		.social td {
			padding: 0;
			width: auto;
		}

		.social_icon {
			height: 20px;
			margin: 0 8px 10px 8px;
			padding: 0;
		}

		/* Data table ------------------------------ */

		.purchase {
			width: 100%;
			margin: 0;
			padding: 35px 0;
			-premailer-width: 100%;
			-premailer-cellpadding: 0;
			-premailer-cellspacing: 0;
		}

		.purchase_content {
			width: 100%;
			margin: 0;
			padding: 25px 0 0 0;
			-premailer-width: 100%;
			-premailer-cellpadding: 0;
			-premailer-cellspacing: 0;
		}

		.purchase_item {
			padding: 10px 0;
			color: #51545E;
			font-size: 15px;
			line-height: 18px;
		}

		.purchase_heading {
			padding-bottom: 8px;
			border-bottom: 1px solid #EAEAEC;
		}

		.purchase_heading p {
			margin: 0;
			color: #85878E;
			font-size: 12px;
		}

		.purchase_footer {
			padding-top: 15px;
			border-top: 1px solid #EAEAEC;
		}

		.purchase_total {
			margin: 0;
			text-align: right;
			font-weight: bold;
			color: #333333;
		}

		.purchase_total--label {
			padding: 0 15px 0 0;
		}

		body {
			background-color: #0fb4ac;
			color: #51545E;
		}

		p {
			color: #51545E;
		}

		p.sub {
			color: #6B6E76;
		}

		.email-wrapper {
			width: 100%;
			margin: 0;
			padding: 0;
			-premailer-width: 100%;
			-premailer-cellpadding: 0;
			-premailer-cellspacing: 0;
			background-color: #0fb4ac;
		}

		.email-content {
			width: 100%;
			margin: 0;
			padding: 0;
			-premailer-width: 100%;
			-premailer-cellpadding: 0;
			-premailer-cellspacing: 0;
		}

		/* Masthead ----------------------- */

		.email-masthead {
			padding: 25px 0;
			text-align: center;
		}

		.email-masthead_logo {
			width: 94px;
		}

		.email-masthead_name {
			font-size: 16px;
			font-weight: bold;
			color: #ffffff;
			text-decoration: none;
		}

		/* Body ------------------------------ */

		.email-body {
			width: 100%;
			margin: 0;
			padding: 0;
			-premailer-width: 100%;
			-premailer-cellpadding: 0;
			-premailer-cellspacing: 0;
			background-color: #FFFFFF;
		}

		.email-body_inner {
			width: 570px;
			margin: 0 auto;
			padding: 0;
			-premailer-width: 570px;
			-premailer-cellpadding: 0;
			-premailer-cellspacing: 0;
			background-color: #FFFFFF;
		}

		.email-footer {
			width: 570px;
			margin: 0 auto;
			padding: 0;
			-premailer-width: 570px;
			-premailer-cellpadding: 0;
			-premailer-cellspacing: 0;
			text-align: center;
		}

		.email-footer p {
			color: #ffffff;
		}

		.body-action {
			width: 100%;
			margin: 30px auto;
			padding: 0;
			-premailer-width: 100%;
			-premailer-cellpadding: 0;
			-premailer-cellspacing: 0;
			text-align: center;
		}

		.body-sub {
			margin-top: 25px;
			padding-top: 25px;
			border-top: 1px solid #EAEAEC;
		}

		.content-cell {
			padding: 35px;
		}

		/*Media Queries ------------------------------ */

		@media only screen and (max-width: 600px) {
			.email-body_inner,
			.email-footer {
				width: 100% !important;
			}
		}

		@media (prefers-color-scheme: dark) {
			body,
			.email-body,
			.email-body_inner,
			.email-content,
			.email-wrapper,
			.email-masthead,
			.email-footer {
				background-color: #333333 !important;
				color: #FFF !important;
			}

			p,
			ul,
			ol,
			blockquote,
			h1,
			h2,
			h3 {
				color: #FFF !important;
			}

			.attributes_content,
			.discount {
				background-color: #222 !important;
			}

			.email-masthead_name {
				text-shadow: none !important;
			}
		}
	</style>
	<!--[if mso]>
	<style type="text/css">
		.f-fallback {
			font-family: Arial, sans-serif;
		}
	</style>
	<![endif]-->
</head>
<body>
<span class="preheader">Your bank needs you to authorise a payment</span>
<table class="email-wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation">
	<tr>
		<td align="center">
			<table class="email-content" width="100%" cellpadding="0" cellspacing="0" role="presentation">
				<tr>
					<td class="email-masthead">
						<a href="https://example.com" class="f-fallback email-masthead_name">
							[Product Name]
						</a>
					</td>
				</tr>
				<!-- Email Body -->
				<tr>
					<td class="email-body" width="100%" cellpadding="0" cellspacing="0">
						<table class="email-body_inner" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
							<!-- Body content -->
							<tr>
								<td class="content-cell">
									<div class="f-fallback">
										<h1>Your bank needs you to authorise a payment</h1>
										<p>Before we can receive your payment, your bank needs you to give permission.</p>
										<table class="purchase" width="100%" cellpadding="0" cellspacing="0">
											<tr>
												<td>
													<h3>{{invoice_id}}</h3>
												</td>
												<td>
													<h3 class="align-right">{{date}}</h3>
												</td>
											</tr>
											<tr>
												<td colspan="2">
													<table class="purchase_content" width="100%" cellpadding="0" cellspacing="0">
														<tr>
															<th class="purchase_heading" align="left">
																<p class="f-fallback">Description</p>
															</th>
															<th class="purchase_heading" align="right">
																<p class="f-fallback">Amount</p>
															</th>
														</tr>

														<tr>
															<td width="80%" class="purchase_item"><span class="f-fallback">{$this->paymentEntity->description}</span></td>
															<td class="align-right" width="20%" class="purchase_item"><span class="f-fallback">{$this->paymentEntity->amount} {$this->paymentEntity->currency}</span>
															</td>
														</tr>

														<tr>
															<td width="80%" class="purchase_footer" valign="middle">
																<p class="f-fallback purchase_total purchase_total--label">Total</p>
															</td>
															<td width="20%" class="purchase_footer" valign="middle">
																<p class="f-fallback purchase_total">{{total}}</p>
															</td>
														</tr>
													</table>
												</td>
											</tr>
										</table>
										<!-- Action -->
										<table class="body-action" align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation">
											<tr>
												<td align="center">
													<!-- Border based button
								 https://litmus.com/blog/a-guide-to-bulletproof-buttons-in-email-design -->
													<table width="100%" border="0" cellspacing="0" cellpadding="0" role="presentation">
														<tr>
															<td align="center">
																<a href="$link" target="_blank" class="f-fallback button button--green" target="_blank">Continue
																																				 Payment</a>
															</td>
														</tr>
													</table>
												</td>
											</tr>
										</table>
										<p class="f-fallback sub">New EU regulations require customers to authenticate all new payments. This is a new, more secure way to
										   keep your cash safe when purchasing online<p>
										<p class="f-fallback sub"><a href="{{support_url}}">Read more about it here</a></p>
										<p class="f-fallback sub"><strong>We will NEVER ask for your card details or other financial information</strong></p>
										<!-- Sub copy -->
										<table class="body-sub" role="presentation">
											<tr>
												<td>
													<p class="f-fallback sub">If you’re having trouble with the button above, copy and paste the URL
																			  below into your web browser.</p>
													<p class="f-fallback sub">{{action_url}}</p>
												</td>
											</tr>
										</table>
									</div>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table class="email-footer" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
							<tr>
								<td class="content-cell" align="center">
									<p class="f-fallback sub align-center">&copy; 2019 [Product Name]. All rights reserved.</p>
									<p class="f-fallback sub align-center">
										[Company Name, LLC]
										<br>1234 Street Rd.
										<br>Suite 1234
									</p>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</body>
</html>
           
HTML;
    }
}
