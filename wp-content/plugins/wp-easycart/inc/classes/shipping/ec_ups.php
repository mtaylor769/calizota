<?php
	
class ec_ups{
	private $ups_access_license_number; 						// Your UPS license number
	private $ups_user_id; 										// Your UPS user id
	private $ups_password; 										// Your UPS password
	private $ups_ship_from_state; 								// Your UPS ship from state code
	private $ups_ship_from_zip; 								// Your UPS ship from zip code
	private $ups_shipper_number; 								// Your UPS shipper number
	private $ups_country_code;									// Your UPS country code
	private $ups_weight_type;									// Your UPS weight type
	private $ups_conversion_rate;								// A Conversion Rate
	private $ups_negotiated_rates;								// Optional negotiated rates
	
	private $shipper_url;										// String
	
	function __construct( $ec_setting ){
		$this->ups_access_license_number = $ec_setting->get_ups_access_license_number( );
		$this->ups_user_id = $ec_setting->get_ups_user_id( );
		$this->ups_password = $ec_setting->get_ups_password( );
		$this->ups_ship_from_state = $ec_setting->get_ups_ship_from_state( );
		$this->ups_ship_from_zip = $ec_setting->get_ups_ship_from_zip( );
		$this->ups_shipper_number = $ec_setting->get_ups_shipper_number( );
		$this->ups_country_code = $ec_setting->get_ups_country_code( );
		$this->ups_weight_type = $ec_setting->get_ups_weight_type( );
		$this->ups_conversion_rate = $ec_setting->get_ups_conversion_rate( );
		$this->ups_negotiated_rates = $ec_setting->get_ups_negotiated_rates( );
		
		$this->shipper_url = "https://www.ups.com/ups.app/xml/Rate";
	}
	
	public function get_rate( $ship_code, $destination_zip, $destination_country, $weight, $length = 1, $width = 1, $height = 1, $declared_value = 0, $cart = array( ) ){
		if( $weight == 0 )
		return "0.00";
		
		if( !$destination_country )
			$destination_country = $this->ups_country_code;
		
		if( !$destination_zip )
			$destination_zip = $this->ups_ship_from_zip;
		
		$shipper_data = $this->get_shipper_data( $ship_code, $destination_zip, $destination_country, $weight, $length, $width, $height, $declared_value, $cart );
		$request = new WP_Http;
		$response = $request->request( $this->shipper_url, array( 'method' => 'POST', 'body' => $shipper_data, 'sslverify' => false ) );
		if( is_wp_error( $response ) ){
			$error_message = $response->get_error_message();
			error_log( "error in ups get rate, " . $error_message );
			return false;
		}else
			return $this->process_response( $response['body'] );
		
	}
	
	public function get_all_rates( $destination_zip, $destination_country, $weight, $length = 1, $width = 1, $height = 1, $declared_value = 0, $cart = array( ) ){
		if( $weight == 0 )
		return "0.00";
		
		if( !$destination_country )
			$destination_country = $this->ups_country_code;
		
		if( !$destination_zip )
			$destination_zip = $this->ups_ship_from_zip;
		
		$shipper_data = $this->get_all_rates_shipper_data( $destination_zip, $destination_country, $weight, $length, $width, $height, $declared_value, $cart );
		$request = new WP_Http;
		$response = $request->request( $this->shipper_url, array( 'method' => 'POST', 'body' => $shipper_data, 'sslverify' => false ) );
		if( is_wp_error( $response ) ){
			$error_message = $response->get_error_message();
			error_log( "error in ups get rate, " . $error_message );
			return false;
		}else
			return $this->process_all_rates_response( $response['body'] );
		
	}
	
