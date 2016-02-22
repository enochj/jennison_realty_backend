<?php
const XML_URL = "listings.xml";

use App\Listing;
use App\Photo;

//This function checks the xml file above for NEW entries and inserts them into the listing and photo databases.
function insertListings(){
	$xml_file = XML_URL;

	$xml_string = file_get_contents($xml_file);
//Remove extra space.
	$xml_string_parsed = preg_replace('/\s+/', ' ',$xml_string);
	$xml = new SimpleXMLElement($xml_string_parsed);

	if(count($xml)) {
		foreach ($xml->children() as $entry) {
			$listing = new Listing;
			foreach ($entry as $key=>$value) {
			
				if (in_array($key, array("Address", "Photos"))) {
					if (count($value)) {
						$photoarray = [];
						foreach ($value as $subkey=>$subvalue) {
//These are the photos
							if (count($subvalue)) {
								$photo = new Photo;
								foreach($subvalue as $photokey=>$photovalue) {
									$photo->$photokey = $photovalue;	
								}
								$photoarray[] = $photo;
							}

						}
					}						
					else {
//These are the addresses.
						$result=$value->xpath('commons:*');
						if (count($result)) {
							if (isset($result[0]))
								$listing->street_address = $result[0];
							if (isset($result[1]))
								$listing->city = $result[1];
							if (isset($result[2]))
								$listing->state = $result[2];
							if (isset($result[3]))
								$listing->postal = $result[3];
							if (isset($result[4]))
								$listing->country = $result[4];
						}
					}
				}
//These are all other values.
				else {
					$listing->$key = $value;
				}
			}
//Check to make sure the entry is new in the database.
			$previous_listing = Listing::select('listings.listingkey')->where('listingkey','=',$listing->ListingKey)->get();
			if(count($previous_listing)== 0) {
				$listing->save();
				if (isset($photoarray)) {
					foreach ($photoarray as $photo) {
						$photo->listing()->associate($listing);
						$photo->save();
					}
					unset($photoarray);
				}
			}
			else unset($previous_listing);
		}		
	}
}	

