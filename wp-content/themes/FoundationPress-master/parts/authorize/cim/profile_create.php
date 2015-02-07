<html>
<body>
<?php

include_once ("vars.php");
include_once ("util.php");
$html = '';

$email = $_POST["billing_email"];
$amount = '1500.00';
$user_id = '77655';
$invoiceNumber = "INV".$user_id . date("mdY");
/*
$user_id = $_POST['user_id'];
$email = $_POST["billing_email"];
$ccn = $_POST['cc_number'];
$billing_fname = $_POST['billing_fname'];
$billing_lname = $_POST['billing_lname'];
$billing_phone = $_POST['billing_phone'];
$exp = $_POST['exp'];
*/
//build xml to post
$content =
	"<?xml version=\"1.0\" encoding=\"utf-8\"?>" .
	"<createCustomerProfileRequest xmlns=\"AnetApi/xml/v1/schema/AnetApiSchema.xsd\">" .
	MerchantAuthenticationBlock().
	"<profile>".
	"<merchantCustomerId>".$user_id."</merchantCustomerId>". // Your own identifier for the customer.
	"<description></description>".
	"<email>" . $email . "</email>".
	"</profile>".
	"</createCustomerProfileRequest>";

$response = send_xml_request($content);
$parsedresponse = parse_api_response($response);
if ("Ok" == $parsedresponse->messages->resultCode) {
	//$html .= "customerProfileId <b>"
	//	. htmlspecialchars($parsedresponse->customerProfileId)
	//	. "</b> was successfully created.<br><br>";
		$profile_id = htmlspecialchars($parsedresponse->customerProfileId);
		$customerShippingAddressId = NULL;
		if (isset($_REQUEST['customerShippingAddressId'])) {
			$customerShippingAddressId = $_REQUEST['customerShippingAddressId'];
		}

		//$html .= "Create payment profile for customerProfileId <b>"
		//	. htmlspecialchars($profile_id)
		//	. "</b>...<br><br>";

		//build xml to post
		$content =
			"<?xml version=\"1.0\" encoding=\"utf-8\"?>" .
			"<createCustomerPaymentProfileRequest xmlns=\"AnetApi/xml/v1/schema/AnetApiSchema.xsd\">" .
			MerchantAuthenticationBlock().
			"<customerProfileId>" . $profile_id . "</customerProfileId>".
			"<paymentProfile>".
			"<billTo>".
			 "<firstName>John</firstName>".
			 "<lastName>Doe</lastName>".
			 "<phoneNumber>000-000-0000</phoneNumber>".
			"</billTo>".
			"<payment>".
			 "<creditCard>".
			  "<cardNumber>4111111111111111</cardNumber>".
			  "<expirationDate>2020-11</expirationDate>". // required format for API is YYYY-MM
			 "</creditCard>".
			"</payment>".
			"</paymentProfile>".
			"<validationMode>testMode</validationMode>". // or testMode
			"</createCustomerPaymentProfileRequest>";

		//$html .= "Raw request: " . htmlspecialchars($content) . "<br><br>";
		$response = send_xml_request($content);
		//$html .= "Raw response: " . htmlspecialchars($response) . "<br><br>";
		$parsedresponse = parse_api_response($response);
		if ("Ok" == $parsedresponse->messages->resultCode) {
			//$html .= "customerPaymentProfileId <b>"
			//	. htmlspecialchars($parsedresponse->customerPaymentProfileId)
			//	. "</b> was successfully created for customerProfileId <b>"
			//	. htmlspecialchars($profile_id)
			//	. "</b>.<br><br>";
				$customerPaymentProfileId = htmlspecialchars($parsedresponse->customerPaymentProfileId);
			//	$html .= "Create shipping address for customerProfileId <b>"
			//		. htmlspecialchars($profile_id)
			//		. "</b>...<br><br>";

				//build xml to post
				$content =
					"<?xml version=\"1.0\" encoding=\"utf-8\"?>" .
					"<createCustomerShippingAddressRequest xmlns=\"AnetApi/xml/v1/schema/AnetApiSchema.xsd\">" .
					MerchantAuthenticationBlock().
					"<customerProfileId>" . $profile_id . "</customerProfileId>".
					"<address>".
					"<firstName>John</firstName>".
					"<lastName>Smith</lastName>".
					"<phoneNumber>000-000-0000</phoneNumber>".
					"</address>".
					"</createCustomerShippingAddressRequest>";

			//	$html .= "Raw request: " . htmlspecialchars($content) . "<br><br>";
				$response = send_xml_request($content);
			//	$html .= "Raw response: " . htmlspecialchars($response) . "<br><br>";
				$parsedresponse = parse_api_response($response);
				if ("Ok" == $parsedresponse->messages->resultCode) {
					//$html .= "customerAddressId <b>"
					//	. htmlspecialchars($parsedresponse->customerAddressId)
					//	. "</b> was successfully created for customerProfileId <b>"
					//	. htmlspecialchars($profile_id)
					//	. "</b>.<br><br>";
						$customerShippingAddressId = htmlspecialchars($parsedresponse->customerAddressId);
					//	$html .= "Create transaction for customerProfileId <b>"
					//		. htmlspecialchars($profile_id)
					//		. "</b>, customerPaymentProfileId <b>"
					//		. htmlspecialchars($customerPaymentProfileId)
					//		. "</b>, customerShippingAddressId <b>"
					//		. htmlspecialchars($customerShippingAddressId)
					//		. "</b>...<br><br>";
						
						//build xml to post
						$content =
							"<?xml version=\"1.0\" encoding=\"utf-8\"?>" .
							"<createCustomerProfileTransactionRequest xmlns=\"AnetApi/xml/v1/schema/AnetApiSchema.xsd\">" .
							MerchantAuthenticationBlock().
							"<transaction>".
							"<profileTransAuthOnly>".
							"<amount>" . ($amount - 1.00) . "</amount>". // should include tax, shipping, and everything.

							"<lineItems>".
							"<itemId>1</itemId>".
							"<name>Renew My Healthcare</name>".
							"<description>Primary care physician</description>".
							"<quantity>1</quantity>".
							"<unitPrice>" . ($amount - 1.00) . "</unitPrice>".
							"<taxable>false</taxable>".
							"</lineItems>".
							"<customerProfileId>" . $profile_id . "</customerProfileId>".
							"<customerPaymentProfileId>" . $customerPaymentProfileId . "</customerPaymentProfileId>".
							"<customerShippingAddressId>" . $customerShippingAddressId . "</customerShippingAddressId>".
							"<order>".
							"<invoiceNumber>".$invoiceNumber."</invoiceNumber>".
							"</order>".
							"</profileTransAuthOnly>".
							"</transaction>".
							"</createCustomerProfileTransactionRequest>";

						//$html .= "Raw request: " . htmlspecialchars($content) . "<br><br>";
						$response = send_xml_request($content);
						//$html .= "Raw response: " . htmlspecialchars($response) . "<br><br>";
						$parsedresponse = parse_api_response($response);
						if ("Ok" == $parsedresponse->messages->resultCode) {
							//$html .= "A transaction was successfully created for customerProfileId <b>"
							//	. htmlspecialchars($profile_id)
							//	. "</b>.<br><br>";
						}
						if (isset($parsedresponse->directResponse)) {
							//$html .= "direct response: <br>"
							//	. htmlspecialchars($parsedresponse->directResponse)
							//	. "<br><br>";
								
							$directResponseFields = explode(",", $parsedresponse->directResponse);
							$responseCode = $directResponseFields[0]; // 1 = Approved 2 = Declined 3 = Error
							$responseReasonCode = $directResponseFields[2]; // See http://www.authorize.net/support/AIM_guide.pdf
							$responseReasonText = $directResponseFields[3];
							$approvalCode = $directResponseFields[4]; // Authorization code
							$transId = $directResponseFields[6];
							
							if ("1" == $responseCode)	{
								$html .= "The transaction was successful.<br>";
							} 
							else if ("2" == $responseCode) {
								$html .= "The transaction was declined.<br>";
							}
							else	{
								echo "The transaction resulted in an error.<br>";
							}
							
							$html .= "responseReasonCode = " . htmlspecialchars($responseReasonCode) . "<br>";
							$html .= "responseReasonText = " . htmlspecialchars($responseReasonText) . "<br>";
							$html .= "approvalCode = " . htmlspecialchars($approvalCode) . "<br>";
							$html .= "transId = " . htmlspecialchars($transId) . "<br>";
						}
				}
		}
}

$html .= "You will be redirect shortly...";
//$html .= get_site_url() ."/index.php?page_id=32";
echo $html;
//echo "setTimeout(function () { window.location.href = '". get_site_url() ."/index.php?page_id=32'; }, 2000);";
?>
</body>
</html>
