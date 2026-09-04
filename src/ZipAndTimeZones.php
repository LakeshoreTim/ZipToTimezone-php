<?php
// Copyright (c) 2026 Tim Lambert — MIT License. See LICENSE file for details.

namespace LakeshoreTim\ZipToTimezonePhp;

/**
 * A class for converting zip codes to timezones. It is used statically.
 */
 
class ZipAndTimeZones
{
	/**
     * Convert a zip code to a timezone name (e.g. America/Chicago)
     *
     * @param int or string $zipCode - zip code as number or text (zip code plus 4 is disregarded ... 5 digits only)
     * @return string - the standardized timezone name
     * @return "unknown" on invalid zip code
     */
	public static function calcTimezoneName ($zipCode)
	{
		$tzCode = self::findTzCode ($zipCode);
		return self::getTimezoneName ($tzCode);
	}
	

	/**
     * Get the integer amount of offset for Standard Time from UTC for any U.S. Zip Code 
	  * 	e.g. entering "32399" will return -5 (for America/New_York)
     *
     * @param int or string $zipCode - zip code as number or text (zip code plus 4 is disregarded ... 5 digits only)
     * @return 0 on invalid zip code
     */
	public static function getStandardTimeOffset ($zipCode)
	{
		$tzCode = self::findTzCode ($zipCode);
		return self::getStandardFromTzCode ($tzCode);
	}
	
	
	/**
     * Get the integer amount of offset for Daylight Savings Time from UTC for any U.S. Zip Code 
	  * 	e.g. entering "32399" will return -4 (for America/New_York)
     *
     * @param int or string $zipCode - zip code as number or text (zip code plus 4 is disregarded ... 5 digits only)
     * @return integer - the whole number offset from UTC
     * @return 0 on invalid zip code
     */
	public static function getDSTOffset ($zipCode)
	{
		$tzCode = self::findTzCode ($zipCode);
		
		switch ($tzCode) {
			// all but the last 2 are a single hour offset from Standard Time
			//case self::ANCHORAGE:
			//case self::BOISE:
			//case self::CHICAGO:
			//case self::DENVER:
			//case self::DETROIT:
			//case self::INDIANAPOLIS:
			//case self::KNOX:
			//case self::MARENGO:
			//case self::PETERSBURG:
			//case self::TELL_CITY:
			//case self::VEVAY:
			//case self::VINCENNES:
			//case self::WINAMAC:
			//case self::JUNEAU:
			//case self::MONTICELLO:
			//case self::LOS_ANGELES:
			//case self::MENOMINEE:
			//case self::NEW_YORK:
			//case self::NOME:
			//case self::NORTH_DAKOTA:
			//case self::SHIPROCK:
			//case self::YAKUTAT:
			
			case self::PHOENIX:
			case self::HONOLULU:
				return self::getStandardFromTzCode ($tzCode);
		}
		
		return self::getStandardFromTzCode ($tzCode) + 1;
	}
	
	// ------------------------------------------------------------------------------------------------
	
   const UNKNOWN	   	= 0;
   const FIRST_CODE   	= 1;
	
   const ANCHORAGE   	= 1;
   const BOISE   			= 2;
   const CHICAGO   		= 3;
	const DENVER   		= 4;
   const DETROIT   		= 5;
   const INDIANAPOLIS   = 6;
   const KNOX   			= 7;
   const MARENGO   		= 8;
   const PETERSBURG   	= 9;
   const TELL_CITY   	= 10;
   const VEVAY   			= 11;
   const VINCENNES   	= 12;
   const WINAMAC  	 	= 13;
   const JUNEAU   		= 14;
   const LOUISVILLE   	= 15;
   const MONTICELLO   	= 16;
   const LOS_ANGELES 	= 17;
   const MENOMINEE   	= 18;
   const NEW_YORK		   = 19;
   const NOME   			= 20;
   const NORTH_DAKOTA   = 21;
   const PHOENIX   		= 22;
   const SHIPROCK   		= 23;
   const YAKUTAT   		= 24;
   const HONOLULU   		= 25;

   const LAST_CODE   	= 25;

	// --------------------------------------------------------------------------------------------
	
	protected static function getTimezoneName ($tzCode)
	{
		switch ($tzCode) {
			case self::ANCHORAGE   		: return "America/Anchorage";
			case self::BOISE   			: return "America/Boise";
			case self::CHICAGO   		: return "America/Chicago";
			case self::DENVER   			: return "America/Denver";
			case self::DETROIT   		: return "America/Detroit";
			case self::INDIANAPOLIS   	: return "America/Indiana/Indianapolis";
			case self::KNOX   			: return "America/Indiana/Knox";
			case self::MARENGO   		: return "America/Indiana/Marengo";
			case self::PETERSBURG   	: return "America/Indiana/Petersburg";
			case self::TELL_CITY   		: return "America/Indiana/Tell_City";
			case self::VEVAY   			: return "America/Indiana/Vevay";
			case self::VINCENNES   		: return "America/Indiana/Vincennes";
			case self::WINAMAC  	 		: return "America/Indiana/Winamac";
			case self::JUNEAU   			: return "America/Juneau";
			case self::LOUISVILLE   	: return "America/Kentucky/Louisville";
			case self::MONTICELLO   	: return "America/Kentucky/Monticello";
			case self::LOS_ANGELES 		: return "America/Los_Angeles";
			case self::MENOMINEE   		: return "America/Menominee";
			case self::NEW_YORK		   : return "America/New_York";
			case self::NOME   			: return "America/Nome";
			case self::NORTH_DAKOTA   	: return "America/North_Dakota/Center";
			case self::PHOENIX   		: return "America/Phoenix";
			case self::SHIPROCK   		: return "America/Shiprock";
			case self::YAKUTAT   		: return "America/Yakutat";
			case self::HONOLULU   		: return "Pacific/Honolulu";
		}
		return "unknown";
	}
	
	public static function findTzCode ($zipCode)
	{
		if (is_string($zipCode)) {
			if (strlen($zipCode) > 5) {
				$zipCode = substr ($zipCode, 0, 5);
			}
		}
		$zipCode = intval ($zipCode);
		
		$tzCode = self::getTimezoneFromSingles ($zipCode);
		if ($tzCode != self::UNKNOWN)
			return $tzCode;
			
		return self::getTimezoneFromRanges ($zipCode);
	}
	
