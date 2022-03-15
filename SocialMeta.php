<?php

class SocialMeta {
    /* ------------------------------------------------ *\
            Private
    \* ------------------------------------------------ */
    // ___ VAR ___

    private $fileParam;

    private $commonParam = [
            "url" => null,
            "title" => null,
            "description" => null
    ];

    private $SocialImages = [
        "google_img" => null,
        "og_img" => null,
        "twitter_img" => null
    ];

    private $othersParams = [
        "og_type" => "website",
        "twitter_card" => "summary_large_image"
    ];

    // ___ FUNCTION ___

    private function remote_file_exists($url) {
        ini_set('allow_url_fopen', '1');
        try {
            @fclose(@fopen($url, 'r'));
            $exists =  true;
        } catch (\Throwable $th) {
            $exists =  false;
        }
        return $exists;
    }

    private function fileFind($url) {
        if (preg_match("/^https?:\/\/.*(\..*)/i", $url)) {
            if ($this->remote_file_exists($url)) {
                return $url;
            }else {
                return false;
            }
        } else {
            $path = $this->fileParam["img_folder_parent"]."socialMeta_img/".$url;
            
            if (file_exists($path)) {
                return $path;
            }else {
                return false;
            }
        }
    }


    /* ------------------------------------------------ *\
            Public
    \* ------------------------------------------------ */
    // ___ VAR ___

    /**
     * none
     */

    // ___ FUNCTION ___

    public static function install(){
        
        $fileParam = [
            "img_folder_parent" => "",
            "img_param" => [
                "img_format_ignore" => false,
                "default_img" => ""
            ]
        ];

        if (!file_exists("socialMeta_param.json")) {
            file_put_contents("socialMeta_param.json", json_encode($fileParam));
        }
    }

    public function __construct(string $url, string $title, string $description) {
        
        if(file_exists("socialMeta.json")) {
            $this->fileParam = json_decode(file_get_contents("socialMeta_param.json"), 1);
        } else {
            throw new Exception("You have to install the json file with SocialMeta::install() and edit the json file", 1);
        }   
        
        // Verify if the images folder parent exists
        $ifp = $this->fileParam["img_folder_parent"];
        $ifp_given = (empty($ifp)) ? throw new Exception("You have to set the images folder parent on line 10", 1) : true;
        
        if ($ifp_given && file_exists($ifp)) {
            if (!file_exists($ifp."socialMeta_img")) {
                mkdir($ifp."socialMeta_img");
            }
        } else {
            throw new Exception($ifp." doesn't exists", 1);  
        }

        // init attributs
        $this->commonParam = [
            "url" => $url,
            "title" => $title,
            "description" => $description
        ];

        // check if there is a default image
        if (!file_exists($this->fileParam["img_folder_parent"]."socialMeta_img/".$this->fileParam["img_param"]["default_img"])) {
            throw new Exception("Default image required", 1);
            
        }

    }

    /**
     * Setter
     */

    public function setGoogleImg (string $url){
        $file = $this->fileFind($url);
        if ($file) {
            $this->SocialImages["google_img"] = $file;
            return true;
        } else {
            throw new Exception("No file find", 1);
        }
    }

    public function setOgImg (string $url){
        $file = $this->fileFind($url);
        if ($file) {
            $this->SocialImages["og_img"] = $file;
            return true;
        } else {
            throw new Exception("No file find", 1);
        }
    }

    public function setTwitterImg (string $url){
        $file = $this->fileFind($url);
        if ($file) {
            $this->SocialImages["twitter_img"] = $file;
            return true;
        } else {
            throw new Exception("No file find", 1);
        }
    }
    
    public function setSameImg (string $url) {
        $file = $this->fileFind($url);
        if ($file) {
            $this->SocialImages["google_img"] = $file;
            $this->SocialImages["og_img"] = $file;
            $this->SocialImages["twitter_img"] = $file;
            return true;
        } else {
            throw new Exception("No file find", 1);
        }
    }

    public function setOgType (string $type){
        return !empty($type) ? $this->othersParams["og_type"] = $type : false ;
    }

    public function setTwitterCard (string $card){
        return !empty($card) ? $this->othersParams["twitter_card"] = $card : false ;
    }

    /**
     * Getter
     */

    public function print() {
        $url = $this->commonParam['url'];
        $title = $this->commonParam['title'];
        $description = $this->commonParam['description'];

        /** 
         * define default value
         */

        // Social images
        $img = $this->SocialImages;
        foreach ($img as $key => $value) {
            //var_dump($key." => ".$value);
            if(is_null($img[$key])) {
                $this->SocialImages[$key] = $this->fileParam["img_folder_parent"]."socialMeta_img/".$this->fileParam["img_param"]["default_img"];
            }
        }


        $print = "\t"."<!-- Google+ -->"."\n";
	    $print .= "\t"."<meta itemprop='name'             content='".$title."'>"."\n";
	    $print .= "\t"."<meta itemprop='description'      content='".$description."'>"."\n";
	    
        $print .= "\t"."<meta itemprop='image'            content='".$this->SocialImages["google_img"]."'>"."\n";

	    $print .= "\t"."<!-- Facebook -->"."\n";
        $print .= "\t"."<meta property='og:title'         content='".$title."' />"."\n";
	    $print .= "\t"."<meta property='og:url'           content='".$url."' />"."\n";
        $print .= "\t"."<meta property='og:description'   content='".$description."' />"."\n";

        $print .= "\t"."<meta property='og:image'         content='".$this->SocialImages["og_img"]."'>"."\n";

        $print .= "\t"."<meta property='og:type'          content='".$this->othersParams["og_type"]."' />"."\n";

        $print .= "\t"."<!-- Twitter -->"."\n";
        $print .= "\t"."<meta name='twitter:title'        content='".$title."'>"."\n";
        $print .= "\t"."<meta name='twitter:url'          content='".$url."' />"."\n";
        $print .= "\t"."<meta name='twitter:description'  content='".$description."'>"."\n";

        $print .= "\t"."<meta name='twitter:image'        content='".$this->SocialImages["twitter_img"]."'>"."\n";

        $print .= "\t"."<meta name='twitter:card'         content='".$this->othersParams["twitter_card"]."'>"."\n";
        
        echo $print;
    }
    
}



?>