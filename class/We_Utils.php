<?php

if (! defined('ABSPATH')) {
    die();
}

class We_Utils
{
    public static string $geo_ip_api = ' https://api.country.is/';
    public static array $countries = array(
        "DEFAULT" => "Default",
        "AF"      => "Afghanistan",
        "AL"      => "Albania",
        "DZ"      => "Algeria",
        "AS"      => "American Samoa",
        "AD"      => "Andorra",
        "AO"      => "Angola",
        "AI"      => "Anguilla",
        "AQ"      => "Antarctica",
        "AG"      => "Antigua and Barbuda",
        "AR"      => "Argentina",
        "AM"      => "Armenia",
        "AW"      => "Aruba",
        "AU"      => "Australia",
        "AT"      => "Austria",
        "AZ"      => "Azerbaijan",
        "BS"      => "Bahamas",
        "BH"      => "Bahrain",
        "BD"      => "Bangladesh",
        "BB"      => "Barbados",
        "BY"      => "Belarus",
        "BE"      => "Belgium",
        "BZ"      => "Belize",
        "BJ"      => "Benin",
        "BM"      => "Bermuda",
        "BT"      => "Bhutan",
        "BO"      => "Bolivia",
        "BA"      => "Bosnia and Herzegovina",
        "BW"      => "Botswana",
        "BV"      => "Bouvet Island",
        "BR"      => "Brazil",
        "BQ"      => "British Antarctic Territory",
        "IO"      => "British Indian Ocean Territory",
        "VG"      => "British Virgin Islands",
        "BN"      => "Brunei",
        "BG"      => "Bulgaria",
        "BF"      => "Burkina Faso",
        "BI"      => "Burundi",
        "KH"      => "Cambodia",
        "CM"      => "Cameroon",
        "CA"      => "Canada",
        "CT"      => "Canton and Enderbury Islands",
        "CV"      => "Cape Verde",
        "KY"      => "Cayman Islands",
        "CF"      => "Central African Republic",
        "TD"      => "Chad",
        "CL"      => "Chile",
        "CN"      => "China",
        "CX"      => "Christmas Island",
        "CC"      => "Cocos [Keeling] Islands",
        "CO"      => "Colombia",
        "KM"      => "Comoros",
        "CG"      => "Congo - Brazzaville",
        "CD"      => "Congo - Kinshasa",
        "CK"      => "Cook Islands",
        "CR"      => "Costa Rica",
        "HR"      => "Croatia",
        "CU"      => "Cuba",
        "CY"      => "Cyprus",
        "CZ"      => "Czech Republic",
        "CI"      => "Côte d’Ivoire",
        "DK"      => "Denmark",
        "DJ"      => "Djibouti",
        "DM"      => "Dominica",
        "DO"      => "Dominican Republic",
        "NQ"      => "Dronning Maud Land",
        "DD"      => "East Germany",
        "EC"      => "Ecuador",
        "EG"      => "Egypt",
        "SV"      => "El Salvador",
        "GQ"      => "Equatorial Guinea",
        "ER"      => "Eritrea",
        "EE"      => "Estonia",
        "ET"      => "Ethiopia",
        "FK"      => "Falkland Islands",
        "FO"      => "Faroe Islands",
        "FJ"      => "Fiji",
        "FI"      => "Finland",
        "FR"      => "France",
        "GF"      => "French Guiana",
        "PF"      => "French Polynesia",
        "TF"      => "French Southern Territories",
        "FQ"      => "French Southern and Antarctic Territories",
        "GA"      => "Gabon",
        "GM"      => "Gambia",
        "GE"      => "Georgia",
        "DE"      => "Germany",
        "GH"      => "Ghana",
        "GI"      => "Gibraltar",
        "GR"      => "Greece",
        "GL"      => "Greenland",
        "GD"      => "Grenada",
        "GP"      => "Guadeloupe",
        "GU"      => "Guam",
        "GT"      => "Guatemala",
        "GG"      => "Guernsey",
        "GN"      => "Guinea",
        "GW"      => "Guinea-Bissau",
        "GY"      => "Guyana",
        "HT"      => "Haiti",
        "HM"      => "Heard Island and McDonald Islands",
        "HN"      => "Honduras",
        "HK"      => "Hong Kong SAR China",
        "HU"      => "Hungary",
        "IS"      => "Iceland",
        "IN"      => "India",
        "ID"      => "Indonesia",
        "IR"      => "Iran",
        "IQ"      => "Iraq",
        "IE"      => "Ireland",
        "IM"      => "Isle of Man",
        "IL"      => "Israel",
        "IT"      => "Italy",
        "JM"      => "Jamaica",
        "JP"      => "Japan",
        "JE"      => "Jersey",
        "JT"      => "Johnston Island",
        "JO"      => "Jordan",
        "KZ"      => "Kazakhstan",
        "KE"      => "Kenya",
        "KI"      => "Kiribati",
        "KW"      => "Kuwait",
        "KG"      => "Kyrgyzstan",
        "LA"      => "Laos",
        "LV"      => "Latvia",
        "LB"      => "Lebanon",
        "LS"      => "Lesotho",
        "LR"      => "Liberia",
        "LY"      => "Libya",
        "LI"      => "Liechtenstein",
        "LT"      => "Lithuania",
        "LU"      => "Luxembourg",
        "MO"      => "Macau SAR China",
        "MK"      => "Macedonia",
        "MG"      => "Madagascar",
        "MW"      => "Malawi",
        "MY"      => "Malaysia",
        "MV"      => "Maldives",
        "ML"      => "Mali",
        "MT"      => "Malta",
        "MH"      => "Marshall Islands",
        "MQ"      => "Martinique",
        "MR"      => "Mauritania",
        "MU"      => "Mauritius",
        "YT"      => "Mayotte",
        "FX"      => "Metropolitan France",
        "MX"      => "Mexico",
        "FM"      => "Micronesia",
        "MI"      => "Midway Islands",
        "MD"      => "Moldova",
        "MC"      => "Monaco",
        "MN"      => "Mongolia",
        "ME"      => "Montenegro",
        "MS"      => "Montserrat",
        "MA"      => "Morocco",
        "MZ"      => "Mozambique",
        "MM"      => "Myanmar [Burma]",
        "NA"      => "Namibia",
        "NR"      => "Nauru",
        "NP"      => "Nepal",
        "NL"      => "Netherlands",
        "AN"      => "Netherlands Antilles",
        "NT"      => "Neutral Zone",
        "NC"      => "New Caledonia",
        "NZ"      => "New Zealand",
        "NI"      => "Nicaragua",
        "NE"      => "Niger",
        "NG"      => "Nigeria",
        "NU"      => "Niue",
        "NF"      => "Norfolk Island",
        "KP"      => "North Korea",
        "VD"      => "North Vietnam",
        "MP"      => "Northern Mariana Islands",
        "NO"      => "Norway",
        "OM"      => "Oman",
        "PC"      => "Pacific Islands Trust Territory",
        "PK"      => "Pakistan",
        "PW"      => "Palau",
        "PS"      => "Palestinian Territories",
        "PA"      => "Panama",
        "PZ"      => "Panama Canal Zone",
        "PG"      => "Papua New Guinea",
        "PY"      => "Paraguay",
        "YD"      => "People's Democratic Republic of Yemen",
        "PE"      => "Peru",
        "PH"      => "Philippines",
        "PN"      => "Pitcairn Islands",
        "PL"      => "Poland",
        "PT"      => "Portugal",
        "PR"      => "Puerto Rico",
        "QA"      => "Qatar",
        "RO"      => "Romania",
        "RU"      => "Russia",
        "RW"      => "Rwanda",
        "RE"      => "Réunion",
        "BL"      => "Saint Barthélemy",
        "SH"      => "Saint Helena",
        "KN"      => "Saint Kitts and Nevis",
        "LC"      => "Saint Lucia",
        "MF"      => "Saint Martin",
        "PM"      => "Saint Pierre and Miquelon",
        "VC"      => "Saint Vincent and the Grenadines",
        "WS"      => "Samoa",
        "SM"      => "San Marino",
        "SA"      => "Saudi Arabia",
        "SN"      => "Senegal",
        "RS"      => "Serbia",
        "CS"      => "Serbia and Montenegro",
        "SC"      => "Seychelles",
        "SL"      => "Sierra Leone",
        "SG"      => "Singapore",
        "SK"      => "Slovakia",
        "SI"      => "Slovenia",
        "SB"      => "Solomon Islands",
        "SO"      => "Somalia",
        "ZA"      => "South Africa",
        "GS"      => "South Georgia and the South Sandwich Islands",
        "KR"      => "South Korea",
        "ES"      => "Spain",
        "LK"      => "Sri Lanka",
        "SD"      => "Sudan",
        "SR"      => "Suriname",
        "SJ"      => "Svalbard and Jan Mayen",
        "SZ"      => "Swaziland",
        "SE"      => "Sweden",
        "CH"      => "Switzerland",
        "SY"      => "Syria",
        "ST"      => "São Tomé and Príncipe",
        "TW"      => "Taiwan",
        "TJ"      => "Tajikistan",
        "TZ"      => "Tanzania",
        "TH"      => "Thailand",
        "TL"      => "Timor-Leste",
        "TG"      => "Togo",
        "TK"      => "Tokelau",
        "TO"      => "Tonga",
        "TT"      => "Trinidad and Tobago",
        "TN"      => "Tunisia",
        "TR"      => "Turkey",
        "TM"      => "Turkmenistan",
        "TC"      => "Turks and Caicos Islands",
        "TV"      => "Tuvalu",
        "UM"      => "U.S. Minor Outlying Islands",
        "PU"      => "U.S. Miscellaneous Pacific Islands",
        "VI"      => "U.S. Virgin Islands",
        "UG"      => "Uganda",
        "UA"      => "Ukraine",
        "SU"      => "Union of Soviet Socialist Republics",
        "AE"      => "United Arab Emirates",
        "GB"      => "United Kingdom",
        "US"      => "United States",
        "ZZ"      => "Unknown or Invalid Region",
        "UY"      => "Uruguay",
        "UZ"      => "Uzbekistan",
        "VU"      => "Vanuatu",
        "VA"      => "Vatican City",
        "VE"      => "Venezuela",
        "VN"      => "Vietnam",
        "WK"      => "Wake Island",
        "WF"      => "Wallis and Futuna",
        "EH"      => "Western Sahara",
        "YE"      => "Yemen",
        "ZM"      => "Zambia",
        "ZW"      => "Zimbabwe",
        "AX"      => "Åland Islands",
    );
    public static array $languages = array(
        'ab' => 'Abkhazian',
        'aa' => 'Afar',
        'af' => 'Afrikaans',
        'ak' => 'Akan',
        'sq' => 'Albanian',
        'am' => 'Amharic',
        'ar' => 'Arabic',
        'an' => 'Aragonese',
        'hy' => 'Armenian',
        'as' => 'Assamese',
        'av' => 'Avaric',
        'ae' => 'Avestan',
        'ay' => 'Aymara',
        'az' => 'Azerbaijani',
        'bm' => 'Bambara',
        'ba' => 'Bashkir',
        'eu' => 'Basque',
        'be' => 'Belarusian',
        'bn' => 'Bengali',
        'bh' => 'Bihari languages',
        'bi' => 'Bislama',
        'bs' => 'Bosnian',
        'br' => 'Breton',
        'bg' => 'Bulgarian',
        'my' => 'Burmese',
        'ca' => 'Catalan, Valencian',
        'km' => 'Central Khmer',
        'ch' => 'Chamorro',
        'ce' => 'Chechen',
        'ny' => 'Chichewa, Chewa, Nyanja',
        'zh' => 'Chinese',
        'cu' => 'Church Slavonic, Old Bulgarian, Old Church Slavonic',
        'cv' => 'Chuvash',
        'kw' => 'Cornish',
        'co' => 'Corsican',
        'cr' => 'Cree',
        'hr' => 'Croatian',
        'cs' => 'Czech',
        'da' => 'Danish',
        'dv' => 'Divehi, Dhivehi, Maldivian',
        'nl' => 'Dutch, Flemish',
        'dz' => 'Dzongkha',
        'en' => 'English',
        'eo' => 'Esperanto',
        'et' => 'Estonian',
        'ee' => 'Ewe',
        'fo' => 'Faroese',
        'fj' => 'Fijian',
        'fi' => 'Finnish',
        'fr' => 'French',
        'ff' => 'Fulah',
        'gd' => 'Gaelic, Scottish Gaelic',
        'gl' => 'Galician',
        'lg' => 'Ganda',
        'ka' => 'Georgian',
        'de' => 'German',
        'ki' => 'Gikuyu, Kikuyu',
        'el' => 'Greek (Modern)',
        'kl' => 'Greenlandic, Kalaallisut',
        'gn' => 'Guarani',
        'gu' => 'Gujarati',
        'ht' => 'Haitian, Haitian Creole',
        'ha' => 'Hausa',
        'he' => 'Hebrew',
        'hz' => 'Herero',
        'hi' => 'Hindi',
        'ho' => 'Hiri Motu',
        'hu' => 'Hungarian',
        'is' => 'Icelandic',
        'io' => 'Ido',
        'ig' => 'Igbo',
        'id' => 'Indonesian',
        'ia' => 'Interlingua (International Auxiliary Language Association)',
        'ie' => 'Interlingue',
        'iu' => 'Inuktitut',
        'ik' => 'Inupiaq',
        'ga' => 'Irish',
        'it' => 'Italian',
        'ja' => 'Japanese',
        'jv' => 'Javanese',
        'kn' => 'Kannada',
        'kr' => 'Kanuri',
        'ks' => 'Kashmiri',
        'kk' => 'Kazakh',
        'rw' => 'Kinyarwanda',
        'kv' => 'Komi',
        'kg' => 'Kongo',
        'ko' => 'Korean',
        'kj' => 'Kwanyama, Kuanyama',
        'ku' => 'Kurdish',
        'ky' => 'Kyrgyz',
        'lo' => 'Lao',
        'la' => 'Latin',
        'lv' => 'Latvian',
        'lb' => 'Letzeburgesch, Luxembourgish',
        'li' => 'Limburgish, Limburgan, Limburger',
        'ln' => 'Lingala',
        'lt' => 'Lithuanian',
        'lu' => 'Luba-Katanga',
        'mk' => 'Macedonian',
        'mg' => 'Malagasy',
        'ms' => 'Malay',
        'ml' => 'Malayalam',
        'mt' => 'Maltese',
        'gv' => 'Manx',
        'mi' => 'Maori',
        'mr' => 'Marathi',
        'mh' => 'Marshallese',
        'ro' => 'Moldovan, Moldavian, Romanian',
        'mn' => 'Mongolian',
        'na' => 'Nauru',
        'nv' => 'Navajo, Navaho',
        'nd' => 'Northern Ndebele',
        'ng' => 'Ndonga',
        'ne' => 'Nepali',
        'se' => 'Northern Sami',
        'no' => 'Norwegian',
        'nb' => 'Norwegian Bokmål',
        'nn' => 'Norwegian Nynorsk',
        'ii' => 'Nuosu, Sichuan Yi',
        'oc' => 'Occitan (post 1500)',
        'oj' => 'Ojibwa',
        'or' => 'Oriya',
        'om' => 'Oromo',
        'os' => 'Ossetian, Ossetic',
        'pi' => 'Pali',
        'pa' => 'Panjabi, Punjabi',
        'ps' => 'Pashto, Pushto',
        'fa' => 'Persian',
        'pl' => 'Polish',
        'pt' => 'Portuguese',
        'qu' => 'Quechua',
        'rm' => 'Romansh',
        'rn' => 'Rundi',
        'ru' => 'Russian',
        'sm' => 'Samoan',
        'sg' => 'Sango',
        'sa' => 'Sanskrit',
        'sc' => 'Sardinian',
        'sr' => 'Serbian',
        'sn' => 'Shona',
        'sd' => 'Sindhi',
        'si' => 'Sinhala, Sinhalese',
        'sk' => 'Slovak',
        'sl' => 'Slovenian',
        'so' => 'Somali',
        'st' => 'Sotho, Southern',
        'nr' => 'South Ndebele',
        'es' => 'Spanish, Castilian',
        'su' => 'Sundanese',
        'sw' => 'Swahili',
        'ss' => 'Swati',
        'sv' => 'Swedish',
        'tl' => 'Tagalog',
        'ty' => 'Tahitian',
        'tg' => 'Tajik',
        'ta' => 'Tamil',
        'tt' => 'Tatar',
        'te' => 'Telugu',
        'th' => 'Thai',
        'bo' => 'Tibetan',
        'ti' => 'Tigrinya',
        'to' => 'Tonga (Tonga Islands)',
        'ts' => 'Tsonga',
        'tn' => 'Tswana',
        'tr' => 'Turkish',
        'tk' => 'Turkmen',
        'tw' => 'Twi',
        'ug' => 'Uighur, Uyghur',
        'uk' => 'Ukrainian',
        'ur' => 'Urdu',
        'uz' => 'Uzbek',
        've' => 'Venda',
        'vi' => 'Vietnamese',
        'vo' => 'Volap_k',
        'wa' => 'Walloon',
        'cy' => 'Welsh',
        'fy' => 'Western Frisian',
        'wo' => 'Wolof',
        'xh' => 'Xhosa',
        'yi' => 'Yiddish',
        'yo' => 'Yoruba',
        'za' => 'Zhuang, Chuang',
        'zu' => 'Zulu'
    );
    public static array $currencies = array(
        'ALL' => 'Albania Lek',
        'AFN' => 'Afghanistan Afghani',
        'ARS' => 'Argentina Peso',
        'AWG' => 'Aruba Guilder',
        'AUD' => 'Australia Dollar',
        'AZN' => 'Azerbaijan New Manat',
        'BSD' => 'Bahamas Dollar',
        'BBD' => 'Barbados Dollar',
        'BDT' => 'Bangladeshi taka',
        'BYR' => 'Belarus Ruble',
        'BZD' => 'Belize Dollar',
        'BMD' => 'Bermuda Dollar',
        'BOB' => 'Bolivia Boliviano',
        'BAM' => 'Bosnia and Herzegovina Convertible Marka',
        'BWP' => 'Botswana Pula',
        'BGN' => 'Bulgaria Lev',
        'BRL' => 'Brazil Real',
        'BND' => 'Brunei Darussalam Dollar',
        'KHR' => 'Cambodia Riel',
        'CAD' => 'Canada Dollar',
        'KYD' => 'Cayman Islands Dollar',
        'CLP' => 'Chile Peso',
        'CNY' => 'China Yuan Renminbi',
        'COP' => 'Colombia Peso',
        'CRC' => 'Costa Rica Colon',
        'HRK' => 'Croatia Kuna',
        'CUP' => 'Cuba Peso',
        'CZK' => 'Czech Republic Koruna',
        'DKK' => 'Denmark Krone',
        'DOP' => 'Dominican Republic Peso',
        'XCD' => 'East Caribbean Dollar',
        'EGP' => 'Egypt Pound',
        'SVC' => 'El Salvador Colon',
        'EEK' => 'Estonia Kroon',
        'EUR' => 'Euro Member Countries',
        'FKP' => 'Falkland Islands (Malvinas) Pound',
        'FJD' => 'Fiji Dollar',
        'GHC' => 'Ghana Cedis',
        'GIP' => 'Gibraltar Pound',
        'GTQ' => 'Guatemala Quetzal',
        'GGP' => 'Guernsey Pound',
        'GYD' => 'Guyana Dollar',
        'HNL' => 'Honduras Lempira',
        'HKD' => 'Hong Kong Dollar',
        'HUF' => 'Hungary Forint',
        'ISK' => 'Iceland Krona',
        'INR' => 'India Rupee',
        'IDR' => 'Indonesia Rupiah',
        'IRR' => 'Iran Rial',
        'IMP' => 'Isle of Man Pound',
        'ILS' => 'Israel Shekel',
        'JMD' => 'Jamaica Dollar',
        'JPY' => 'Japan Yen',
        'JEP' => 'Jersey Pound',
        'KZT' => 'Kazakhstan Tenge',
        'KPW' => 'Korea (North) Won',
        'KRW' => 'Korea (South) Won',
        'KGS' => 'Kyrgyzstan Som',
        'LAK' => 'Laos Kip',
        'LVL' => 'Latvia Lat',
        'LBP' => 'Lebanon Pound',
        'LRD' => 'Liberia Dollar',
        'LTL' => 'Lithuania Litas',
        'MKD' => 'Macedonia Denar',
        'MYR' => 'Malaysia Ringgit',
        'MUR' => 'Mauritius Rupee',
        'MXN' => 'Mexico Peso',
        'MNT' => 'Mongolia Tughrik',
        'MZN' => 'Mozambique Metical',
        'NAD' => 'Namibia Dollar',
        'NPR' => 'Nepal Rupee',
        'ANG' => 'Netherlands Antilles Guilder',
        'NZD' => 'New Zealand Dollar',
        'NIO' => 'Nicaragua Cordoba',
        'NGN' => 'Nigeria Naira',
        'NOK' => 'Norway Krone',
        'OMR' => 'Oman Rial',
        'PKR' => 'Pakistan Rupee',
        'PAB' => 'Panama Balboa',
        'PYG' => 'Paraguay Guarani',
        'PEN' => 'Peru Nuevo Sol',
        'PHP' => 'Philippines Peso',
        'PLN' => 'Poland Zloty',
        'QAR' => 'Qatar Riyal',
        'RON' => 'Romania New Leu',
        'RUB' => 'Russia Ruble',
        'SHP' => 'Saint Helena Pound',
        'SAR' => 'Saudi Arabia Riyal',
        'RSD' => 'Serbia Dinar',
        'SCR' => 'Seychelles Rupee',
        'SGD' => 'Singapore Dollar',
        'SBD' => 'Solomon Islands Dollar',
        'SOS' => 'Somalia Shilling',
        'ZAR' => 'South Africa Rand',
        'LKR' => 'Sri Lanka Rupee',
        'SEK' => 'Sweden Krona',
        'CHF' => 'Switzerland Franc',
        'SRD' => 'Suriname Dollar',
        'SYP' => 'Syria Pound',
        'TWD' => 'Taiwan New Dollar',
        'THB' => 'Thailand Baht',
        'TTD' => 'Trinidad and Tobago Dollar',
        'TRY' => 'Turkey Lira',
        'TRL' => 'Turkey Lira',
        'TVD' => 'Tuvalu Dollar',
        'UAH' => 'Ukraine Hryvna',
        'GBP' => 'United Kingdom Pound',
        'USD' => 'United States Dollar',
        'UYU' => 'Uruguay Peso',
        'UZS' => 'Uzbekistan Som',
        'VEF' => 'Venezuela Bolivar',
        'VND' => 'Viet Nam Dong',
        'YER' => 'Yemen Rial',
        'ZWD' => 'Zimbabwe Dollar'
    );