	public function get_rate_test( $ship_code, $destination_zip, $destination_country, $weight, $length = 10, $width = 10, $height = 10, $declared_value = 0, $cart = array( ) ){
		if( $weight == 0 )
		return "0.00";
		
		if( !$destination_country )
			$destination_country = $this->ups_country_code;
		
		$shipper_data = $this->get_all_rates_shipper_data( $destination_zip, $destination_country, $weight, $length, $width, $height, $declared_value, $cart );
		$request = new WP_Http;
		$response = $request->request( $this->shipper_url, array( 'method' => 'POST', 'body' => $shipper_data, 'sslverify' => false ) );
		$db = new ec_db( );
		$db->insert_response( 0, 0, "UPS TEST", print_r( $response, true ) );
		if( is_wp_error( $response ) ){
			$error_message = $response->get_error_message();
			error_log( "error in ups get rate, " . $error_message );
			return false;
		}else
			return $response['body'];
		
	}
	
	private function get_shipper_data( $ship_code, $destination_zip, $destination_country, $weight, $length = 1, $width = 1, $height = 1, $declared_value = 0, $cart = array( ) ){
		$shipper_data = "<?xml version=\"1.0\"?>
			<AccessRequest xml:lang=\"en-US\">
				<AccessLicenseNumber>$this->ups_access_license_number</AccessLicenseNumber>
				<UserId>$this->ups_user_id</UserId>
				<Password>" . htmlspecialchars( $this->ups_password ) . "</Password>
			</AccessRequest>
			<?xml version=\"1.0\"?>
			<RatingServiceSelectionRequest xml:lang=\"en-US\">
				<Request>
					<TransactionReference>
						<CustomerContext>Rate Request</CustomerContext>
						<XpciVersion>1.0001</XpciVersion>
					</TransactionReference>
					<RequestAction>Rate</RequestAction>
					<RequestOption>Rate</RequestOption>
				</Request>
			<PickupType>
				<Code>01</Code>
			</PickupType>
			<Shipment>
				<Shipper>
					<Address>
						<PostalCode>$this->ups_ship_from_zip</PostalCode>
						<CountryCode>$this->ups_country_code</CountryCode>
					</Address>
				<ShipperNumber>$this->ups_shipper_number</ShipperNumber>
				</Shipper>
				<ShipTo>
					<Address>
						<PostalCode>$destination_zip</PostalCode>
						<CountryCode>$destination_country</CountryCode>
					<ResidentialAddressIndicator/>
					</Address>
				</ShipTo>
				<ShipFrom>
					<Address>
						<PostalCode>$this->ups_ship_from_zip</PostalCode>
						<CountryCode>$this->ups_country_code</CountryCode>
					</Address>
				</ShipFrom>
				<Service>
					<Code>$ship_code</Code>
				</Service>";
				
				if( get_option( 'ec_option_ship_items_seperately' ) && count( $cart ) > 0 ){
					
					foreach( $cart as $cartitem ){
						
						for( $i=0; $i<$cartitem->quantity; $i++ ){
						
						$shipper_data .= "
				<Package>
					<PackagingType>
						<Code>02</Code>
					</PackagingType>
					<Dimensions>
						<Length>" . ceil( $cartitem->length ) . "</Length>
						<Width>" . ceil( $cartitem->width ) . "</Width>
						<Height>" . ceil( $cartitem->height ) . "</Height>
					</Dimensions>
					<PackageWeight>
						<UnitOfMeasurement>
							<Code>$this->ups_weight_type</Code>
						</UnitOfMeasurement>
						<Weight>" . $cartitem->weight . "</Weight>
					</PackageWeight>
				</Package>";
				
						}
						
					}
					
				}else if( $weight > 150 ){
				
					$package_total = 0;
					$last_package_i = 0;
					foreach( $cart as $cartitem ){
						
						for( $i=0; $i<$cartitem->quantity; $i++ ){
							
							if( $package_total + $cartitem->weight > 150 ){
								
								$length = $cartitem->length;
								$width = $cartitem->width;
								$height = $cartitem->height * ($i+1-$last_package_i);
								
								$shipper_data .= "
						<Package>
							<PackagingType>
								<Code>02</Code>
							</PackagingType>
							<Dimensions>
								<Length>" . ceil( $length ) . "</Length>
								<Width>" . ceil( $width ) . "</Width>
								<Height>" . ceil( $height ) . "</Height>
							</Dimensions>
							<PackageWeight>
								<UnitOfMeasurement>
									<Code>$this->ups_weight_type</Code>
								</UnitOfMeasurement>
								<Weight>" . $package_total . "</Weight>
							</PackageWeight>
						</Package>";
						
								$package_total = $cartitem->weight;
								$last_package_i = $i;
							
							}else{
								$package_total = $package_total + $cartitem->weight;
							}
				
						}
						
					}
					
					$length = $cartitem->length;
					$width = $cartitem->width;
					$height = $cartitem->height * ($i+1-$last_package_i);
					
					$shipper_data .= "
						<Package>
							<PackagingType>
								<Code>02</Code>
							</PackagingType>
							<Dimensions>
								<Length>" . ceil( $length ) . "</Length>
								<Width>" . ceil( $width ) . "</Width>
								<Height>" . ceil( $height ) . "</Height>
							</Dimensions>
							<PackageWeight>
								<UnitOfMeasurement>
									<Code>$this->ups_weight_type</Code>
								</UnitOfMeasurement>
								<Weight>" . $package_total . "</Weight>
							</PackageWeight>
						</Package>";
					
				
				}else{
				
				$shipper_data .= "
				<Package>
					<PackagingType>
						<Code>02</Code>
					</PackagingType>
					<PackageWeight>
						<UnitOfMeasurement>
							<Code>$this->ups_weight_type</Code>
						</UnitOfMeasurement>
						<Weight>$weight</Weight>
					</PackageWeight>
				</Package>";
				
				}
			$shipper_data .= "
			</Shipment>
			</RatingServiceSelectionRequest>";
		return $shipper_data;
	}
	
