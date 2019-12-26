<?php


//    public function toSlug($text) {
//        return !empty($text) ? strtolower(preg_replace('/\s+/u', '-', trim($text))) : false;
//    }

 function get_client_ip($type = 0,$adv=false) {
    $type       =  $type ? 1 : 0;
    static $ip  =   NULL;
    if ($ip !== NULL) return $ip[$type];
    if($adv){
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $arr    =   explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $pos    =   array_search('unknown',$arr);
            if(false !== $pos) unset($arr[$pos]);
            $ip     =   trim($arr[0]);
        }elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip     =   $_SERVER['HTTP_CLIENT_IP'];
        }elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip     =   $_SERVER['REMOTE_ADDR'];
        }
    }elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $ip     =   $_SERVER['REMOTE_ADDR'];
    }
    // IP地址合法验证
    $long = sprintf("%u",ip2long($ip));
    $ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
    return $ip[$type];
}

function rgb_from_hex( $color ) {
    $color = str_replace( '#', '', $color );
    // Convert shorthand colors to full format, e.g. "FFF" -> "FFFFFF"
    $color = preg_replace( '~^(.)(.)(.)$~', '$1$1$2$2$3$3', $color );
    $rgb      = array();
    $rgb['R'] = hexdec( $color{0}.$color{1} );
    $rgb['G'] = hexdec( $color{2}.$color{3} );
    $rgb['B'] = hexdec( $color{4}.$color{5} );
    return $rgb;
}



function __ip_info( $purpose = "location", $ip = NULL ) {
    $output = NULL;
    if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
        $ip = __ip();
    }
    $purpose    = str_replace(["name", "\n", "\t", " ", "-", "_"], NULL, strtolower(trim($purpose)));
    $support    = ["country", "countrycode", "state", "region", "city", "location", "address"];
    $continents = [
        "AF" => "Africa",
        "AN" => "Antarctica",
        "AS" => "Asia",
        "EU" => "Europe",
        "OC" => "Australia (Oceania)",
        "NA" => "North America",
        "SA" => "South America"
    ];
    if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
        $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
        if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
            switch ($purpose) {
                case "location":
                    $output = [
                        "city"           => @$ipdat->geoplugin_city,
                        "state"          => @$ipdat->geoplugin_regionName,
                        "country"        => @$ipdat->geoplugin_countryName,
                        "countrycode"    => @$ipdat->geoplugin_countryCode,
                        "continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
                        "continentcode"  => @$ipdat->geoplugin_continentCode
                    ];
                    break;
                case "address":
                    $address = array($ipdat->geoplugin_countryName);
                    if (@strlen($ipdat->geoplugin_regionName) >= 1)
                        $address[] = $ipdat->geoplugin_regionName;
                    if (@strlen($ipdat->geoplugin_city) >= 1)
                        $address[] = $ipdat->geoplugin_city;
                    $output = implode(", ", array_reverse($address));
                    break;
                case "city":
                    $output = @$ipdat->geoplugin_city;
                    break;
                case "state":
                    $output = @$ipdat->geoplugin_regionName;
                    break;
                case "region":
                    $output = @$ipdat->geoplugin_regionName;
                    break;
                case "country":
                    $output = @$ipdat->geoplugin_countryName;
                    break;
                case "countrycode":
                    $output = @$ipdat->geoplugin_countryCode;
                    break;
            }
        }
    }
    return $output;
}




/**
 * @param array $arr
 * @return \stdClass
 * Description: 数组转成集合
 */
function arrayToClass(array $arr)
{
    $c = new \stdClass();
    foreach($arr as $k => $v){
        $c->$k = $v;
    }
    return $c;
}




    function getNewOrderStatusText($order_status){
        if(!$order_status){
            $order_status = 0;
        }
        //订单状态
        $arr = [
            '0' => 'Unknown',
            '1' => 'Undelivery',
            '2' => 'Unpaid',
            '3' => 'In transit',
            '4' => 'Undelivery',
            '5' => 'Canceled',
            '6' => 'Completed',
            '7' => 'Refunded',
            '8' => 'Part shipping',
            '9' => 'Part shipping',
            '10'=> 'Partial refund',
            '11'=> 'In transit',
            '12'=> 'Request refund',
            '13'=> 'Cancel Request',
            '14'=> 'Waiting for audit',
            '15'=> 'Refund failed',
            '16'=> 'Refund success',
            '17'=> 'Wait for pick up',
            '18'=> 'pick up',
        ];
        return $arr[$order_status];
    }

   
    function readyImage($img){
        if (!empty($img))
        {
            echo UPLOADS_PATH . DS . $img;
        }else{
            echo UPLOADS_PATH . DS . 'default.png';
        }
    }



    function redirect($path,$optionsPath = '/'){
        if($path == 'back')
        {
            $path = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $optionsPath ;
            header('location:' . $path);
            exit();
        }else{
            header('location:' . $path);
            exit();
        }
    }


    function decode($base64) {
        $base64 = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64));
        return $base64;
    }