    public static string $uploaded_files_table_name = 'we_uploaded_files';

    /**
     * @param $value
     * @param $places
     *
     * @return float|int
     */
    public static function round_up($value, $places = 0): float|int
    {
        if ($places < 0) {
            $places = 0;
        }
        $mult = pow(10, $places);

        return ceil($value * $mult) / $mult;
    }

    /**
     * @return mixed
     */
    public static function get_ip_address(): mixed
    {
        if (! empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (! empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        return $ip;
    }

    /**
     * @return false|string
     */
    public static function get_country_code(): false|string
    {
        $country_code = '';
        $ip           = self::get_ip_address();
        //		$ip           = '104.223.104.235'; // US
        //		$ip           = '138.199.47.207'; // FR
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
            try {
                $response = wp_remote_get(self::$geo_ip_api . $ip);
                if ($response['response']['code'] == 200) {
                    $response_body = json_decode($response['body']);
                    $country_code  = $response_body->country;
                }
            } catch (Exception $ex) {
                // Todo: Log Exception
            }
        }

        return $country_code;
    }

    /**
     * @param string $url
     * @param int $post_parent
     *
     * @return int|WP_Error|null
     */
    public static function upload_file(string $url, int $post_parent = 0): WP_Error|int|null
    {
        global $wpdb;

        $filename = basename($url);

        $table_name = self::get_uploaded_files_table_name();
        $result     = $wpdb->get_results(
            $wpdb->prepare("SELECT * FROM {$table_name} WHERE url = %s", $filename)
        );

        if (! empty($result)) {
            return $result[0]->attachment_id;
        }

        $upload_file = wp_upload_bits($filename, null, file_get_contents($url));
        if (! $upload_file['error']) {
            $wp_filetype = wp_check_filetype($filename, null);

            $attachment = array(
                'post_mime_type' => $wp_filetype['type'],
                'post_parent'    => $post_parent,
                'post_title'     => preg_replace('/\.[^.]+$/', '', $filename),
                'post_content'   => '',
                'post_status'    => 'inherit'
            );

            $attachment_id = wp_insert_attachment($attachment, $upload_file['file'], $post_parent);

            if (! is_wp_error($attachment_id)) {
                require_once(ABSPATH . "wp-admin" . '/includes/image.php');

                $attachment_data = wp_generate_attachment_metadata($attachment_id, $upload_file['file']);

                wp_update_attachment_metadata($attachment_id, $attachment_data);

                $wpdb->insert($table_name, array( 'url' => $filename, 'attachment_id' => $attachment_id ));

                return $attachment_id;
            }
        }

        return null;
    }

    /**
     * @return string
     */
    public static function get_uploaded_files_table_name(): string
    {
        global $wpdb;

        return $wpdb->prefix . self::$uploaded_files_table_name;
    }

    /**
     * @return void
     */
    public static function create_uploaded_files_table(): void
    {
        global $wpdb;

        $table_name      = self::get_uploaded_files_table_name();
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
			id bigint(9) unsigned NOT NULL AUTO_INCREMENT , 
			attachment_id bigint(9) unsigned NOT NULL,
			url varchar(55) NOT NULL , 
			PRIMARY KEY  (id), 
			KEY (url)
			) ENGINE = InnoDB $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    /**
     * @param mixed $root
     * @param array $meta_key_parts
     * @param mixed $meta_value
     * @param int $offset
     *
     * @return void
     */
    public static function build_meta_data(mixed &$root, array $meta_key_parts, mixed $meta_value, int $offset = 0): void
    {
        if (count($meta_key_parts) <= 1) {
            $root[ $meta_key_parts[0] ] = $meta_value;

        } else {
            if (! isset($root[ $meta_key_parts[0] ])) {
                $root[ $meta_key_parts[0] ] = array();
            }
            $offset++;
            $slice = array_slice($meta_key_parts, $offset);
            $slice = array_values($slice);
            self::build_meta_data(
                $root[ $meta_key_parts[0] ],
                array_slice($meta_key_parts, $offset),
                $meta_value,
                $offset
            );
        }

    }
}