	private function get_all_rates_shipper_data( $destination_zip, $destination_country, $weight = 1, $length = 1, $width = 1, $height = 1, $declared_value = 0, $cart = array( ) ){
		$shipper_data = "<?xml version=\"1.0\"?>
			<AccessRequest xml:lang=\"en-US\">
				<AccessLicenseNumber>$this->ups_access_license_number</AccessLicenseNumber>
				<UserId>$this->ups_user_id</UserId>
				<Password>" . htmlspecialchars( $this->ups_password ) . "</Password>
			</AccessRequest>
			<?xml version=\"1.0\"?>
			<RatingServiceSelectionRequest xml:lang=\"en-US\">
				<Request>
					<TransactionReference>
						<CustomerContext>Rate Request</CustomerContext>
						<XpciVersion>1.0001</XpciVersion>
					</TransactionReference>
					<RequestAction>Rate</RequestAction>
					<RequestOption>Shop</RequestOption>
				</Request>
				<PickupType>
					<Code>01</Code>
				</PickupType>
				<Shipment>
					<Shipper>
						<Address>
							<PostalCode>$this->ups_ship_from_zip</PostalCode>
							<CountryCode>$this->ups_country_code</CountryCode>
						</Address>
					<ShipperNumber>$this->ups_shipper_number</ShipperNumber>
					</Shipper>
					<ShipTo>
						<Address>
							<PostalCode>$destination_zip</PostalCode>
							<CountryCode>$destination_country</CountryCode>
						<ResidentialAddressIndicator/>
						</Address>
					</ShipTo>
					<ShipFrom>
						<Address>";
								if( $this->ups_negotiated_rates ){
								$shipper_data .= "
								<StateProvinceCode>$this->ups_ship_from_state</StateProvinceCode>";
								}
								$shipper_data .= "
								<PostalCode>$this->ups_ship_from_zip</PostalCode>
							<CountryCode>$this->ups_country_code</CountryCode>
						</Address>
					</ShipFrom>";
					
					if( get_option( 'ec_option_ship_items_seperately' ) && count( $cart ) > 0 ){
					
					foreach( $cart as $cart_item ){
						for( $i=0; $i<$cart_item->quantity; $i++ ){
					$shipper_data .= "
					<Package>
						<PackagingType>
							<Code>02</Code>
						</PackagingType>						
						<Dimensions>
							<Length>" . ceil( $cartitem->length ) . "</Length>
							<Width>" . ceil( $cartitem->width ) . "</Width>
							<Height>" . ceil( $cartitem->height ) . "</Height>
						</Dimensions>
						<PackageWeight>
							<UnitOfMeasurement>
								<Code>$this->ups_weight_type</Code>
							</UnitOfMeasurement>
							<Weight>" . $cart_item->weight . "</Weight>
						</PackageWeight>
						<Dimensions>
							<UnitOfMeasurement>
								<Code>";
	
								if( $this->ups_weight_type == 'LBS' ){
									$shipper_data .= "IN";
								}else{
									$shipper_data .= "CM";
								}
	
								$shipper_data .= "</Code>
							</UnitOfMeasurement>
							<Length>" . ceil( $cart_item->length ) . "</Length>
							<Width>" . ceil( $cart_item->width ) . "</Width>
							<Height>" . ceil( $cart_item->height ) . "</Height>
						</Dimensions>
						<PackageServiceOptions>
							<CurrencyCode>" . get_option( 'ec_option_base_currency' ) . "</CurrencyCode>
							<MonetaryValue>" . $cart_item->unit_price . "</MonetaryValue>
						</PackageServiceOptions>
					</Package>";
						}
					}
					
					}else if( $weight > 150 ){
				
						$package_total = 0;
						$last_package_i = 0;
						foreach( $cart as $cartitem ){
							
							for( $i=0; $i<$cartitem->quantity; $i++ ){
								
								if( $package_total + $cartitem->weight > 150 ){
							
									$length = $cartitem->length;
									$width = $cartitem->width;
									$height = $cartitem->height * ($i+1-$last_package_i);
									
									$shipper_data .= "
							<Package>
								<PackagingType>
									<Code>02</Code>
								</PackagingType>
								<Dimensions>
									<Length>" . ceil( $length ) . "</Length>
									<Width>" . ceil( $width ) . "</Width>
									<Height>" . ceil( $height ) . "</Height>
								</Dimensions>
								<PackageWeight>
									<UnitOfMeasurement>
										<Code>$this->ups_weight_type</Code>
									</UnitOfMeasurement>
									<Weight>" . $package_total . "</Weight>
								</PackageWeight>
							</Package>";
							
									$package_total = $cartitem->weight;
									$last_package_i = $i;
								
								}else{
									$package_total = $package_total + $cartitem->weight;
								}
					
							}
							
						}
					
						$length = $cartitem->length;
						$width = $cartitem->width;
						$height = $cartitem->height * ($i+1-$last_package_i);
						
						$shipper_data .= "
							<Package>
								<PackagingType>
									<Code>02</Code>
								</PackagingType>
								<Dimensions>
									<Length>" . ceil( $length ) . "</Length>
									<Width>" . ceil( $width ) . "</Width>
									<Height>" . ceil( $height ) . "</Height>
								</Dimensions>
								<PackageWeight>
									<UnitOfMeasurement>
										<Code>$this->ups_weight_type</Code>
									</UnitOfMeasurement>
									<Weight>" . $package_total . "</Weight>
								</PackageWeight>
							</Package>";
						
					
					}else{
						
					$shipper_data .= "
					<Package>
						<PackagingType>
							<Code>02</Code>
						</PackagingType>
						<PackageWeight>
							<UnitOfMeasurement>
								<Code>$this->ups_weight_type</Code>
							</UnitOfMeasurement>
							<Weight>$weight</Weight>
						</PackageWeight>
						<Dimensions>
							<UnitOfMeasurement>
								<Code>";
	
								if( $this->ups_weight_type == 'LBS' ){
									$shipper_data .= "IN";
								}else{
									$shipper_data .= "CM";
								}
	
								$shipper_data .= "</Code>
							</UnitOfMeasurement>
							<Length>" . ceil( $length ) . "</Length>
							<Width>" . ceil( $width ) . "</Width>
							<Height>" . ceil( $height ) . "</Height>
						</Dimensions>
						<PackageServiceOptions>
							<CurrencyCode>" . get_option( 'ec_option_base_currency' ) . "</CurrencyCode>
							<MonetaryValue>$declared_value</MonetaryValue>
						</PackageServiceOptions>
					</Package>";
					
					}
					
					if( $this->ups_negotiated_rates ){
					$shipper_data .= "
					<RateInformation>
						<NegotiatedRatesIndicator/>
					</RateInformation>";
					}
				$shipper_data .= "
				</Shipment>
			</RatingServiceSelectionRequest>";
		return $shipper_data;
	} 
	
