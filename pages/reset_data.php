<span style="margin: 15px 0;width: 650px" class="compatCheck compatwarning">
	Deleting ClickFunnels Pages &amp; API Settings...
	<strong><i class="fa fa-spinner fa-spin"></i> Please wait just a moment.</strong>
</span>
<div id="progress" style="width:670px;margin-bottom: 10px;height: 10px;border-bottom:4px solid #D04738;background: #E54F3F;"></div>
<?php echo 'Deleting <strong>'.wp_count_posts( 'leadmonster' )->publish.'</strong> pages...'; ?>
<div id="information" style="width"></div>
<?php

    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

	$args = array(
		'posts_per_page' => -1,
		'post_type' =>'leadmonster'
	);
	$posts = get_posts( $args );
	$total = wp_count_posts( 'leadmonster' )->publish;
	$current = 0;
	if (is_array($posts)) {
	   foreach ($posts as $post) {
	      wp_delete_post( $post->ID, true);
	      $i += 1;
	      $percent = intval($i/$total * 100)."%";
		    echo '<script language="javascript">
		    document.getElementById("progress").innerHTML="<div style=\"width:'.$percent.';background-color:#1C69A9;border-bottom: 4px solid #135184;height: 10px\">&nbsp;</div>";
		    document.getElementById("information").innerHTML="<strong>'.$i.'</strong> pages(s) deleted.";
		    </script>';
		    echo str_repeat(' ',1024*64);
		    flush();
		    sleep(1);
	   }
	}
	echo '<script language="javascript">document.getElementById("information").innerHTML="<strong>Success</strong> all ClickFunnels pages removed..."</script>';
	flush();
	sleep(1);
	echo 'Removed Plugin Settings...';

	delete_option('leadmonster_api_email');
	delete_option('leadmonster_api_auth');
	delete_option('leadmonster_display_method');
	delete_option('leadmonster_favicon_method');

	echo '<br />Redirecting to Plugins Page...';
	echo '<script language="javascript">setTimeout(function(){window.location = "edit.php?post_type=leadmonster&page=cf_api";}, 1800);</script>';
?>