/*
*    Debug
*/
function st($string){
    if($string){
        echo '<pre>';
        print_r($string);
        echo '</pre>';
    }
    return ' ';
}


/*
*    Debug and die
*/
function sv($string){
    st($string);
    exit;
}

/*
*    Clean the Inputs
*/




function is_slug ($input){
        if(!preg_match('/^[a-zA-Z]+[a-zA-Z0-9._-]+$/', $input)) {
            return true; 
        }else {
            return false;
        }
}



    /*
    *   Deleting all files in a folder ( and the hidden files also)
    */
    function delete_folders_files($path){
        $path = rtrim($path, '/').'/{,.}*';
        $files = glob($path, GLOB_BRACE); // get all file names
        foreach($files as $file){ // iterate files
          if(is_file($file))
            unlink($file); // delete file
        }
    }


  /*
    *   Function to Get Snippet from a string , 
    *   @str = the text you want to get snippet from
    *   @$wordCount = the number of words 
    *   usage example get_snippet($text,15,' [...] ');
    */
 function get_snippet( $str, $wordCount = 10 , $car = ' ' ) {
        $text = implode( 
        '', 
            array_slice( 
              preg_split(
                '/([\s,\.;\?\!]+)/', 
                $str, 
                $wordCount*2+1, 
                PREG_SPLIT_DELIM_CAPTURE
              ),
              0,
              $wordCount*2-1
            )
        );
        
        return $text.$car;
    }