	protected static function getStandardFromTzCode ($tzCode)
	{
		switch ($tzCode) {
			case self::ANCHORAGE   		: return -9;
			case self::BOISE   			: return -7;
			case self::CHICAGO   		: return -6;
			case self::DENVER   			: return -7;
			case self::DETROIT   		: return -5;
			case self::INDIANAPOLIS   	: return -5;
			case self::KNOX   			: return -6;
			case self::MARENGO   		: return -5;
			case self::PETERSBURG   	: return -5;
			case self::TELL_CITY   		: return -6;
			case self::VEVAY   			: return -5;
			case self::VINCENNES   		: return -5;
			case self::WINAMAC  	 		: return -5;
			case self::JUNEAU   			: return -9;
			case self::LOUISVILLE   	: return -5;
			case self::MONTICELLO   	: return -5;
			case self::LOS_ANGELES 		: return -8;
			case self::MENOMINEE   		: return -6;
			case self::NEW_YORK		   : return -5;
			case self::NOME   			: return -9;
			case self::NORTH_DAKOTA   	: return -6;
			case self::PHOENIX   		: return -7;
			case self::SHIPROCK   		: return -7;
			case self::YAKUTAT   		: return -9;
			case self::HONOLULU   		: return -10;
		}
		return 0;
	}
	
	
	protected static function getTimezoneFromRanges ($zipCode)
	{
		if ($zipCode >= 99501  &&  $zipCode <= 99553)
			return self::ANCHORAGE;
		if ($zipCode >= 99555  &&  $zipCode <= 99561)
			return self::ANCHORAGE;
		if ($zipCode >= 99564  &&  $zipCode <= 99580)
			return self::ANCHORAGE;
		if ($zipCode >= 99586  &&  $zipCode <= 99603)
			return self::ANCHORAGE;
		if ($zipCode >= 99605  &&  $zipCode <= 99619)
			return self::ANCHORAGE;
		if ($zipCode >= 99621  &&  $zipCode <= 99631)
			return self::ANCHORAGE;
		if ($zipCode >= 99633  &&  $zipCode <= 99649)
			return self::ANCHORAGE;
		if ($zipCode >= 99651  &&  $zipCode <= 99656)
			return self::ANCHORAGE;
		if ($zipCode >= 99667  &&  $zipCode <= 99670)
			return self::ANCHORAGE;
		if ($zipCode >= 99672  &&  $zipCode <= 99683)
			return self::ANCHORAGE;
		if ($zipCode >= 99685  &&  $zipCode <= 99688)
			return self::ANCHORAGE;
		if ($zipCode >= 99690  &&  $zipCode <= 99734)
			return self::ANCHORAGE;
		if ($zipCode >= 99743  &&  $zipCode <= 99748)
			return self::ANCHORAGE;
		if ($zipCode >= 99754  &&  $zipCode <= 99760)
			return self::ANCHORAGE;
		if ($zipCode >= 99764  &&  $zipCode <= 99768)
			return self::ANCHORAGE;
		if ($zipCode >= 99774  &&  $zipCode <= 99777)
			return self::ANCHORAGE;
		if ($zipCode >= 99779  &&  $zipCode <= 99782)
			return self::ANCHORAGE;
		if ($zipCode >= 99788  &&  $zipCode <= 99791)
			return self::ANCHORAGE;
		
		if ($zipCode >= 83201  &&  $zipCode <= 83210)
			return self::BOISE;
		if ($zipCode >= 83214  &&  $zipCode <= 83272)
			return self::BOISE;
		if ($zipCode >= 83276  &&  $zipCode <= 83283)
			return self::BOISE;
		if ($zipCode >= 83286  &&  $zipCode <= 83330)
			return self::BOISE;
		if ($zipCode >= 83335  &&  $zipCode <= 83346)
			return self::BOISE;
		if ($zipCode >= 83352  &&  $zipCode <= 83406)
			return self::BOISE;
		if ($zipCode >= 83415  &&  $zipCode <= 83435)
			return self::BOISE;
		if ($zipCode >= 83438  &&  $zipCode <= 83442)
			return self::BOISE;
		if ($zipCode >= 83444  &&  $zipCode <= 83469)
			return self::BOISE;
		if ($zipCode >= 83601  &&  $zipCode <= 83657)
			return self::BOISE;
		if ($zipCode >= 83661  &&  $zipCode <= 83670)
			return self::BOISE;
		if ($zipCode >= 83672  &&  $zipCode <= 83799)
			return self::BOISE;
		
		if ($zipCode >= 32401  &&  $zipCode <= 32455)
			return self::CHICAGO;
		if ($zipCode >= 32459  &&  $zipCode <= 32598)
			return self::CHICAGO;
		if ($zipCode >= 35004  &&  $zipCode <= 37301)
			return self::CHICAGO;
		if ($zipCode >= 37345  &&  $zipCode <= 37349)
			return self::CHICAGO;
		if ($zipCode >= 37355  &&  $zipCode <= 37360)
			return self::CHICAGO;
		if ($zipCode >= 37394  &&  $zipCode <= 37398)
			return self::CHICAGO;
		if ($zipCode >= 38001  &&  $zipCode <= 39776)
			return self::CHICAGO;
		if ($zipCode >= 42726  &&  $zipCode <= 42731)
			return self::CHICAGO;
		if ($zipCode >= 50001  &&  $zipCode <= 56763)
			return self::CHICAGO;
		if ($zipCode >= 57001  &&  $zipCode <= 57520)
			return self::CHICAGO;
		if ($zipCode >= 57522  &&  $zipCode <= 57536)
			return self::CHICAGO;
		if ($zipCode >= 57538  &&  $zipCode <= 57542)
			return self::CHICAGO;
		if ($zipCode >= 58001  &&  $zipCode <= 58507)
			return self::CHICAGO;
		if ($zipCode >= 58558  &&  $zipCode <= 58561)
			return self::CHICAGO;
		if ($zipCode >= 58572  &&  $zipCode <= 58579)
			return self::CHICAGO;
		if ($zipCode >= 58701  &&  $zipCode <= 58856)
			return self::CHICAGO;
		if ($zipCode >= 60001  &&  $zipCode <= 67732)
			return self::CHICAGO;
		if ($zipCode >= 67736  &&  $zipCode <= 67740)
			return self::CHICAGO;
		if ($zipCode >= 67743  &&  $zipCode <= 67757)
			return self::CHICAGO;
		if ($zipCode >= 67764  &&  $zipCode <= 67835)
			return self::CHICAGO;
		if ($zipCode >= 67837  &&  $zipCode <= 67855)
			return self::CHICAGO;
		if ($zipCode >= 67859  &&  $zipCode <= 67877)
			return self::CHICAGO;
		if ($zipCode >= 67880  &&  $zipCode <= 69020)
			return self::CHICAGO;
		if ($zipCode >= 69046  &&  $zipCode <= 69120)
			return self::CHICAGO;
		if ($zipCode >= 69163  &&  $zipCode <= 69167)
			return self::CHICAGO;
		if ($zipCode >= 70001  &&  $zipCode <= 79789)
			return self::CHICAGO;
		if ($zipCode >= 79830  &&  $zipCode <= 79834)
			return self::CHICAGO;
		if ($zipCode >= 79842  &&  $zipCode <= 79848)
			return self::CHICAGO;
		
		if ($zipCode >= 57551  &&  $zipCode <= 57555)
			return self::DENVER;
		if ($zipCode >= 57620  &&  $zipCode <= 57630)
			return self::DENVER;
		if ($zipCode >= 57633  &&  $zipCode <= 57645)
			return self::DENVER;
		if ($zipCode >= 57649  &&  $zipCode <= 57799)
			return self::DENVER;
		if ($zipCode >= 58566  &&  $zipCode <= 58571)
			return self::DENVER;
		if ($zipCode >= 58601  &&  $zipCode <= 58656)
			return self::DENVER;
		if ($zipCode >= 59001  &&  $zipCode <= 59937)
			return self::DENVER;
		if ($zipCode >= 69125  &&  $zipCode <= 69129)
			return self::DENVER;
		if ($zipCode >= 69144  &&  $zipCode <= 69150)
			return self::DENVER;
		if ($zipCode >= 69152  &&  $zipCode <= 69156)
			return self::DENVER;
		if ($zipCode >= 69301  &&  $zipCode <= 69367)
			return self::DENVER;
		if ($zipCode >= 79835  &&  $zipCode <= 79839)
			return self::DENVER;
		if ($zipCode >= 79901  &&  $zipCode <= 83128)
			return self::DENVER;
		if ($zipCode >= 84001  &&  $zipCode <= 84791)
			return self::DENVER;
		if ($zipCode >= 87001  &&  $zipCode <= 88595)
			return self::DENVER;
		
		if ($zipCode >= 48001  &&  $zipCode <= 48040)
			return self::DETROIT;
		if ($zipCode >= 48042  &&  $zipCode <= 48159)
			return self::DETROIT;
		if ($zipCode >= 48161  &&  $zipCode <= 48169)
			return self::DETROIT;
		if ($zipCode >= 48173  &&  $zipCode <= 48177)
			return self::DETROIT;
		if ($zipCode >= 48179  &&  $zipCode <= 48190)
			return self::DETROIT;
		if ($zipCode >= 48192  &&  $zipCode <= 48415)
			return self::DETROIT;
		if ($zipCode >= 48417  &&  $zipCode <= 48428)
			return self::DETROIT;
		if ($zipCode >= 48432  &&  $zipCode <= 48437)
			return self::DETROIT;
		if ($zipCode >= 48439  &&  $zipCode <= 48450)
			return self::DETROIT;
		if ($zipCode >= 48453  &&  $zipCode <= 48456)
			return self::DETROIT;
		if ($zipCode >= 48461  &&  $zipCode <= 48473)
			return self::DETROIT;
		if ($zipCode >= 48476  &&  $zipCode <= 48609)
			return self::DETROIT;
		if ($zipCode >= 48611  &&  $zipCode <= 48614)
			return self::DETROIT;
		if ($zipCode >= 48625  &&  $zipCode <= 48631)
			return self::DETROIT;
		if ($zipCode >= 48633  &&  $zipCode <= 48636)
			return self::DETROIT;
		if ($zipCode >= 48638  &&  $zipCode <= 48649)
			return self::DETROIT;
		if ($zipCode >= 48654  &&  $zipCode <= 48725)
			return self::DETROIT;
		if ($zipCode >= 48727  &&  $zipCode <= 48743)
			return self::DETROIT;
		if ($zipCode >= 48745  &&  $zipCode <= 48749)
			return self::DETROIT;
		if ($zipCode >= 48762  &&  $zipCode <= 48806)
			return self::DETROIT;
		if ($zipCode >= 48811  &&  $zipCode <= 48826)
			return self::DETROIT;
		if ($zipCode >= 48835  &&  $zipCode <= 48840)
			return self::DETROIT;
		if ($zipCode >= 48851  &&  $zipCode <= 48865)
			return self::DETROIT;
		if ($zipCode >= 48873  &&  $zipCode <= 48876)
			return self::DETROIT;
		if ($zipCode >= 48884  &&  $zipCode <= 48889)
			return self::DETROIT;
		if ($zipCode >= 48893  &&  $zipCode <= 49020)
			return self::DETROIT;
		if ($zipCode >= 49022  &&  $zipCode <= 49033)
			return self::DETROIT;
		if ($zipCode >= 49035  &&  $zipCode <= 49046)
			return self::DETROIT;
		if ($zipCode >= 49048  &&  $zipCode <= 49058)
			return self::DETROIT;
		if ($zipCode >= 49061  &&  $zipCode <= 49066)
			return self::DETROIT;
		if ($zipCode >= 49068  &&  $zipCode <= 49075)
			return self::DETROIT;
		if ($zipCode >= 49077  &&  $zipCode <= 49089)
			return self::DETROIT;
		if ($zipCode >= 49095  &&  $zipCode <= 49098)
			return self::DETROIT;
		if ($zipCode >= 49101  &&  $zipCode <= 49221)
			return self::DETROIT;
		if ($zipCode >= 49232  &&  $zipCode <= 49235)
			return self::DETROIT;
		if ($zipCode >= 49241  &&  $zipCode <= 49246)
			return self::DETROIT;
		if ($zipCode >= 49248  &&  $zipCode <= 49254)
			return self::DETROIT;
		if ($zipCode >= 49256  &&  $zipCode <= 49266)
			return self::DETROIT;
		if ($zipCode >= 49268  &&  $zipCode <= 49283)
			return self::DETROIT;
		if ($zipCode >= 49285  &&  $zipCode <= 49306)
			return self::DETROIT;
		if ($zipCode >= 49316  &&  $zipCode <= 49323)
			return self::DETROIT;
		if ($zipCode >= 49326  &&  $zipCode <= 49337)
			return self::DETROIT;
		if ($zipCode >= 49344  &&  $zipCode <= 49420)
			return self::DETROIT;
		if ($zipCode >= 49422  &&  $zipCode <= 49448)
			return self::DETROIT;
		if ($zipCode >= 49452  &&  $zipCode <= 49612)
			return self::DETROIT;
		if ($zipCode >= 49614  &&  $zipCode <= 49619)
			return self::DETROIT;
		if ($zipCode >= 49621  &&  $zipCode <= 49630)
			return self::DETROIT;
		if ($zipCode >= 49634  &&  $zipCode <= 49637)
			return self::DETROIT;
		if ($zipCode >= 49644  &&  $zipCode <= 49648)
			return self::DETROIT;
		if ($zipCode >= 49650  &&  $zipCode <= 49654)
			return self::DETROIT;
		if ($zipCode >= 49666  &&  $zipCode <= 49675)
			return self::DETROIT;
		if ($zipCode >= 49677  &&  $zipCode <= 49682)
			return self::DETROIT;
		if ($zipCode >= 49684  &&  $zipCode <= 49688)
			return self::DETROIT;
		if ($zipCode >= 49709  &&  $zipCode <= 49715)
			return self::DETROIT;
		if ($zipCode >= 49717  &&  $zipCode <= 49726)
			return self::DETROIT;
		if ($zipCode >= 49734  &&  $zipCode <= 49749)
			return self::DETROIT;
		if ($zipCode >= 49757  &&  $zipCode <= 49764)
			return self::DETROIT;
		if ($zipCode >= 49766  &&  $zipCode <= 49775)
			return self::DETROIT;
		if ($zipCode >= 49777  &&  $zipCode <= 49799)
			return self::DETROIT;
		if ($zipCode >= 49816  &&  $zipCode <= 49820)
			return self::DETROIT;
		if ($zipCode >= 49822  &&  $zipCode <= 49829)
			return self::DETROIT;
		if ($zipCode >= 49835  &&  $zipCode <= 49841)
			return self::DETROIT;
		if ($zipCode >= 49864  &&  $zipCode <= 49868)
			return self::DETROIT;
		if ($zipCode >= 49916  &&  $zipCode <= 49919)
			return self::DETROIT;
		if ($zipCode >= 49929  &&  $zipCode <= 49934)
			return self::DETROIT;
		if ($zipCode >= 49950  &&  $zipCode <= 49955)
			return self::DETROIT;
		if ($zipCode >= 49960  &&  $zipCode <= 49963)
			return self::DETROIT;
		
		if ($zipCode >= 46001  &&  $zipCode <= 46035)
			return self::INDIANAPOLIS;
		if ($zipCode >= 46041  &&  $zipCode <= 46052)
			return self::INDIANAPOLIS;
		if ($zipCode >= 46056  &&  $zipCode <= 46063)
			return self::INDIANAPOLIS;
		if ($zipCode >= 46070  &&  $zipCode <= 46111)
			return self::INDIANAPOLIS;
		if ($zipCode >= 46115  &&  $zipCode <= 46120)
			return self::INDIANAPOLIS;
		if ($zipCode >= 46125  &&  $zipCode <= 46129)
			return self::INDIANAPOLIS;
		if ($zipCode >= 46135  &&  $zipCode <= 46147)
			return self::INDIANAPOLIS;
		if ($zipCode >= 46149  &&  $zipCode <= 46157)
			return self::INDIANAPOLIS;
		if ($zipCode >= 46165  &&  $zipCode <= 46176)
			return self::INDIANAPOLIS;
		if ($zipCode >= 46201  &&  $zipCode <= 46340)
			return self::INDIANAPOLIS;
		if ($zipCode >= 46342  &&  $zipCode <= 46365)
			return self::INDIANAPOLIS;
		if ($zipCode >= 46368  &&  $zipCode <= 46373)
			return self::INDIANAPOLIS;
		if ($zipCode >= 46375  &&  $zipCode <= 46504)
			return self::INDIANAPOLIS;
		if ($zipCode >= 46513  &&  $zipCode <= 46530)
			return self::INDIANAPOLIS;
		if ($zipCode >= 46536  &&  $zipCode <= 46546)
			return self::INDIANAPOLIS;
		if ($zipCode >= 46553  &&  $zipCode <= 46561)
			return self::INDIANAPOLIS;
		if ($zipCode >= 46563  &&  $zipCode <= 46573)
			return self::INDIANAPOLIS;
		if ($zipCode >= 46580  &&  $zipCode <= 46704)
			return self::INDIANAPOLIS;
		if ($zipCode >= 46706  &&  $zipCode <= 46721)
			return self::INDIANAPOLIS;
		if ($zipCode >= 46733  &&  $zipCode <= 46746)
			return self::INDIANAPOLIS;
		if ($zipCode >= 46748  &&  $zipCode <= 46760)
			return self::INDIANAPOLIS;
		if ($zipCode >= 46763  &&  $zipCode <= 46766)
			return self::INDIANAPOLIS;
		if ($zipCode >= 46771  &&  $zipCode <= 46774)
			return self::INDIANAPOLIS;
		if ($zipCode >= 46777  &&  $zipCode <= 46782)
			return self::INDIANAPOLIS;
		if ($zipCode >= 46784  &&  $zipCode <= 46787)
			return self::INDIANAPOLIS;
		if ($zipCode >= 46793  &&  $zipCode <= 46904)
			return self::INDIANAPOLIS;
		if ($zipCode >= 46911  &&  $zipCode <= 46917)
			return self::INDIANAPOLIS;
		if ($zipCode >= 46920  &&  $zipCode <= 46928)
			return self::INDIANAPOLIS;
		if ($zipCode >= 46930  &&  $zipCode <= 46939)
			return self::INDIANAPOLIS;
		if ($zipCode >= 46941  &&  $zipCode <= 46947)
			return self::INDIANAPOLIS;
		if ($zipCode >= 46951  &&  $zipCode <= 46959)
			return self::INDIANAPOLIS;
		if ($zipCode >= 46961  &&  $zipCode <= 46967)
			return self::INDIANAPOLIS;
		if ($zipCode >= 46971  &&  $zipCode <= 46980)
			return self::INDIANAPOLIS;
		if ($zipCode >= 46986  &&  $zipCode <= 46990)
			return self::INDIANAPOLIS;
		if ($zipCode >= 47021  &&  $zipCode <= 47037)
			return self::INDIANAPOLIS;
		if ($zipCode >= 47107  &&  $zipCode <= 47115)
			return self::INDIANAPOLIS;
		if ($zipCode >= 47126  &&  $zipCode <= 47136)
			return self::INDIANAPOLIS;
		if ($zipCode >= 47141  &&  $zipCode <= 47144)
			return self::INDIANAPOLIS;
		if ($zipCode >= 47150  &&  $zipCode <= 47167)
			return self::INDIANAPOLIS;
		if ($zipCode >= 47190  &&  $zipCode <= 47223)
			return self::INDIANAPOLIS;
		if ($zipCode >= 47225  &&  $zipCode <= 47229)
			return self::INDIANAPOLIS;
		if ($zipCode >= 47245  &&  $zipCode <= 47249)
			return self::INDIANAPOLIS;
		if ($zipCode >= 47282  &&  $zipCode <= 47324)
			return self::INDIANAPOLIS;
		if ($zipCode >= 47326  &&  $zipCode <= 47335)
			return self::INDIANAPOLIS;
		if ($zipCode >= 47337  &&  $zipCode <= 47351)
			return self::INDIANAPOLIS;
		if ($zipCode >= 47355  &&  $zipCode <= 47358)
			return self::INDIANAPOLIS;
		if ($zipCode >= 47360  &&  $zipCode <= 47367)
			return self::INDIANAPOLIS;
		if ($zipCode >= 47374  &&  $zipCode <= 47383)
			return self::INDIANAPOLIS;
		if ($zipCode >= 47385  &&  $zipCode <= 47431)
			return self::INDIANAPOLIS;
		if ($zipCode >= 47439  &&  $zipCode <= 47446)
			return self::INDIANAPOLIS;
		if ($zipCode >= 47449  &&  $zipCode <= 47455)
			return self::INDIANAPOLIS;
		if ($zipCode >= 47458  &&  $zipCode <= 47467)
			return self::INDIANAPOLIS;
		if ($zipCode >= 47469  &&  $zipCode <= 47490)
			return self::INDIANAPOLIS;
		if ($zipCode >= 47610  &&  $zipCode <= 47638)
			return self::INDIANAPOLIS;
		if ($zipCode >= 47647  &&  $zipCode <= 47654)
			return self::INDIANAPOLIS;
		if ($zipCode >= 47665  &&  $zipCode <= 47832)
			return self::INDIANAPOLIS;
		if ($zipCode >= 47845  &&  $zipCode <= 47857)
			return self::INDIANAPOLIS;
		if ($zipCode >= 47859  &&  $zipCode <= 47866)
			return self::INDIANAPOLIS;
		if ($zipCode >= 47869  &&  $zipCode <= 47872)
			return self::INDIANAPOLIS;
		if ($zipCode >= 47875  &&  $zipCode <= 47916)
			return self::INDIANAPOLIS;
		if ($zipCode >= 47920  &&  $zipCode <= 47925)
			return self::INDIANAPOLIS;
		if ($zipCode >= 47933  &&  $zipCode <= 47942)
			return self::INDIANAPOLIS;
		if ($zipCode >= 47962  &&  $zipCode <= 47969)
			return self::INDIANAPOLIS;
		if ($zipCode >= 47971  &&  $zipCode <= 47997)
			return self::INDIANAPOLIS;
		
		
			//return self::KNOX;
			//return self::MARENGO;
			//return self::PETERSBURG;
			//return self::TELL_CITY;
			//return self::VEVAY;

		if ($zipCode >= 47541  &&  $zipCode <= 47549)
			return self::VINCENNES;
		if ($zipCode >= 47557  &&  $zipCode <= 47562)
			return self::VINCENNES;
		
			//return self::WINAMAC;
			
		if ($zipCode >= 99801  &&  $zipCode <= 99812)
			return self::JUNEAU;
		if ($zipCode >= 99821  &&  $zipCode <= 99928)
			return self::JUNEAU;
			
		if ($zipCode >= 40003  &&  $zipCode <= 40008)
			return self::LOUISVILLE;
		if ($zipCode >= 40014  &&  $zipCode <= 40045)
			return self::LOUISVILLE;
		if ($zipCode >= 40047  &&  $zipCode <= 40050)
			return self::LOUISVILLE;
		if ($zipCode >= 40060  &&  $zipCode <= 40070)
			return self::LOUISVILLE;
		if ($zipCode >= 40077  &&  $zipCode <= 40118)
			return self::LOUISVILLE;
		if ($zipCode >= 40121  &&  $zipCode <= 40146)
			return self::LOUISVILLE;
		if ($zipCode >= 40152  &&  $zipCode <= 40171)
			return self::LOUISVILLE;
		if ($zipCode >= 40178  &&  $zipCode <= 40310)
			return self::LOUISVILLE;
		if ($zipCode >= 40312  &&  $zipCode <= 40324)
			return self::LOUISVILLE;
		if ($zipCode >= 40346  &&  $zipCode <= 40350)
			return self::LOUISVILLE;
		if ($zipCode >= 40355  &&  $zipCode <= 40366)
			return self::LOUISVILLE;
		if ($zipCode >= 40371  &&  $zipCode <= 40376)
			return self::LOUISVILLE;
		if ($zipCode >= 40380  &&  $zipCode <= 40410)
			return self::LOUISVILLE;
		if ($zipCode >= 40421  &&  $zipCode <= 40434)
			return self::LOUISVILLE;
		if ($zipCode >= 40448  &&  $zipCode <= 40460)
			return self::LOUISVILLE;
		if ($zipCode >= 40464  &&  $zipCode <= 40481)
			return self::LOUISVILLE;
		if ($zipCode >= 40492  &&  $zipCode <= 40724)
			return self::LOUISVILLE;
		if ($zipCode >= 40730  &&  $zipCode <= 40820)
			return self::LOUISVILLE;
		if ($zipCode >= 40824  &&  $zipCode <= 40831)
			return self::LOUISVILLE;
		if ($zipCode >= 40843  &&  $zipCode <= 40935)
			return self::LOUISVILLE;
		if ($zipCode >= 40941  &&  $zipCode <= 40958)
			return self::LOUISVILLE;
		if ($zipCode >= 40964  &&  $zipCode <= 40982)
			return self::LOUISVILLE;
		if ($zipCode >= 40988  &&  $zipCode <= 41002)
			return self::LOUISVILLE;
		if ($zipCode >= 41011  &&  $zipCode <= 41022)
			return self::LOUISVILLE;
		if ($zipCode >= 41037  &&  $zipCode <= 41045)
			return self::LOUISVILLE;
		if ($zipCode >= 41052  &&  $zipCode <= 41085)
			return self::LOUISVILLE;
		if ($zipCode >= 41095  &&  $zipCode <= 41128)
			return self::LOUISVILLE;
		if ($zipCode >= 41142  &&  $zipCode <= 41166)
			return self::LOUISVILLE;
		if ($zipCode >= 41169  &&  $zipCode <= 41216)
			return self::LOUISVILLE;
		if ($zipCode >= 41222  &&  $zipCode <= 41250)
			return self::LOUISVILLE;
		if ($zipCode >= 41255  &&  $zipCode <= 41274)
			return self::LOUISVILLE;
		if ($zipCode >= 41342  &&  $zipCode <= 41364)
			return self::LOUISVILLE;
		if ($zipCode >= 41366  &&  $zipCode <= 41385)
			return self::LOUISVILLE;
		if ($zipCode >= 41390  &&  $zipCode <= 41422)
			return self::LOUISVILLE;
		if ($zipCode >= 41426  &&  $zipCode <= 41464)
			return self::LOUISVILLE;
		if ($zipCode >= 41477  &&  $zipCode <= 41535)
			return self::LOUISVILLE;
		if ($zipCode >= 41538  &&  $zipCode <= 41721)
			return self::LOUISVILLE;
		if ($zipCode >= 41723  &&  $zipCode <= 41730)
			return self::LOUISVILLE;
		if ($zipCode >= 41735  &&  $zipCode <= 41743)
			return self::LOUISVILLE;
		if ($zipCode >= 41746  &&  $zipCode <= 41772)
			return self::LOUISVILLE;
		if ($zipCode >= 41774  &&  $zipCode <= 41861)
			return self::LOUISVILLE;
		if ($zipCode >= 42001  &&  $zipCode <= 42033)
			return self::LOUISVILLE;
		if ($zipCode >= 42044  &&  $zipCode <= 42051)
			return self::LOUISVILLE;
		if ($zipCode >= 42054  &&  $zipCode <= 42070)
			return self::LOUISVILLE;
		if ($zipCode >= 42076  &&  $zipCode <= 42081)
			return self::LOUISVILLE;
		if ($zipCode >= 42083  &&  $zipCode <= 42128)
			return self::LOUISVILLE;
		if ($zipCode >= 42134  &&  $zipCode <= 42159)
			return self::LOUISVILLE;
		if ($zipCode >= 42201  &&  $zipCode <= 42211)
			return self::LOUISVILLE;
		if ($zipCode >= 42216  &&  $zipCode <= 42221)
			return self::LOUISVILLE;
		if ($zipCode >= 42240  &&  $zipCode <= 42254)
			return self::LOUISVILLE;
		if ($zipCode >= 42257  &&  $zipCode <= 42262)
			return self::LOUISVILLE;
		if ($zipCode >= 42266  &&  $zipCode <= 42274)
			return self::LOUISVILLE;
		if ($zipCode >= 42276  &&  $zipCode <= 42285)
			return self::LOUISVILLE;
		if ($zipCode >= 42287  &&  $zipCode <= 42326)
			return self::LOUISVILLE;
		if ($zipCode >= 42332  &&  $zipCode <= 42347)
			return self::LOUISVILLE;
		if ($zipCode >= 42352  &&  $zipCode <= 42367)
			return self::LOUISVILLE;
		if ($zipCode >= 42402  &&  $zipCode <= 42406)
			return self::LOUISVILLE;
		if ($zipCode >= 42409  &&  $zipCode <= 42436)
			return self::LOUISVILLE;
		if ($zipCode >= 42440  &&  $zipCode <= 42444)
			return self::LOUISVILLE;
		if ($zipCode >= 42450  &&  $zipCode <= 42455)
			return self::LOUISVILLE;
		if ($zipCode >= 42460  &&  $zipCode <= 42516)
			return self::LOUISVILLE;
		if ($zipCode >= 42533  &&  $zipCode <= 42602)
			return self::LOUISVILLE;
		if ($zipCode >= 42647  &&  $zipCode <= 42711)
			return self::LOUISVILLE;
		if ($zipCode >= 42735  &&  $zipCode <= 42748)
			return self::LOUISVILLE;
		
			//return self::MONTICELLO;
			
		if ($zipCode >= 83501  &&  $zipCode <= 83546)
			return self::LOS_ANGELES;
		if ($zipCode >= 83548  &&  $zipCode <= 83555)
			return self::LOS_ANGELES;
		if ($zipCode >= 83801  &&  $zipCode <= 83888)
			return self::LOS_ANGELES;
		if ($zipCode >= 88901  &&  $zipCode <= 96162)
			return self::LOS_ANGELES;
		if ($zipCode >= 97001  &&  $zipCode <= 99403)
			return self::LOS_ANGELES;
		
		if ($zipCode >= 49873  &&  $zipCode <= 49877)
			return self::MENOMINEE;
		
		if ($zipCode >= 501    &&  $zipCode <= 32399)
			return self::NEW_YORK;
		if ($zipCode >= 32601  &&  $zipCode <= 34997)
			return self::NEW_YORK;
		if ($zipCode >= 37307  &&  $zipCode <= 37312)
			return self::NEW_YORK;
		if ($zipCode >= 37314  &&  $zipCode <= 37317)
			return self::NEW_YORK;
		if ($zipCode >= 37320  &&  $zipCode <= 37323)
			return self::NEW_YORK;
		if ($zipCode >= 37361  &&  $zipCode <= 37364)
			return self::NEW_YORK;
		if ($zipCode >= 37369  &&  $zipCode <= 37373)
			return self::NEW_YORK;
		if ($zipCode >= 37401  &&  $zipCode <= 37450)
			return self::NEW_YORK;
		if ($zipCode >= 37601  &&  $zipCode <= 37722)
			return self::NEW_YORK;
		if ($zipCode >= 37724  &&  $zipCode <= 37998)
			return self::NEW_YORK;
		if ($zipCode >= 39813  &&  $zipCode <= 39901)
			return self::NEW_YORK;
		if ($zipCode >= 43001  &&  $zipCode <= 45389)
			return self::NEW_YORK;
		if ($zipCode >= 45400  &&  $zipCode <= 45999)
			return self::NEW_YORK;
		if ($zipCode >= 56901  &&  $zipCode <= 56972)
			return self::NEW_YORK;
		
		if ($zipCode >= 99749  &&  $zipCode <= 99753)
			return self::NOME;
		if ($zipCode >= 99769  &&  $zipCode <= 99773)
			return self::NOME;
		if ($zipCode >= 99783  &&  $zipCode <= 99786)
			return self::NOME;
		
			//return self::NORTH_DAKOTA;
			
		if ($zipCode >= 85001  &&  $zipCode <= 85355)
			return self::PHOENIX;
		if ($zipCode >= 85357  &&  $zipCode <= 85536)
			return self::PHOENIX;
		if ($zipCode >= 85540  &&  $zipCode <= 85601)
			return self::PHOENIX;
		if ($zipCode >= 85603  &&  $zipCode <= 85636)
			return self::PHOENIX;
		if ($zipCode >= 85638  &&  $zipCode <= 85644)
			return self::PHOENIX;
		if ($zipCode >= 85646  &&  $zipCode <= 85777)
			return self::PHOENIX;
		if ($zipCode >= 86001  &&  $zipCode <= 86018)
			return self::PHOENIX;
		if ($zipCode >= 86301  &&  $zipCode <= 86433)
			return self::PHOENIX;
		if ($zipCode >= 86436  &&  $zipCode <= 86446)
			return self::PHOENIX;
		
		if ($zipCode >= 85901  &&  $zipCode <= 85920)
			return self::SHIPROCK;
		if ($zipCode >= 85923  &&  $zipCode <= 85930)
			return self::SHIPROCK;
		if ($zipCode >= 85932  &&  $zipCode <= 85942)
			return self::SHIPROCK;
		if ($zipCode >= 86025  &&  $zipCode <= 86034)
			return self::SHIPROCK;
		if ($zipCode >= 86502  &&  $zipCode <= 86547)
			return self::SHIPROCK;
		
			//return self::YAKUTAT;
			
		if ($zipCode >= 96701  &&  $zipCode <= 96863)
			return self::HONOLULU;

		return self::UNKNOWN;
	}
	