	private function process_response( $result ){
		$xml = new SimpleXMLElement($result);
		if( $xml && $xml->RatedShipment && $xml->RatedShipment->TotalCharges && $xml->RatedShipment->TotalCharges->MonetaryValue )
			$rate = $xml->RatedShipment->TotalCharges->MonetaryValue;
		else
			$rate = "ERROR";
			
		if( isset( $rate ) ){
			$rate = floatval( $rate );
			return ( $rate * $this->ups_conversion_rate );
		}else{
			error_log( "error in ups get rate, response: " . $result );
			return "ERROR";	
		}
	} 
	
	private function process_all_rates_response( $result ){
		$rates = array( );
		$xml = new SimpleXMLElement($result);
		
		for( $i=0; $i<count( $xml->RatedShipment ); $i++ ){
			$rates[] = array( 'rate_code' => (string) $xml->RatedShipment[$i]->Service->Code[0][0], 'rate' => number_format( floatval( $xml->RatedShipment[$i]->TotalCharges->MonetaryValue ) * $this->ups_conversion_rate, 2, ".", "" ), 'delivery_days' =>  (string) $xml->RatedShipment[$i]->GuaranteedDaysToDelivery );
		}
		
		return $rates;
		
	}
	
	public function validate_address( $destination_city, $destination_state, $destination_zip, $destination_country ){
		
		// For now, limit errors
		return true;
		
		// This service is limited to the US by EasyCart to prevent common issues.
		if( $this->ups_country_code != "US" || $destination_country != "US" )
			return true;
		
		$shipper_data = "<?xml version=\"1.0\"?>
			<AccessRequest xml:lang=\"en-US\">
				<AccessLicenseNumber>$this->ups_access_license_number</AccessLicenseNumber>
				<UserId>$this->ups_user_id</UserId>
				<Password>" . htmlspecialchars( $this->ups_password ) . "</Password>
			</AccessRequest>
			<?xml version=\"1.0\"?>
			<AddressValidationRequest xml:lang=\"en-US\">
				<Request>
					<TransactionReference>
						<CustomerContext>Validate Address</CustomerContext>
						<XpciVersion>1.0001</XpciVersion>
					</TransactionReference>
					<RequestAction>AV</RequestAction>
				</Request>
				<Address>
					<City>$destination_city</City>";
		
		if( $destination_state ){		
			$shipper_data .= "
					<StateProvinceCode>$destination_state</StateProvinceCode>";
		}
		
		$shipper_data .= "
					<PostalCode>$destination_zip</PostalCode>
					<CountryCode>$destination_country</CountryCode>
				</Address>
			</AddressValidationRequest>";
		
		$request = new WP_Http;
		$response = $request->request( "https://onlinetools.ups.com/ups.app/xml/AV", array( 'method' => 'POST', 'body' => $shipper_data, 'sslverify' => false ) );
		if( is_wp_error( $response ) ){
			$error_message = $response->get_error_message();
			error_log( "error in ups address validation, " . $error_message );
			return false;
		}else{
			
			$xml = new SimpleXMLElement( $response['body'] );
			
			if( $xml->Response->ResponseStatusCode == '0' )
				return false;
			else
				return true;
			
		}
			
	}
	
}
	
?>