function get_os(){
    if ( isset( $_SERVER ) ) {
        $agent = $_SERVER['HTTP_USER_AGENT'];
    }
    else {
        global $HTTP_SERVER_VARS;
        if ( isset( $HTTP_SERVER_VARS ) ) {
            $agent = $HTTP_SERVER_VARS['HTTP_USER_AGENT'];
        }
        else {
            global $HTTP_USER_AGENT;
            $agent = $HTTP_USER_AGENT;
        }
    }
    $ros[] = array('Windows XP', 'Windows XP');
    $ros[] = array('Windows NT 5.1|Windows NT5.1)', 'Windows XP');
    $ros[] = array('Windows 2000', 'Windows 2000');
    $ros[] = array('Windows NT 5.0', 'Windows 2000');
    $ros[] = array('Windows NT 4.0|WinNT4.0', 'Windows NT');
    $ros[] = array('Windows NT 5.2', 'Windows Server 2003');
    $ros[] = array('Windows NT 6.0', 'Windows Vista');
    $ros[] = array('Windows NT 7.0', 'Windows 7');
    $ros[] = array('Windows CE', 'Windows CE');
    $ros[] = array('(media center pc).([0-9]{1,2}\.[0-9]{1,2})', 'Windows Media Center');
    $ros[] = array('(win)([0-9]{1,2}\.[0-9x]{1,2})', 'Windows');
    $ros[] = array('(win)([0-9]{2})', 'Windows');
    $ros[] = array('(windows)([0-9x]{2})', 'Windows');
    // Doesn't seem like these are necessary...not totally sure though..
    //$ros[] = array('(winnt)([0-9]{1,2}\.[0-9]{1,2}){0,1}', 'Windows NT');
    //$ros[] = array('(windows nt)(([0-9]{1,2}\.[0-9]{1,2}){0,1})', 'Windows NT'); // fix by bg
    $ros[] = array('Windows ME', 'Windows ME');
    $ros[] = array('Win 9x 4.90', 'Windows ME');
    $ros[] = array('Windows 98|Win98', 'Windows 98');
    $ros[] = array('Windows 95', 'Windows 95');
    $ros[] = array('(windows)([0-9]{1,2}\.[0-9]{1,2})', 'Windows');
    $ros[] = array('win32', 'Windows');
    $ros[] = array('(java)([0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,2})', 'Java');
    $ros[] = array('(Solaris)([0-9]{1,2}\.[0-9x]{1,2}){0,1}', 'Solaris');
    $ros[] = array('dos x86', 'DOS');
    $ros[] = array('unix', 'Unix');
    $ros[] = array('Mac OS X', 'Mac OS X');
    $ros[] = array('Mac_PowerPC', 'Macintosh PowerPC');
    $ros[] = array('(mac|Macintosh)', 'Mac OS');
    $ros[] = array('(sunos)([0-9]{1,2}\.[0-9]{1,2}){0,1}', 'SunOS');
    $ros[] = array('(beos)([0-9]{1,2}\.[0-9]{1,2}){0,1}', 'BeOS');
    $ros[] = array('(risc os)([0-9]{1,2}\.[0-9]{1,2})', 'RISC OS');
    $ros[] = array('os/2', 'OS/2');
    $ros[] = array('freebsd', 'FreeBSD');
    $ros[] = array('openbsd', 'OpenBSD');
    $ros[] = array('netbsd', 'NetBSD');
    $ros[] = array('irix', 'IRIX');
    $ros[] = array('plan9', 'Plan9');
    $ros[] = array('osf', 'OSF');
    $ros[] = array('aix', 'AIX');
    $ros[] = array('GNU Hurd', 'GNU Hurd');
    $ros[] = array('(fedora)', 'Linux - Fedora');
    $ros[] = array('(kubuntu)', 'Linux - Kubuntu');
    $ros[] = array('(ubuntu)', 'Linux - Ubuntu');
    $ros[] = array('(debian)', 'Linux - Debian');
    $ros[] = array('(CentOS)', 'Linux - CentOS');
    $ros[] = array('(Mandriva).([0-9]{1,3}(\.[0-9]{1,3})?(\.[0-9]{1,3})?)', 'Linux - Mandriva');
    $ros[] = array('(SUSE).([0-9]{1,3}(\.[0-9]{1,3})?(\.[0-9]{1,3})?)', 'Linux - SUSE');
    $ros[] = array('(Dropline)', 'Linux - Slackware (Dropline GNOME)');
    $ros[] = array('(ASPLinux)', 'Linux - ASPLinux');
    $ros[] = array('(Red Hat)', 'Linux - Red Hat');
    // Loads of Linux machines will be detected as unix.
    // Actually, all of the linux machines I've checked have the 'X11' in the User Agent.
    //$ros[] = array('X11', 'Unix');
    $ros[] = array('(linux)', 'Linux');
    $ros[] = array('(amigaos)([0-9]{1,2}\.[0-9]{1,2})', 'AmigaOS');
    $ros[] = array('amiga-aweb', 'AmigaOS');
    $ros[] = array('amiga', 'Amiga');
    $ros[] = array('AvantGo', 'PalmOS');
    //$ros[] = array('(Linux)([0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,3}(rel\.[0-9]{1,2}){0,1}-([0-9]{1,2}) i([0-9]{1})86){1}', 'Linux');
    //$ros[] = array('(Linux)([0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,3}(rel\.[0-9]{1,2}){0,1} i([0-9]{1}86)){1}', 'Linux');
    //$ros[] = array('(Linux)([0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,3}(rel\.[0-9]{1,2}){0,1})', 'Linux');
    $ros[] = array('[0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,3})', 'Linux');
    $ros[] = array('(webtv)/([0-9]{1,2}\.[0-9]{1,2})', 'WebTV');
    $ros[] = array('Dreamcast', 'Dreamcast OS');
    $ros[] = array('GetRight', 'Windows');
    $ros[] = array('go!zilla', 'Windows');
    $ros[] = array('gozilla', 'Windows');
    $ros[] = array('gulliver', 'Windows');
    $ros[] = array('ia archiver', 'Windows');
    $ros[] = array('NetPositive', 'Windows');
    $ros[] = array('mass downloader', 'Windows');
    $ros[] = array('microsoft', 'Windows');
    $ros[] = array('offline explorer', 'Windows');
    $ros[] = array('teleport', 'Windows');
    $ros[] = array('web downloader', 'Windows');
    $ros[] = array('webcapture', 'Windows');
    $ros[] = array('webcollage', 'Windows');
    $ros[] = array('webcopier', 'Windows');
    $ros[] = array('webstripper', 'Windows');
    $ros[] = array('webzip', 'Windows');
    $ros[] = array('wget', 'Windows');
    $ros[] = array('Java', 'Unknown');
    $ros[] = array('flashget', 'Windows');
    // delete next line if the script show not the right OS
    //$ros[] = array('(PHP)/([0-9]{1,2}.[0-9]{1,2})', 'PHP');
    $ros[] = array('MS FrontPage', 'Windows');
    $ros[] = array('(msproxy)/([0-9]{1,2}.[0-9]{1,2})', 'Windows');
    $ros[] = array('(msie)([0-9]{1,2}.[0-9]{1,2})', 'Windows');
    $ros[] = array('libwww-perl', 'Unix');
    $ros[] = array('UP.Browser', 'Windows CE');
    $ros[] = array('NetAnts', 'Windows');
    $file = count ( $ros );
    $os = '';
    for ( $n=0 ; $n<$file ; $n++ ){
        if ( preg_match('/'.$ros[$n][0].'/i' , $agent, $name)){
            $os = @$ros[$n][1].' '.@$name[2];
            break;
        }
    }
    return trim ( $os );
}
    
    
    
