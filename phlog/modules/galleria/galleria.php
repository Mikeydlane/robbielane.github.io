<?php

    class Galleria extends Modules {
        public function __init() {
           $this->addAlias("markup_text", "checkgal");
           $this->addAlias("markup_post_text","checkgal");
           $this->addAlias("preview", "checkgal");
           $this->addAlias("preview_post", "checkgal");
        }
        public function checkgal($text) {
        	$start_tag = "[galleria]";
			$end_tag = "[/galleria]";
			$re_start_tag = preg_quote($start_tag, '#');
			$re_end_tag = preg_quote($end_tag, '#');
			$images = preg_replace("#\s*.*$re_start_tag(.*?)$re_end_tag.*\s*#s", '$1', $text);
        	$imagearray=explode(',', $images);
        	$text=preg_replace("#\s*.*$re_start_tag(.*?)$re_end_tag.*\s*#s",'galleriaimage',$text);
        	$div='<div id="galgallery">';
            foreach($imagearray as $src){
                $div.= '<img src="'.$src.'">';
            }
			$div.='</div><script>Galleria.loadTheme(\'modules/galleria/themes/classic/galleria.classic.min.js\');$("#galgallery").galleria({
        width: 500,
        height: 500
    });</script>';
        	$text=str_replace('galleriaimage',$div,$text);
        	return $text;
        }
        static function scripts($scripts) {
            $scripts[] = Config::current()->chyrp_url."/modules/galleria/javascript.php";
            return $scripts;
        }
    }
