<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml">
<?
require_once("realpath.php");
require_once("title.php");
echo "<head>
<link rel=\"StyleSheet\" href='".$_CONF['realpath']."/_css/screen.css' type=\"text/css\" />
<link rel=\"StyleSheet\" href='".$_CONF['realpath']."/_css/cmxform.css' type=\"text/css\" />
<link rel=\"StyleSheet\" href='".$_CONF['realpath']."/_javascript/fancybox/jquery.fancybox-1.3.4.css' type=\"text/css\" />
 
<link rel=\"stylesheet\" type=\"text/css\" href='".$_CONF['realpath']."/_javascript/jscalendar1.7/src/css/jscal2.css' />
<link rel=\"stylesheet\" type=\"text/css\" href='".$_CONF['realpath']."/_javascript/jscalendar1.7/src/css/border-radius.css' />
<link rel=\"stylesheet\" type=\"text/css\" href='".$_CONF['realpath']."/_javascript/jscalendar1.7/src/css/steel/steel.css' />
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=ISO-8859-1\" />
<title>".$_CONF['title']."</title>\n";

echo "<script src='".$_CONF['realpath']."/_javascript/GridComponent.js' type='text/javascript'></script>\n";

echo "<script src='".$_CONF['realpath']."/_javascript/Main.js' type='text/javascript'></script>\n";
echo "<script src='".$_CONF['realpath']."/_javascript/Default.js' type='text/javascript'></script>\n";
echo "<script src='".$_CONF['realpath']."/_javascript/dom.js' type='text/javascript'></script>\n";
echo "<script src='".$_CONF['realpath']."/_javascript/domnavigation.js' type='text/javascript'></script>\n";
?>
<link rel="stylesheet"	href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />

<script src="<?=$_CONF['realpath']?>/_javascript/jQuery.js" type="text/javascript"></script>
<script src="<?=$_CONF['realpath']?>/_javascript/jquery-ui-1.10.3.js" type="text/javascript"></script>
<? 


echo "<script src='".$_CONF['realpath']."/_javascript/jquery_validate.js' type='text/javascript'></script>\n";
echo "<script src='".$_CONF['realpath']."/_javascript/meio.mask.jquery.js' type='text/javascript'></script>\n";
echo "<script src='".$_CONF['realpath']."/_javascript/mask-validator-jquery.js' type='text/javascript'></script>\n";
echo "<script src='".$_CONF['realpath']."/_javascript/fancybox/jquery.mousewheel-3.0.4.pack.js' type='text/javascript'></script>\n";
echo "<script src='".$_CONF['realpath']."/_javascript/fancybox/jquery.fancybox-1.3.4.pack.js' type='text/javascript'></script>\n";

echo "<script src='".$_CONF['realpath']."/_javascript/jscalendar1.7/src/js/jscal2.js' type='text/javascript'></script>\n";
echo "<script src='".$_CONF['realpath']."/_javascript/jscalendar1.7/src/js/lang/pt.js' type='text/javascript'></script>\n";

echo "<link rel='StyleSheet' href='".$_CONF['realpath']."/_javascript/kendoui/css/kendo.common.min.css' type='text/css' />";
echo "<link rel='StyleSheet' href='".$_CONF['realpath']."/_javascript/kendoui/css/kendo.default.min.css' type='text/css' />";
echo "<script src='".$_CONF['realpath']."/_javascript/kendoui/js/kendo.web.min.js' type='text/javascript'></script>\n";


echo "<script src='".$_CONF['realpath']."/_javascript/colorbox/example1/colorbox.css' type='text/javascript'></script>\n";
echo "<script src='".$_CONF['realpath']."/_javascript/colorbox/colorbox/jquery.colorbox.js' type='text/javascript'></script>\n";
?>