//protected $searchable = [
//        'columns' => [
//            'title' => 7,
//            'content' => 5
//        ],
//    ];



//
//    public static function exceprt($string, $length = 150) {
//        $str_len = strlen($string);
//        $string = strip_tags($string);
//        if ($str_len > $length) {
//            // truncate string
//            $stringCut = substr($string, 0, $length-15);
//            $string = $stringCut.'.....'.substr($string, $str_len-10, $str_len-1);
//        }
//        return $string;
//    }
//
//
//




//
//	public function getTrash()
//	{
//		$pages = Page::onlyTrashed()->orderBy('title', 'asc')->paginate(30);
//		return view('shoppe::admin.pages.trash', [ 'pages' => $pages ]);
//	}
//	public function delete($id)
//	{
//		Page::find($id)->delete();
//		return redirect('/admin/pages')->with('success', 'Page deleted.');
//	}
//	public function recover($id)
//	{
//		Page::onlyTrashed()->where('id', $id)->restore();
//		return redirect('/admin/page/'.$id)->with('success', 'Page recovered.');
//	}
//	public function destroy($id)
//	{
//		Page::onlyTrashed()->where('id', $id)->forceDelete();
//		return redirect('/admin/pages-trash')->with('success', 'Page destroyed.');
//	}
//
//



