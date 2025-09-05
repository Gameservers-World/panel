<?php
/*
 * Core application functionality
 */

#	Open Game Panel refreshed Class
#	Wrote by: Nirock
#	Sample Setup:
/*
	// Using the refreshed class
	require_once("includes/refreshed.php");
	$refresh = new refreshed();
	$pos = $refresh->add("home.php?m=gamemanager&p=log2&type=pop&home_id=5",5000);
	echo $refresh->getdiv($pos,"height:500px;overflow : auto;");
	//Build: 
	?><script type="text/javascript">$(document).ready(function(){ <?php echo $refresh->build(); ?>} ); </script><?php
*/

class refreshed
{
	private $url;
	private $pos;
	
	public function __construct()
	{
		$this->url = array();
		$this->pos = 0;
	}
	
	public function add($url)
	{
		$this->url[$this->pos] = $url;
		$this->pos++;
		return $this->pos-1;
	}
	
	public function getdiv($pos,$style = "")
	{
		return "<div id='refreshed-".$pos."' style='".$style."'></div>"; 
	}
	
	public function build($time = "4000")
	{
		if($_GET['m'] == 'gamemanager' and $_GET['p'] == 'game_monitor')
		{
			$switch = "";
			for($i=0;$i<$this->pos;$i++)
			{
				$load = "$('#refreshed-$i').load('".$this->url[$i]."');\n";
				$refresh = "window.refreshId$i = setInterval(function() {\n".
								$load.
							"}, $time);\n";
				$stopRefresh = "clearInterval(window.refreshId$i);\n";
				if(isset($_GET['home_id']) or isset($_GET['home_id-mod_id-ip-port']))
				{
					$start_expanded = $load.$refresh;
					$isUndefined = " || typeof collapsible === 'undefined'";
				}
				else
				{
					$start_expanded = "";
					$isUndefined = " && typeof collapsible !== 'undefined'";
				}
				$switch .= "if( pos == $i && status == 'online' )\n{\n".
								"if(collapsible.match('expanded')$isUndefined){\n".
									$stopRefresh.
								"}\nelse\n{\n".
									$load.
									$refresh.
								"}\n".
							"}\n";
			}
			return	"$.ajaxSetup({ cache: false });\n".
					$start_expanded.
					"$('.collapsible').click(function(){\n".
						"var collapsible = $(this).attr('class');\n".
						"var pos = $(this).attr('data-pos');\n".
						"var status = $(this).attr('data-status');\n".
						$switch.
					"});\n";
			
		}
		else
		{
			$first = "";
			$second = "";
			
			for($i=0;$i<$this->pos;$i++)
			{
				$ref = '#refreshed-'.$i;
				$first .= "\n".
						  "\tjQuery.ajax({\n".
						  "\t	url: \"".$this->url[$i]."\",\n".
						  "\t	cache: false,\n".
						  "\t	beforeSend: function(xhr) {\n".
						  "\t		$('a').click(function() {\n".
						  "\t	  		xhr.abort();\n".
						  "\t	  		enableCallbacks = false;\n".
						  "\t		});\n".
						  "\t	},\n".
						  "\t	success: function(data, textStatus) {\n".
						  "\t		if (!enableCallbacks) return;\n".
						  "\t		$('".$ref."').html(data);\n";
				
				if($_GET['m'] == 'status' || $_GET['m'] == 'dashboard'){
					$first .= "\t		animateProgressBars();\n";
				}
				
				if($_GET['m'] == 'gamemanager' and $_GET['p'] == 'log')
				{
					$first .= "\t		$('".$ref."').animate({ scrollTop: $('".$ref."').prop('scrollHeight')*3}, 3000);\n";
				}
				$first .= "\t	}\n".
						  "\t});\n";
						
				$second .= "\n".
						   "\t\tjQuery.ajax({\n".
						   "\t\t	url: \"".$this->url[$i]."\",\n".
						   "\t\t	cache: false,\n".
						   "\t\t	beforeSend: function(xhr) {\n".
						   "\t\t		$('a').click(function() {\n".
						   "\t\t	  		xhr.abort();\n".
						   "\t\t	  		enableCallbacks = false;\n".
						   "\t\t		});\n".
						   "\t\t	},\n".
						   "\t\t	success: function(data, textStatus) {\n".
						   "\t\t		if (!enableCallbacks) return;\n".
						   "\t\t		$('".$ref."').html(data);\n";
				if($_GET['m'] == 'gamemanager' and $_GET['p'] == 'log')
				{
					$second .= "\t\t		$('".$ref."').animate({ scrollTop: 9999});\n";
				}
				
				if($_GET['m'] == 'status' || $_GET['m'] == 'dashboard'){
					$second .= "\t\t		animateProgressBars();\n";
				}
				
				$second .= "\t\t	}\n".
						   "\t\t});\n";
			}

			return "var enableCallbacks = true;".
				   $first.
				   "\n\tvar refreshId = setInterval(function() {".
				   $second.
				   "\n\t}, $time);\n".
				   "\t$('a').click(function() {\n".
				   "\t	clearInterval(refreshId);\n".
				   "\t});\n";

		}
	}
}
?>