	protected static function getTimezoneFromSingles ($zipCode)
	{
		switch ($zipCode) {
			case 99583:
			case 99660:
			case 99661:
			case 99663:
			case 99664:
			case 99665:
			case 99737:
			case 99738:
			case 99740:
			case 99741:
			case 99820:
			case 99929:
				return self::ANCHORAGE;
				
			case 83212:
			case 83333:
			case 83348:
			case 83349:
				return self::BOISE;
				
			case 37305:
			case 37306:
			case 37313:
			case 37318:
			case 37324:
			case 37327:
			case 37328:
			case 37330:
			case 37334:
			case 37335:
			case 37338:
			case 37339:
			case 37340:
			case 37342:
			case 37352:
			case 37365:
			case 37366:
			case 37367:
			case 37374:
			case 37375:
			case 37376:
			case 37378:
			case 37380:
			case 37382:
			case 37383:
			case 37387:
			case 37388:
			case 37389:
			case 37501:
			case 37544:
			case 37723:
			case 40119:
			case 42035:
			case 42039:
			case 42041:
			case 42053:
			case 42071:
			case 42082:
			case 42129:
			case 42133:
			case 42160:
			case 42166:
			case 42170:
			case 42171:
			case 42214:
			case 42215:
			case 42223:
			case 42232:
			case 42236:
			case 42256:
			case 42265:
			case 42275:
			case 42286:
			case 42327:
			case 42330:
			case 42348:
			case 42351:
			case 42368:
			case 42372:
			case 42376:
			case 42378:
			case 42408:
			case 42437:
			case 42445:
			case 42456:
			case 42459:
			case 42603:
			case 42642:
			case 42712:
			case 42717:
			case 42721:
			case 42749:
			case 42757:
			case 42764:
			case 46341:
			case 46374:
			case 46532:
			case 46552:
			case 47523:
			case 47537:
			case 47577:
			case 47601:
			case 47639:
			case 47640:
			case 47660:
			case 47943:
			case 47948:
			case 49892:
			case 57544:
			case 57548:
			case 57559:
			case 57564:
			case 57568:
			case 57569:
			case 57571:
			case 57576:
			case 57580:
			case 57584:
			case 57601:
			case 57631:
			case 57632:
			case 57646:
			case 57648:
			case 58521:
			case 58524:
			case 58531:
			case 58532:
			case 58540:
			case 58542:
			case 58544:
			case 58549:
			case 58552:
			case 58565:
			case 58581:
			case 67734:
			case 69022:
			case 69024:
			case 69025:
			case 69026:
			case 69028:
			case 69029:
			case 69032:
			case 69034:
			case 69036:
			case 69038:
			case 69039:
			case 69040:
			case 69042:
			case 69043:
			case 69044:
			case 69123:
			case 69130:
			case 69132:
			case 69135:
			case 69138:
			case 69142:
			case 69143:
			case 69151:
			case 69157:
			case 69161:
			case 69169:
			case 69170:
			case 69171:
			case 69201:
			case 69210:
			case 69212:
			case 69214:
			case 69217:
			case 69220:
			case 69221:
			case 79852:
			case 79854:
			case 79855:
				return self::CHICAGO;
				
			case 57521:
			case 57537:
			case 57543:
			case 57547:
			case 57560:
			case 57562:
			case 57563:
			case 57566:
			case 57567:
			case 57570:
			case 57572:
			case 57574:
			case 57577:
			case 57579:
			case 57585:
			case 58520:
			case 58523:
			case 58528:
			case 58529:
			case 58533:
			case 58535:
			case 58538:
			case 58541:
			case 58545:
			case 58554:
			case 58562:
			case 58563:
			case 58564:
			case 58580:
			case 67733:
			case 67735:
			case 67741:
			case 67758:
			case 67761:
			case 67762:
			case 67836:
			case 67857:
			case 67878:
			case 67879:
			case 69021:
			case 69023:
			case 69027:
			case 69030:
			case 69033:
			case 69037:
			case 69041:
			case 69045:
			case 69121:
			case 69122:
			case 69131:
			case 69133:
			case 69134:
			case 69140:
			case 69141:
			case 69160:
			case 69162:
			case 69168:
			case 69190:
			case 69211:
			case 69216:
			case 69218:
			case 69219:
			case 79821:
			case 79849:
			case 79851:
			case 79853:
			case 83211:
			case 83213:
			case 83274:
			case 83285:
			case 83332:
			case 83334:
			case 83347:
			case 83350:
			case 83414:
			case 83436:
			case 83443:
			case 83547:
			case 83660:
			case 85356:
			case 85539:
			case 85602:
			case 85637:
			case 85645:
			case 86020:
			case 86021:
			case 86022:
			case 86024:
			case 86035:
			case 86036:
			case 86038:
			case 86040:
			case 86044:
			case 86045:
			case 86046:
			case 86053:
			case 86434:
			case 86435:
				return self::DENVER;
				
			case 48458:
			case 48616:
			case 48618:
			case 48620:
			case 48621:
			case 48651:
			case 48652:
			case 48754:
			case 48755:
			case 48756:
			case 48758:
			case 48759:
			case 48808:
			case 48829:
			case 48830:
			case 48832:
			case 48833:
			case 48842:
			case 48843:
			case 48844:
			case 48846:
			case 48847:
			case 48867:
			case 48870:
			case 48871:
			case 48878:
			case 48879:
			case 48881:
			case 48882:
			case 48891:
			case 49091:
			case 49092:
			case 49093:
			case 49227:
			case 49228:
			case 49229:
			case 49237:
			case 49238:
			case 49239:
			case 49309:
			case 49311:
			case 49312:
			case 49314:
			case 49339:
			case 49341:
			case 49342:
			case 49450:
			case 49632:
			case 49639:
			case 49640:
			case 49642:
			case 49656:
			case 49657:
			case 49660:
			case 49664:
			case 49696:
			case 49701:
			case 49705:
			case 49728:
			case 49729:
			case 49752:
			case 49753:
			case 49805:
			case 49806:
			case 49808:
			case 49814:
			case 49833:
			case 49849:
			case 49853:
			case 49854:
			case 49855:
			case 49862:
			case 49871:
			case 49872:
			case 49879:
			case 49883:
			case 49884:
			case 49891:
			case 49894:
			case 49895:
			case 49901:
			case 49905:
			case 49908:
			case 49910:
			case 49912:
			case 49921:
			case 49922:
			case 49925:
			case 49942:
			case 49945:
			case 49946:
			case 49965:
			case 49970:
			case 49971:
				return self::DETROIT;
				
			case 45390:
			case 46037:
			case 46038:
			case 46039:
			case 46067:
			case 46068:
			case 46122:
			case 46123:
			case 46131:
			case 46161:
			case 46162:
			case 46163:
			case 46182:
			case 46183:
			case 46184:
			case 46507:
			case 46508:
			case 46510:
			case 46730:
			case 46731:
			case 46769:
			case 46789:
			case 46791:
			case 46984:
			case 46992:
			case 46994:
			case 46995:
			case 46998:
			case 47003:
			case 47010:
			case 47012:
			case 47016:
			case 47017:
			case 47039:
			case 47042:
			case 47102:
			case 47104:
			case 47117:
			case 47119:
			case 47120:
			case 47124:
			case 47139:
			case 47146:
			case 47172:
			case 47231:
			case 47234:
			case 47236:
			case 47240:
			case 47243:
			case 47260:
			case 47261:
			case 47263:
			case 47265:
			case 47270:
			case 47273:
			case 47274:
			case 47280:
			case 47353:
			case 47369:
			case 47370:
			case 47371:
			case 47434:
			case 47435:
			case 47437:
			case 47531:
			case 47536:
			case 47550:
			case 47552:
			case 47556:
			case 47579:
			case 47836:
			case 47838:
			case 47840:
			case 47841:
			case 47928:
			case 47929:
			case 47930:
			case 47944:
			case 47949:
			case 47950:
			case 47951:
			case 47954:
			case 47955:
			case 47958:
			case 47959:
				return self::INDIANAPOLIS;
				
			case 46366:
			case 46531:
			case 46534:
			case 46968:
				return self::KNOX;
				
			case 47116:
			case 47123:
			case 47137:
			case 47145:
			case 47174:
			case 47175	:
				return self::MARENGO;

			case 47564:
			case 47567:
			case 47584:
			case 47585:
			case 47590:
			case 47598:
				return self::PETERSBURG;
				
			case 47514:
			case 47515:
			case 47520:
			case 47525:
			case 47551:
			case 47574:
			case 47576:
			case 47586:
			case 47588:
				return self::TELL_CITY;
				
			case 47011:
			case 47019:
			case 47020:
			case 47038:
			case 47043:
				return self::VEVAY;
				
			case 47457:
			case 47501:
			case 47512:
			case 47516:
			case 47519:
			case 47521:
			case 47522:
			case 47524:
			case 47527:
			case 47528:
			case 47529:
			case 47535:
			case 47568:
			case 47573:
			case 47575:
			case 47578:
			case 47580:
			case 47581:
			case 47591:
			case 47596:
			case 47597:
				return self::VINCENNES;
				
			case 46985:
			case 46996:
			case 47946:
			case 47957:
				return self::WINAMAC;
				
			case 99950:
				return self::JUNEAU;
				
			case 40010:
			case 40012:
			case 40056:
			case 40058:
			case 40075:
			case 40176:
			case 40329:
			case 40334:
			case 40337:
			case 40339:
			case 40340:
			case 40440:
			case 40444:
			case 40445:
			case 40446:
			case 40486:
			case 40488:
			case 41004:
			case 41005:
			case 41006:
			case 41008:
			case 41031:
			case 41033:
			case 41034:
			case 41048:
			case 41049:
			case 41091:
			case 41093:
			case 41135:
			case 41137:
			case 41139:
			case 41307:
			case 41310:
			case 41313:
			case 41317:
			case 41333:
			case 41338:
			case 42036:
			case 42037:
			case 42038:
			case 42040:
			case 42130:
			case 42131:
			case 42163:
			case 42164:
			case 42167:
			case 42234:
			case 42235:
			case 42328:
			case 42349:
			case 42350:
			case 42369:
			case 42370:
			case 42371:
			case 42374:
			case 42375:
			case 42377:
			case 42457:
			case 42458:
			case 42519:
			case 42629:
			case 42631:
			case 42634:
			case 42635:
			case 42638:
			case 42713:
			case 42715:
			case 42718:
			case 42719:
			case 42720:
			case 42722:
			case 42724:
			case 42732:
			case 42753:
			case 42754:
			case 42755:
			case 42758:
			case 42759:
			case 42762:
			case 42765:
			case 42782:
			case 42783:
			case 42786:
			case 42788:
				return self::LOUISVILLE;
				
			case 42633:
				return self::MONTICELLO;
				
			case 83671:
				return self::LOS_ANGELES;
				
			case 49801:
			case 49802:
			case 49812:
			case 49815:
			case 49821:
			case 49831:
			case 49834:
			case 49845:
			case 49847:
			case 49848:
			case 49852:
			case 49858:
			case 49863:
			case 49870:
			case 49881:
			case 49886:
			case 49887:
			case 49893:
			case 49896:
			case 49902:
			case 49903:
			case 49911:
			case 49915:
			case 49920:
			case 49927:
			case 49935:
			case 49938:
			case 49947:
			case 49959:
			case 49964:
			case 49968:
			case 49969:
				return self::MENOMINEE;
				
			case 32456:
			case 32457:
			case 37302:
			case 37303:
			case 37304:
			case 37325:
			case 37326:
			case 37329:
			case 37331:
			case 37332:
			case 37333:
			case 37336:
			case 37337:
			case 37341:
			case 37343:
			case 37350:
			case 37351:
			case 37353:
			case 37354:
			case 37377:
			case 37379:
			case 37381:
			case 37384:
			case 37385:
			case 37391:
			case 40009:
			case 40011:
			case 40013:
			case 40046:
			case 40051:
			case 40052:
			case 40055:
			case 40057:
			case 40059:
			case 40071:
			case 40076:
			case 40150:
			case 40175:
			case 40177:
			case 40311:
			case 40328:
			case 40330:
			case 40336:
			case 40342:
			case 40351:
			case 40353:
			case 40370:
			case 40379:
			case 40419:
			case 40437:
			case 40442:
			case 40447:
			case 40461:
			case 40484:
			case 40489:
			case 40729:
			case 40823:
			case 40840:
			case 40939:
			case 40940:
			case 40962:
			case 40983:
			case 41003:
			case 41007:
			case 41010:
			case 41030:
			case 41035:
			case 41046:
			case 41051:
			case 41086:
			case 41092:
			case 41094:
			case 41129:
			case 41132:
			case 41141:
			case 41168:
			case 41219:
			case 41254:
			case 41301:
			case 41311:
			case 41314:
			case 41332:
			case 41339:
			case 41365:
			case 41386:
			case 41425:
			case 41465:
			case 41472:
			case 41537:
			case 41722:
			case 41731:
			case 41745:
			case 41773:
			case 41862:
			case 42518:
			case 42528:
			case 42716:
			case 42733:
			case 42776:
			case 42784:
			case 46036:
			case 46040:
			case 46055:
			case 46064:
			case 46065:
			case 46069:
			case 46112:
			case 46113:
			case 46121:
			case 46124:
			case 46130:
			case 46133:
			case 46148:
			case 46158:
			case 46160:
			case 46164:
			case 46180:
			case 46181:
			case 46186:
			case 46506:
			case 46511:
			case 46550:
			case 46562:
			case 46574:
			case 46705:
			case 46723:
			case 46725:
			case 46732:
			case 46747:
			case 46761:
			case 46767:
			case 46770:
			case 46776:
			case 46783:
			case 46788:
			case 46792:
			case 46910:
			case 46919:
			case 46929:
			case 46940:
			case 46950:
			case 46960:
			case 46970:
			case 46982:
			case 46991:
			case 47001:
			case 47006:
			case 47018:
			case 47040:
			case 47041:
			case 47060:
			case 47106:
			case 47118:
			case 47122:
			case 47125:
			case 47138:
			case 47140:
			case 47147:
			case 47170:
			case 47177:
			case 47224:
			case 47230:
			case 47232:
			case 47235:
			case 47244:
			case 47250:
			case 47264:
			case 47272:
			case 47281:
			case 47325:
			case 47336:
			case 47352:
			case 47354:
			case 47359:
			case 47368:
			case 47373:
			case 47384:
			case 47432:
			case 47433:
			case 47436:
			case 47438:
			case 47448:
			case 47456:
			case 47468:
			case 47513:
			case 47532:
			case 47553:
			case 47833:
			case 47834:
			case 47837:
			case 47842:
			case 47858:
			case 47868:
			case 47874:
			case 47917:
			case 47918:
			case 47926:
			case 47932:
			case 47952:
			case 47960:
			case 47970:
			case 48041:
			case 48160:
			case 48170:
			case 48178:
			case 48191:
			case 48416:
			case 48429:
			case 48430:
			case 48438:
			case 48451:
			case 48457:
			case 48460:
			case 48475:
			case 48610:
			case 48615:
			case 48617:
			case 48619:
			case 48622:
			case 48623:
			case 48624:
			case 48632:
			case 48637:
			case 48650:
			case 48653:
			case 48726:
			case 48744:
			case 48750:
			case 48757:
			case 48760:
			case 48761:
			case 48807:
			case 48809:
			case 48827:
			case 48831:
			case 48834:
			case 48841:
			case 48845:
			case 48848:
			case 48849:
			case 48850:
			case 48866:
			case 48872:
			case 48877:
			case 48880:
			case 48883:
			case 48890:
			case 48892:
			case 49021:
			case 49034:
			case 49047:
			case 49060:
			case 49067:
			case 49076:
			case 49090:
			case 49094:
			case 49099:
			case 49224:
			case 49230:
			case 49236:
			case 49240:
			case 49247:
			case 49255:
			case 49267:
			case 49284:
			case 49307:
			case 49310:
			case 49315:
			case 49325:
			case 49338:
			case 49340:
			case 49343:
			case 49421:
			case 49449:
			case 49451:
			case 49613:
			case 49620:
			case 49631:
			case 49633:
			case 49638:
			case 49643:
			case 49649:
			case 49655:
			case 49659:
			case 49663:
			case 49665:
			case 49676:
			case 49683:
			case 49689:
			case 49690:
			case 49706:
			case 49707:
			case 49716:
			case 49727:
			case 49730:
			case 49733:
			case 49751:
			case 49755:
			case 49756:
			case 49765:
			case 49776:
			case 49807:
			case 49861:
			case 49878:
			case 49880:
			case 49885:
			case 49913:
			case 49948:
			case 49958:
			case 49967:
				return self::NEW_YORK;
				
			case 99554:
			case 99563:
			case 99581:
			case 99584:
			case 99585:
			case 99604:
			case 99620:
			case 99632:
			case 99650:
			case 99657:
			case 99658:
			case 99659:
			case 99662:
			case 99666:
			case 99671:
			case 99684:
			case 99736:
			case 99739:
			case 99742:
			case 99761:
			case 99762:
			case 99763:
			case 99778:
				return self::NOME;
				
			case 58530:
				return self::NORTH_DAKOTA;
				
			case 85922:
			case 85931:
			case 86023:
			case 86052:
			case 86555:
				return self::PHOENIX;
				
			case 86039:
			case 86042:
			case 86043:
			case 86047:
			case 86054:
			case 86556:
				return self::SHIPROCK;
				
			case 99689:
				return self::YAKUTAT;
				
			//case :
				//return self::HONOLULU;
		}
		return self::UNKNOWN;
	}

}
