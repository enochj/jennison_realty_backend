<?php
use App\Listing;
use App\Photo;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

//This is the basic get function localhost/laravelapp/realty/public/
Route::get('/', function () {
	$listings = Listing::get()->toArray();
	$merged_listings;
	foreach ($listings as $listing) {
		$id = $listing["id"];
		$photos = Photo::select('photos.mediamodificationtimestamp', 'photos.mediaurl')->where('listing_id','=',$id)->get()->toArray();
		$photo_array[] = $photos;
		$listing["Photos"] = $photos;
		$merged_listings[] = $listing;
	}	
	return json_encode($merged_listings);
});

//The formate of this get is localhost/laravelapp/realty/public/page?filter=ListPrice&sort=asc
//Options for filter are ListPrice, ListingDate, and Photos.
//Options for sort are asc and des.
Route::get('/page/', function () {
	if (isset($_GET["page"]))
		$pager = ($_GET["page"]);
	else $pager = 15;
	if (isset($_GET["filter"]))
		$filter = ($_GET["filter"]);
	else $filter = "ListingDate";
	if (isset($_GET["sort"]))
		$sort = ($_GET["sort"]);
	else $sort = "asc";
	switch ($filter):
		case "ListPrice":
			switch ($sort) {
//Here we have the case of ListPrice and ascending.
				case "asc":
					$array = Listing::all()->sortBy('listprice');
					foreach ($array as $listing) {
						$id = ($listing["id"]);
						$photos = Photo::select('photos.mediamodificationtimestamp', 'photos.mediaurl')->where('listing_id','=',$id)->get()->toArray();
						$photo_array[] = $photos;
						$listing["Photos"] = $photos;
						$merged_listings[] = $listing;
					}
					break;
//Here we have the case of ListPrice and descending.
				case "des":
					$array = Listing::all()->sortByDesc('listprice');
					foreach ($array as $listing) {
						$id = ($listing["id"]);
						$photos = Photo::select('photos.mediamodificationtimestamp', 'photos.mediaurl')->where('listing_id','=',$id)->get()->toArray();
						$photo_array[] = $photos;
						$listing["Photos"] = $photos;
						$merged_listings[] = $listing;
					}					
					break;
			}
			break;
//Here we have the case of ListingDate and ascending.
		case "ListingDate":
			switch ($sort) {
				case "asc":
					$array = Listing::all()->sortBy('created_at');
					foreach ($array as $listing) {
						$id = ($listing["id"]);
						$photos = Photo::select('photos.mediamodificationtimestamp', 'photos.mediaurl')->where('listing_id','=',$id)->get()->toArray();
						$photo_array[] = $photos;
						$listing["Photos"] = $photos;
						$merged_listings[] = $listing;
					}
					break;
//Here we have the case of ListingDate and descending.
				case "des":
					$array = Listing::all()->sortByDesc('created_at');
					foreach ($array as $listing) {
						$id = ($listing["id"]);
						$photos = Photo::select('photos.mediamodificationtimestamp', 'photos.mediaurl')->where('listing_id','=',$id)->get()->toArray();
						$photo_array[] = $photos;
						$listing["Photos"] = $photos;
						$merged_listings[] = $listing;
					}
					break;
			}
			break;
		case "Photos":
			$array = Photo::leftJoin('listings', 'photos.listing_id', '=', 'listings.listingkey')->select('photos.*')->get();	
	endswitch;
	return new Paginator($array, $pager);
});

Route::get('/status', function () {
//Toggle the listingstatus.
	if (isset($_GET["id"])) {
		$id = ($_GET["id"]);
		$listing = Listing::find($id);
		if ($listing->listingstatus == "Active")
			$listing->listingstatus = "Inactive";
		elseif ($listing->listingstatus == "Inactive")
			$listing->listingstatus = "Active";
		$listing->save();
	}

//Return all results joined with photos.
	$listings = Listing::get()->toArray();
	$merged_listings;
	foreach ($listings as $listing) {
		$id = $listing["id"];
		$photos = Photo::select('photos.mediamodificationtimestamp', 'photos.mediaurl')->where('listing_id','=',$id)->get()->toArray();
		$photo_array[] = $photos;
		$listing["Photos"] = $photos;
		$merged_listings[] = $listing;
	}	
	return json_encode($merged_listings);
});


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
});

Route::get('listings', function() {
	return 'Listings!';
});