function _parseCustomField($field, $repeater = 0)
{
	$html = '<li id="'.$field->field_id.'" data-row-id="'.$field->field_id.'">';
	$html .= '<div class="field-type-row" data-row-id="'.$field->field_id.'">';
	$fields = [
		[ 'label' => 'Text', 'type' => 'text'],
		[ 'label' => 'Checkbox', 'type' => 'checkbox'],
		[ 'label' => 'Radio', 'type' => 'radio'],
		[ 'label' => 'Multi-line Text', 'type' => 'textarea'],
		[ 'label' => 'Email', 'type' => 'email'],
		[ 'label' => 'Date', 'type' => 'date'],
		[ 'label' => 'Dropdown', 'type' => 'select'],
		[ 'label' => 'File', 'type' => 'file'],
		[ 'label' => 'Image', 'type' => 'image'],
		[ 'label' => 'Rich Text Editor', 'type' => 'editor']
	];
	switch( $field->field_type ){
		case 'text':
			$html .= '<div class="field-row">
				<div class="field-sort">
					<i class="far fa-sort"></i>
				</div>
				<div class="field-type-title">Text</div>
				<div class="field-row-options">
					<a class="collapse-field-row" href="/" data-row-id="'.$field->field_id.'">
						<i class="fas fa-angle-down"></i></a> <a class="remove-field-row" data-row-id="'.$field->field_id.'" href="/">&times;</a>
				</div>
			</div>
			<div id="field-group-'.$field->field_id.'" class="field-group" data-row-id="'.$field->field_id.'">
				<div class="field-row">
					<div class="label-col">Field Label</div>
					<div class="field-col">
						<input id="label-'.$field->field_id.'" class="field-label" type="text" name="field_label['.$field->field_id.']" value="'.$field->field_label.'">
						<input type="hidden" name="field_type['.$field->field_id.']" value="text">
					</div>
				</div>
				<div class="field-row">
					<div class="label-col">Field Name</div>
					<div class="field-col"><input id="name-'.$field->field_id.'" type="text" name="field_name['.$field->field_id.']" value="'.$field->field_name.'"></div>
				</div>
				<div class="field-row">
					<div class="label-col">Required</div>
					<div class="field-col">
						<label><input type="radio" name="field_required['.$field->field_id.']" '.($field->field_required === 1? 'checked' : '').' value="1"> Yes</label>
						<label><input type="radio" name="field_required['.$field->field_id.']" '.($field->field_required === 0? 'checked' : '').' value="0"> No</label>
					</div>
				</div>
			</div>
			';
		break;
		case 'email':
			$html .= '<div class="field-row">
				<div class="field-sort">
					<i class="far fa-sort"></i>
				</div>
				<div class="field-type-title">Email</div>
				<div class="field-row-options">
					<a class="collapse-field-row" href="/" data-row-id="'.$field->field_id.'">
						<i class="fas fa-angle-down"></i></a> <a class="remove-field-row" data-row-id="'.$field->field_id.'" href="/">&times;</a>
				</div>
			</div>
			<div id="field-group-'.$field->field_id.'" class="field-group" data-row-id="'.$field->field_id.'">
				<div class="field-row">
					<div class="label-col">Field Label</div>
					<div class="field-col">
						<input id="label-'.$field->field_id.'" class="field-label" type="text" name="field_label['.$field->field_id.']" value="'.$field->field_label.'">
						<input type="hidden" name="field_type['.$field->field_id.']" value="email">
					</div>
				</div>
				<div class="field-row">
					<div class="label-col">Field Name</div>
					<div class="field-col"><input id="name-'.$field->field_id.'" type="text" name="field_name['.$field->field_id.']" value="'.$field->field_name.'"></div>
				</div>
				<div class="field-row">
					<div class="label-col">Required</div>
					<div class="field-col">
						<label><input type="radio" name="field_required['.$field->field_id.']" '.($field->field_required === 1? 'checked' : '').' value="1"> Yes</label>
						<label><input type="radio" name="field_required['.$field->field_id.']" '.($field->field_required === 0? 'checked' : '').' value="0"> No</label>
					</div>
				</div>
			</div>
			';
		break;
		case 'date':
			$html .= '<div class="field-row">
				<div class="field-sort">
					<i class="far fa-sort"></i>
				</div>
				<div class="field-type-title">Date</div>
				<div class="field-row-options">
					<a class="collapse-field-row" href="/" data-row-id="'.$field->field_id.'">
						<i class="fas fa-angle-down"></i></a> <a class="remove-field-row" data-row-id="'.$field->field_id.'" href="/">&times;</a>
				</div>
			</div>
			<div id="field-group-'.$field->field_id.'" class="field-group" data-row-id="'.$field->field_id.'">
				<div class="field-row">
					<div class="label-col">Field Label</div>
					<div class="field-col">
						<input id="label-'.$field->field_id.'" class="field-label" type="text" name="field_label['.$field->field_id.']" value="'.$field->field_label.'">
						<input type="hidden" name="field_type['.$field->field_id.']" value="date">
					</div>
				</div>
				<div class="field-row">
					<div class="label-col">Field Name</div>
					<div class="field-col"><input id="name-'.$field->field_id.'" type="text" name="field_name['.$field->field_id.']" value="'.$field->field_name.'"></div>
				</div>
				<div class="field-row">
					<div class="label-col">Required</div>
					<div class="field-col">
						<label><input type="radio" name="field_required['.$field->field_id.']" '.($field->field_required === 1? 'checked' : '').' value="1"> Yes</label>
						<label><input type="radio" name="field_required['.$field->field_id.']" '.($field->field_required === 0? 'checked' : '').' value="0"> No</label>
					</div>
				</div>
			</div>
			';
		break;
		case 'textarea':
			$html .= '<div class="field-row">
				<div class="field-sort">
					<i class="far fa-sort"></i>
				</div>
				<div class="field-type-title">Multi-line Text</div>
				<div class="field-row-options">
					<a class="collapse-field-row" href="/" data-row-id="'.$field->field_id.'">
						<i class="fas fa-angle-down"></i></a> <a class="remove-field-row" data-row-id="'.$field->field_id.'" href="/">&times;</a>
				</div>
			</div>
			<div id="field-group-'.$field->field_id.'" class="field-group" data-row-id="'.$field->field_id.'">
				<div class="field-row">
					<div class="label-col">Field Label</div>
					<div class="field-col">
						<input id="label-'.$field->field_id.'" class="field-label" type="text" name="field_label['.$field->field_id.']" value="'.$field->field_label.'">
						<input type="hidden" name="field_type['.$field->field_id.']" value="textarea">
					</div>
				</div>
				<div class="field-row">
					<div class="label-col">Field Name</div>
					<div class="field-col"><input id="name-'.$field->field_id.'" type="text" name="field_name['.$field->field_id.']" value="'.$field->field_name.'"></div>
				</div>
				<div class="field-row">
					<div class="label-col">Required</div>
					<div class="field-col">
						<label><input type="radio" name="field_required['.$field->field_id.']" '.($field->field_required === 1? 'checked' : '').' value="1"> Yes</label>
						<label><input type="radio" name="field_required['.$field->field_id.']" '.($field->field_required === 0? 'checked' : '').' value="0"> No</label>
					</div>
				</div>
			</div>
			';
		break;
		case 'file':
			$html .= '<div class="field-row">
				<div class="field-sort">
					<i class="far fa-sort"></i>
				</div>
				<div class="field-type-title">File Upload</div>
				<div class="field-row-options">
					<a class="collapse-field-row" href="/" data-row-id="'.$field->field_id.'">
						<i class="fas fa-angle-down"></i></a> <a class="remove-field-row" data-row-id="'.$field->field_id.'" href="/">&times;</a>
				</div>
			</div>
			<div id="field-group-'.$field->field_id.'" class="field-group" data-row-id="'.$field->field_id.'">
				<div class="field-row">
					<div class="label-col">Field Label</div>
					<div class="field-col">
						<input id="label-'.$field->field_id.'" class="field-label" type="text" name="field_label['.$field->field_id.']" value="'.$field->field_label.'">
						<input type="hidden" name="field_type['.$field->field_id.']" value="file">
					</div>
				</div>
				<div class="field-row">
					<div class="label-col">Field Name</div>
					<div class="field-col"><input id="name-'.$field->field_id.'" type="text" name="field_name['.$field->field_id.']" value="'.$field->field_name.'"></div>
				</div>
				<div class="field-row">
					<div class="label-col">Multiple Files</div>
					<div class="field-col">
						<label><input type="radio" name="field_multiple['.$field->field_id.']" '.($field->multiple_files === 1? 'checked' : '').' value="1"> Yes</label>
						<label><input type="radio" name="field_multiple['.$field->field_id.']" '.($field->multiple_files === 0? 'checked' : '').' value="0"> No</label>
					</div>
				</div>
				<div class="field-row">
					<div class="label-col">Allowed File Types</div>
					<div class="field-col"><label><input type="text" name="field_filetypes['.$field->field_id.']" value="*"></div>
				</div>
				<div class="field-row">
					<div class="label-col">Required</div>
					<div class="field-col">
						<label><input type="radio" name="field_required['.$field->field_id.']" '.($field->field_required === 1? 'checked' : '').' value="1"> Yes</label>
						<label><input type="radio" name="field_required['.$field->field_id.']" '.($field->field_required === 0? 'checked' : '').' value="0"> No</label>
					</div>
				</div>
			</div>
			';
		break;
		case 'image':
			$html .= '<div class="field-row">
				<div class="field-sort">
					<i class="far fa-sort"></i>
				</div>
				<div class="field-type-title">Image Upload</div>
				<div class="field-row-options">
					<a class="collapse-field-row" href="/" data-row-id="'.$field->field_id.'">
						<i class="fas fa-angle-down"></i></a> <a class="remove-field-row" data-row-id="'.$field->field_id.'" href="/">&times;</a>
				</div>
			</div>
			<div id="field-group-'.$field->field_id.'" class="field-group" data-row-id="'.$field->field_id.'">
				<div class="field-row">
					<div class="label-col">Field Label</div>
					<div class="field-col">
						<input id="label-'.$field->field_id.'" class="field-label" type="text" name="field_label['.$field->field_id.']" value="'.$field->field_label.'">
						<input type="hidden" name="field_type['.$field->field_id.']" value="image">
					</div>
				</div>
				<div class="field-row">
					<div class="label-col">Field Name</div>
					<div class="field-col"><input id="name-'.$field->field_id.'" type="text" name="field_name['.$field->field_id.']" value="'.$field->field_name.'"></div>
				</div>
				<div class="field-row">
					<div class="label-col">Multiple Files</div>
					<div class="field-col">
						<label><input type="radio" name="field_multiple['.$field->field_id.']" '.($field->multiple_files === 1? 'checked' : '').' value="1"> Yes</label>
						<label><input type="radio" name="field_multiple['.$field->field_id.']" '.($field->multiple_files === 0? 'checked' : '').' value="0"> No</label>
					</div>
				</div>
				<div class="field-row">
					<div class="label-col">Allowed Image Types</div>
					<div class="field-col"><label><input type="text" name="field_filetypes['.$field->field_id.']" value="*"></div>
				</div>
				<div class="field-row">
					<div class="label-col">Required</div>
					<div class="field-col">
						<label><input type="radio" name="field_required['.$field->field_id.']" '.($field->field_required === 1? 'checked' : '').' value="1"> Yes</label>
						<label><input type="radio" name="field_required['.$field->field_id.']" '.($field->field_required === 0? 'checked' : '').' value="0"> No</label>
					</div>
				</div>
			</div>
			';
		break;
		case 'select':
		$html .= '<div class="field-row">
			<div class="field-sort">
				<i class="far fa-sort"></i>
			</div>
				<div class="field-type-title">Dropdown</div>
				<div class="field-row-options">
					<a class="collapse-field-row" href="/" data-row-id="'.$field->field_id.'">
						<i class="fas fa-angle-down"></i></a> <a class="remove-field-row" data-row-id="'.$field->field_id.'" href="/">&times;</a>
				</div>
			</div>
		<div id="field-group-'.$field->field_id.'" class="field-group" data-row-id="'.$field->field_id.'">
			<div class="field-row">
				<div class="label-col">Field Label</div>
				<div class="field-col">
					<input id="label-'.$field->field_id.'" class="field-label" type="text" name="field_label['.$field->field_id.']" value="'.$field->field_label.'">
					<input type="hidden" name="field_type['.$field->field_id.']" value="select">
				</div>
			</div>
			<div class="field-row">
				<div class="label-col">Field Name</div>
				<div class="field-col"><input id="name-'.$field->field_id.'" type="text" name="field_name['.$field->field_id.']" value="'.$field->field_name.'"></div>
			</div>
			<div class="field-row">
				<div class="label-col">Options</div>
				<div class="field-col"><textarea name="field_options['.$field->field_id.']" placeholder="Label:value">'._explodeConfig($field->field_config, 'select').'</textarea><span class="notes">Enter each option setup on a new line. Example:<br>Label:value<br>Label:value</span></div>
			</div>
			<div class="field-row">
				<div class="label-col">Empty First Option?</div>
				<div class="field-col"><label>
					<input type="radio" name="field_firstoption['.$field->field_id.']" '.($field->empty_first_option === 1? 'checked' : '').' value="1"> Yes</label>
					<label><input type="radio" name="field_firstoption['.$field->field_id.']" '.($field->empty_first_option === 0? 'checked' : '').'  value="0"> No</label>
				</div>
			</div>
			<div class="field-row">
				<div class="label-col">Required</div>
				<div class="field-col">
					<label><input type="radio" name="field_required['.$field->field_id.']" '.($field->field_required === 1? 'checked' : '').' value="1"> Yes</label>
					<label><input type="radio" name="field_required['.$field->field_id.']" '.($field->field_required === 0? 'checked' : '').' value="0"> No</label>
				</div>
			</div>
		</div>';
		break;
		case 'checkbox':
		$html .= '<div class="field-row">
			<div class="field-sort">
				<i class="far fa-sort"></i>
			</div>
				<div class="field-type-title">Checkboxes</div>
				<div class="field-row-options">
					<a class="collapse-field-row" href="/" data-row-id="'.$field->field_id.'">
						<i class="fas fa-angle-down"></i></a> <a class="remove-field-row" data-row-id="'.$field->field_id.'" href="/">&times;</a>
				</div>
			</div>
		<div id="field-group-'.$field->field_id.'" class="field-group" data-row-id="'.$field->field_id.'">
			<div class="field-row">
				<div class="label-col">Field Label</div>
				<div class="field-col">
					<input id="label-'.$field->field_id.'" class="field-label" type="text" name="field_label['.$field->field_id.']" value="'.$field->field_label.'">
					<input type="hidden" name="field_type['.$field->field_id.']" value="checkbox">
				</div>
			</div>
			<div class="field-row">
				<div class="label-col">Field Name</div>
				<div class="field-col"><input id="name-'.$field->field_id.'" type="text" name="field_name['.$field->field_id.']" value="'.$field->field_name.'"></div>
			</div>
			<div class="field-row">
				<div class="label-col">Checkboxes</div>
				<div class="field-col"><textarea name="field_options['.$field->field_id.']" placeholder="Label:value">'._explodeConfig($field->field_config, 'checkbox').'</textarea><span class="notes">Enter each checkbox setup on a new line. Example:<br>Label:value<br>Label:value</span></div>
			</div>
			<div class="field-row">
				<div class="label-col">Required</div>
				<div class="field-col">
					<label><input type="radio" name="field_required['.$field->field_id.']" '.($field->field_required === 1? 'checked' : '').' value="1"> Yes</label>
					<label><input type="radio" name="field_required['.$field->field_id.']" '.($field->field_required === 0? 'checked' : '').' value="0"> No</label>
				</div>
			</div>
		</div>';
		break;
		case 'radio':
		$html .= '<div class="field-row">
			<div class="field-sort">
				<i class="far fa-sort"></i>
			</div>
				<div class="field-type-title">Radios</div>
				<div class="field-row-options">
					<a class="collapse-field-row" href="/" data-row-id="'.$field->field_id.'">
						<i class="fas fa-angle-down"></i></a> <a class="remove-field-row" data-row-id="'.$field->field_id.'" href="/">&times;</a>
				</div>
			</div>
		<div id="field-group-'.$field->field_id.'" class="field-group" data-row-id="'.$field->field_id.'">
			<div class="field-row">
				<div class="label-col">Field Label</div>
				<div class="field-col">
					<input id="label-'.$field->field_id.'" class="field-label" type="text" name="field_label['.$field->field_id.']" value="'.$field->field_label.'">
					<input type="hidden" name="field_type['.$field->field_id.']" value="radio">
				</div>
			</div>
			<div class="field-row">
				<div class="label-col">Field Name</div>
				<div class="field-col"><input id="name-'.$field->field_id.'" type="text" name="field_name['.$field->field_id.']" value="'.$field->field_name.'"></div>
			</div>
			<div class="field-row">
				<div class="label-col">Radios</div>
				<div class="field-col"><textarea name="field_options['.$field->field_id.']" placeholder="Label:value">'._explodeConfig($field->field_config, 'radio').'</textarea><span class="notes">Enter each radio setup on a new line. Example:<br>Label:value<br>Label:value</span></div>
			</div>
			<div class="field-row">
				<div class="label-col">Required</div>
				<div class="field-col">
					<label><input type="radio" name="field_required['.$field->field_id.']" '.($field->field_required === 1? 'checked' : '').' value="1"> Yes</label>
					<label><input type="radio" name="field_required['.$field->field_id.']" '.($field->field_required === 0? 'checked' : '').' value="0"> No</label>
				</div>
			</div>
		</div>';
		break;
		case 'editor':
		$html .= '<div class="field-row">
			<div class="field-sort">
				<i class="far fa-sort"></i>
			</div>
			<div class="field-type-title">Rich Text Editor</div>
			<div class="field-row-options">
				<a class="collapse-field-row" href="/" data-row-id="'.$field->field_id.'"><i class="fas fa-angle-down"></i></a>
				<a class="remove-field-row" data-row-id="'.$field->field_id.'" href="/">&times;</a>
			</div>
		</div>
		<div id="field-group-'.$field->field_id.'" class="field-group" data-row-id="'.$field->field_id.'">
			<div class="field-row">
				<div class="label-col">Field Label</div>
				<div class="field-col"><input id="label-'.$field->field_id.'" class="field-label" type="text" name="field_label['.$field->field_id.']" value="'.$field->field_label.'">
				<input type="hidden" name="field_type['.$field->field_id.']" value="editor">
			</div>
			</div>
			<div class="field-row">
				<div class="label-col">Field Name</div>
				<div class="field-col"><input id="name-'.$field->field_id.'" type="text" name="field_name['.$field->field_id.']" value="'.$field->field_name.'"></div>
			</div>';
		break;
		case 'repeater':
		$html .= '<div class="field-row">
			<div class="field-sort">
				<i class="far fa-sort"></i>
			</div>
			<div class="field-type-title">Repeater</div>
			<div class="field-row-options">
				<a class="collapse-field-row" href="/" data-row-id="'.$field->field_id.'"><i class="fas fa-angle-down"></i></a>
				<a class="remove-field-row" data-row-id="'.$field->field_id.'" data-row-id="'.$field->field_id.'" href="/">&times;</a>
			</div>
		</div>
		<div id="field-group-'.$field->field_id.'" class="field-group" data-row-id="'.$field->field_id.'">
			<div class="field-row">
				<div class="label-col">Field Label</div>
				<div class="field-col"><input id="label-'.$field->field_id.'" class="field-label" type="text" name="field_label['.$field->field_id.']" value="'.$field->field_label.'">
				<input type="hidden" name="field_type['.$field->field_id.']" value="repeater">
			</div>
			</div>
			<div class="field-row">
				<div class="label-col">Field Name</div>
				<div class="field-col"><input id="name-'.$field->field_id.'" type="text" name="field_name['.$field->field_id.']" value="'.$field->field_name.'"></div>
			</div>
			<div class="field-row">
				<div class="label-col full">Repeater Fields <div class="choose-repeater-fields">'._fieldsDropDown($field->field_id, $fields).'</div></div>
				<div class="field-col full has-repeater">
					<ul class="repeater-fields-list" id="repeater-fields'.$field->field_id.'">
					'._getRepeaterFields($field->field_id).'
					</ul>
				</div>
			</div>
			';
		break;
	}
	if( $repeater ){
		$html .= '<input type="hidden" name="field_repeater['.$field->field_id.']" value="'.$repeater.'" >';
	}
	$html .= '</div>';
	$html .= '</li>';
	return $html;
}



