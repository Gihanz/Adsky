<?php
    /*
     *      Osclass – software for creating and publishing online classified
     *                           advertising platforms
     *
     *                        Copyright (C) 2014 OSCLASS
     *
     *       This program is free software: you can redistribute it and/or
     *     modify it under the terms of the GNU Affero General Public License
     *     as published by the Free Software Foundation, either version 3 of
     *            the License, or (at your option) any later version.
     *
     *     This program is distributed in the hope that it will be useful, but
     *         WITHOUT ANY WARRANTY; without even the implied warranty of
     *        MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
     *             GNU Affero General Public License for more details.
     *
     *      You should have received a copy of the GNU Affero General Public
     * License along with this program.  If not, see <http://www.gnu.org/licenses/>.
     */

    // meta tag robots
    if( osc_item_is_spam() || osc_premium_is_spam() ) {
        osc_add_hook('header','osclasswizards_nofollow_construct');
    } else {
        osc_add_hook('header','osclasswizards_follow_construct');
    }

    osclasswizards_add_body_class('item');
		
	if(osclasswizards_show_as() == 'gallery'){
        $loop_template	=	'loop-search-grid.php';
		$buttonClass = 'active';
    }else{
		$loop_template	=	'loop-search-list.php';
		$buttonClass = '';
	}
	
    function sidebar(){
        osc_current_web_theme_path('item-sidebar.php');
    }

    $location = array();
    if( osc_item_city_area() !== '' ) {
        $location[] = osc_item_city_area();
    }
    if( osc_item_city() !== '' ) {
        $location[] = osc_item_city();
    }
    if( osc_item_region() !== '' ) {
        $location[] = osc_item_region();
    }
    if( osc_item_country() !== '' ) {
        $location[] = osc_item_country();
    }
	
    osc_current_web_theme_path('header.php');
	
?>

<div class="row">
  <div class="col-lg-8 col-md-7">
    <div id="item-content">
      <?php if(osc_is_web_user_logged_in() && osc_logged_user_id()==osc_item_user_id()) { ?>
      <p id="edit_item_view"> <strong> <a href="<?php echo osc_item_edit_url(); ?>" rel="nofollow">
        <?php _e('Edit item', OSCLASSWIZARDS_THEME_FOLDER); ?>
        </a> </strong> </p>
      <?php } ?>
      <h1 class="title title_code"> <strong><?php echo osc_item_title(); ?></strong> </h1>
      <ul class="item-header">
        <li>
          <?php if( osc_price_enabled_at_items() ) { ?>
          <i class="far fa-money-bill-alt"></i><?php echo osc_item_formated_price(); ?>
          <?php } ?>
        </li>
        <li>
          <?php if ( osc_item_pub_date() !== '' ) { printf( __('<i class="far fa-calendar"></i> Published date: %1$s', OSCLASSWIZARDS_THEME_FOLDER), osc_format_date( osc_item_pub_date() ) ); } ?>
        </li>
        <li>
          <?php if ( osc_item_mod_date() !== '' ) { printf( __('<span class="update"><i class="far fa-calendar-alt"></i> Modified date:</span> %1$s', OSCLASSWIZARDS_THEME_FOLDER), osc_format_date( osc_item_mod_date() ) ); } ?>
        </li>
        <?php if (count($location)>0) { ?>
        <li>
          <ul id="item_location">
            <li><i class="fas fa-map-marker"></i> <?php echo implode(', ', $location); ?></li>
          </ul>
        </li>
        <?php }; ?>
      </ul>
      <?php if( osc_images_enabled_at_items() ) { ?>
      <div class="item-photos">
        <div class="row">
          <?php
        if( osc_count_item_resources() > 0 ) {
            $i = 0;
        ?>
          <div class="col-lg-10"> <a href="<?php echo osc_resource_url(); ?>" class="main-photo" title="<?php echo osc_esc_html(__('Image', OSCLASSWIZARDS_THEME_FOLDER)); ?> <?php echo $i+1;?> / <?php echo osc_count_item_resources();?>"> <img class="img-responsive" src="<?php echo osc_resource_url(); ?>" alt="<?php echo osc_item_title(); ?>" title="<?php echo osc_item_title(); ?>" /> </a></div>
          <div class="col-lg-2">
            <div class="thumbs">
              <?php for ( $i = 0; osc_has_item_resources(); $i++ ) { ?>
                <div class="thumbs-image">
                    <a href="<?php echo osc_resource_url(); ?>" class="fancybox" data-fancybox-group="group" title="<?php echo osc_esc_html(__('Image', OSCLASSWIZARDS_THEME_FOLDER)); ?> <?php echo $i+1;?> / <?php echo osc_count_item_resources();?>"> <img src="<?php echo osc_resource_thumbnail_url(); ?>" width="75" alt="<?php echo osc_item_title(); ?>" title="<?php echo osc_item_title(); ?>" class="img-responsive"/> </a>
                  </div>
              <?php } ?>
            </div>
          </div>
          <?php } else{?>
          <div class="col-lg-10"> <a href="<?php echo osc_current_web_theme_url('images/no_photo.gif'); ?>" class="main-photo" title="<?php echo osc_esc_html(__('Image', OSCLASSWIZARDS_THEME_FOLDER)); ?> 1 / 1"> <img class="img-responsive" src="<?php echo osc_current_web_theme_url('images/no_photo.gif'); ?>" alt="<?php echo osc_item_title(); ?>" title="<?php echo osc_item_title(); ?>" /> </a></div>
          <div class="col-lg-2">
            <div class="thumbs"> <a href="<?php echo osc_current_web_theme_url('images/no_photo.gif'); ?>" class="fancybox" data-fancybox-group="group" title="<?php echo osc_esc_html(__('Image', OSCLASSWIZARDS_THEME_FOLDER)); ?> 1 / 1"> <img src="<?php echo osc_current_web_theme_url('images/no_photo.gif'); ?>" width="75" alt="<?php echo osc_item_title(); ?>" title="<?php echo osc_item_title(); ?>" class="img-responsive"/> </a> </div>
          </div>
          <?php } ?>
        </div>
      </div>
      <?php } ?>
      <div id="description">
	  <h1 style="padding-bottom: 15px;">Description</h1>
        <p><?php echo osc_item_description(); ?></p>
        <div id="custom_fields">
          <?php if( osc_count_item_meta() >= 1 ) { ?>
          <br />
          <div class="meta_list">
            <?php while ( osc_has_item_meta() ) { ?>
            <?php if(osc_item_meta_value()!='') { ?>
            <div class="meta"> <strong><?php echo osc_item_meta_name(); ?> &nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;&nbsp;<?php echo osc_item_meta_value(); ?> </strong></div>
            <?php } ?>
            <?php } ?>
          </div>
          <?php } ?>
        </div>
        
        <ul class="contact_button">
          <li>
            <?php if( !osc_item_is_expired () ) { ?>
            <?php if( !( ( osc_logged_user_id() == osc_item_user_id() ) && osc_logged_user_id() != 0 ) ) { ?>
            <?php     if(osc_reg_user_can_contact() && osc_is_web_user_logged_in() || !osc_reg_user_can_contact() ) { ?>
            <a href="#contact" class="start_chat">
            <?php _e('Chat with seller', OSCLASSWIZARDS_THEME_FOLDER); ?>
            </a>
            <?php     } ?>
            <?php     } ?>
            <?php } ?>
          </li>
          <li><a href="<?php echo osc_item_send_friend_url(); ?>" rel="nofollow">
            <?php _e('Share', OSCLASSWIZARDS_THEME_FOLDER); ?>
            </a></li>
          <?php if(function_exists('watchlist')) {?>
          <li>
            <?php watchlist(); ?>
          </li>
          <?php } ?>
          <li><a class="see_all" href="<?php echo osc_user_public_profile_url( osc_item_user_id() ); ?>">
            <?php _e('See all ads from this advertiser', OSCLASSWIZARDS_THEME_FOLDER); ?>
            </a> </li>
        </ul>
        
      </div>
    </div>
    <div class="block_list">
      <div id="useful_info">
        <h1 class="title">
          <?php _e('Useful information', OSCLASSWIZARDS_THEME_FOLDER); ?>
        </h1>
        <ul>
          <li>
            <?php _e('Avoid scams by acting locally or paying with PayPal', OSCLASSWIZARDS_THEME_FOLDER); ?>
          </li>
          <li>
            <?php _e('Never pay with Western Union, Moneygram or other anonymous payment services', OSCLASSWIZARDS_THEME_FOLDER); ?>
          </li>
          <li>
            <?php _e('Don\'t buy or sell outside of your country. Don\'t accept cashier cheques from outside your country', OSCLASSWIZARDS_THEME_FOLDER); ?>
          </li>
          <li>
            <?php _e('This site is never involved in any transaction, and does not handle payments, shipping, guarantee transactions, provide escrow services, or offer "buyer protection" or "seller certification"', OSCLASSWIZARDS_THEME_FOLDER); ?>
          </li>
        </ul>
      </div>
    </div>
    <?php if( osc_comments_enabled() ) { ?>
    <?php if( osc_reg_user_post_comments () && osc_is_web_user_logged_in() || !osc_reg_user_post_comments() ) { ?>
    <div id="comments">
      <?php if( osc_count_item_comments() >= 1 ) { ?>
      <h2 class="title">
        <?php _e('Comments', OSCLASSWIZARDS_THEME_FOLDER); ?>
      </h2>
      <?php }
	  
	  ?>
      <ul id="comment_error_list">
      </ul>
      <?php CommentForm::js_validation(); ?>
      <?php if( osc_count_item_comments() >= 1 ) { ?>
      <div class="comments_list">
        <?php while ( osc_has_item_comments() ) { ?>
        <div class="comment">
          <h4><?php echo osc_comment_title(); ?> <em>
            <?php _e("by", OSCLASSWIZARDS_THEME_FOLDER); ?>
            <?php echo osc_comment_author_name(); ?>:</em></h4>
          <p><?php echo nl2br( osc_comment_body() ); ?> </p>
          <?php if ( osc_comment_user_id() && (osc_comment_user_id() == osc_logged_user_id()) ) { ?>
          <p> <a rel="nofollow" href="<?php echo osc_delete_comment_url(); ?>" title="<?php echo osc_esc_html(__('Delete your comment', OSCLASSWIZARDS_THEME_FOLDER)); ?>">
            <?php _e('Delete', OSCLASSWIZARDS_THEME_FOLDER); ?>
            </a> </p>
          <?php } ?>
        </div>
        <?php } ?>
        <div class="pagination"> <?php echo osc_comments_pagination(); ?> </div>
      </div>
      <?php } ?>
    </div>
    <?php } ?>
    <?php } ?>
  </div>
  <div class="col-lg-4 col-md-5">
    <?php
		if(function_exists('show_qrcode')){
			echo '<div class="block_list block_listed">';
			show_qrcode();
			echo ' </div>';

		}
	?>
    <div class="alert_block">
      <?php if(!osc_is_web_user_logged_in() || osc_logged_user_id()!=osc_item_user_id()) { ?>
      <form action="<?php echo osc_base_url(true); ?>" method="post" name="mask_as_form" id="mask_as_form">
        <input type="hidden" name="id" value="<?php echo osc_item_id(); ?>" />
        <input type="hidden" name="as" value="spam" />
        <input type="hidden" name="action" value="mark" />
        <input type="hidden" name="page" value="item" />
        <select name="as" id="as" class="mark_as">
          <option>
          <?php _e("Mark as...", OSCLASSWIZARDS_THEME_FOLDER); ?>
          </option>
          <option value="spam">
          <?php _e("Mark as spam", OSCLASSWIZARDS_THEME_FOLDER); ?>
          </option>
          <option value="badcat">
          <?php _e("Mark as misclassified", OSCLASSWIZARDS_THEME_FOLDER); ?>
          </option>
          <option value="repeated">
          <?php _e("Mark as duplicated", OSCLASSWIZARDS_THEME_FOLDER); ?>
          </option>
          <option value="expired">
          <?php _e("Mark as expired", OSCLASSWIZARDS_THEME_FOLDER); ?>
          </option>
          <option value="offensive">
          <?php _e("Mark as offensive", OSCLASSWIZARDS_THEME_FOLDER); ?>
          </option>
        </select>
      </form>
      <?php } ?>
    </div>
	<?php osc_run_hook('item_detail', osc_item() ); ?>
    <?php osc_run_hook('location'); ?>
  </div>
</div>
<?php related_listings(); ?>
<?php if( osc_count_items() > 0 ) { ?>
<div class="similar_ads">
  <h2 class="title">
    <?php _e('Related listings', OSCLASSWIZARDS_THEME_FOLDER); ?>
  </h2>
  <?php
		View::newInstance()->_exportVariableToView("listType", 'items');
		osc_current_web_theme_path($loop_template);
    ?>
</div>
<?php } ?>
<?php osc_current_web_theme_path('footer.php') ; ?>
<div id="user_model_details"></div>

<script>
	function make_chat_dialog_box(to_user_id, from_user_id)
	{
		var modal_content = '<div id="user_dialog_'+to_user_id+'" class="user_dialog" title="You have chat with seller">';
		modal_content += '<div style="height:400px; border:1px solid #ccc; overflow-y: scroll; margin-bottom:24px; padding:16px;" class="chat_history" data-touserid="'+to_user_id+'" id="chat_history_'+to_user_id+'">';
		modal_content += fetch_user_chat_history(to_user_id, from_user_id);
		modal_content += '</div>';
		modal_content += '<div class="form-group">';
		modal_content += '<textarea name="chat_message_'+to_user_id+'" id="chat_message_'+to_user_id+'" class="form-control chat_message"></textarea>';
		modal_content += '</div><div class="form-group" align="right">';
		modal_content+= '<button type="button" name="send_chat" id="'+to_user_id+'" class="btn btn-info send_chat">Send</button></div></div>';
		$('#user_model_details').html(modal_content);
	}

	$(document).on('click', '.start_chat', function(){

		<?php if(osc_logged_user_id() != 0) { ?>
			var to_user_id = <?php echo osc_item_user_id()?>;
			var from_user_id = <?php echo osc_logged_user_id()?>;
			make_chat_dialog_box(to_user_id, from_user_id);
			$("#user_dialog_"+to_user_id).dialog({
				autoOpen:false,
				width:400
			});
			$('#user_dialog_'+to_user_id).dialog('open');
			$('#chat_message_'+to_user_id).emojioneArea({
				pickerPosition:"top",
				toneStyle: "bullet"
			});
		<?php     } else {?>
			location.href = '<?php echo osc_user_login_url(); ?>';
		<?php     } ?>
	});
	
	$(document).on('click', '.send_chat', function(){
		var to_user_id = $(this).attr('id');
		var chat_message = $.trim($('#chat_message_'+to_user_id).val());
		if(chat_message != '')
		{
			$.ajax({
				url:"oc-chat/insert_chat.php",
				method:"POST",
				data:{to_user_id:to_user_id, from_user_id:<?php echo osc_logged_user_id()?>, chat_message:chat_message},
				success:function(data)
				{
					var element = $('#chat_message_'+to_user_id).emojioneArea();
					element[0].emojioneArea.setText('');
					$('#chat_history_'+to_user_id).html(data);
				}
			})
		}
		else
		{
			alert('Type something');
		}
	});

	function fetch_user_chat_history(to_user_id, from_user_id)
	{
		$.ajax({
			url:"oc-chat/fetch_user_chat_history.php",
			method:"POST",
			data:{to_user_id:to_user_id, from_user_id:from_user_id},
			success:function(data){
				$('#chat_history_'+to_user_id).html(data);
			}
		})
	}

	function update_chat_history_data()
	{
		$('.chat_history').each(function(){
			var to_user_id = $(this).data('touserid');
			var from_user_id = <?php echo osc_logged_user_id()?>;
			fetch_user_chat_history(to_user_id, from_user_id);
		});
	}
	
	function update_last_activity()
	{
		$.ajax({
			url:"oc-chat/update_last_activity.php",
			success:function()
			{
			}
		})
	}
	
	$(document).ready(function(){

		setInterval(function(){
			update_last_activity();
			update_chat_history_data();
		}, 5000);
	});

	$(document).on('click', '.ui-button-icon', function(){
		$('.user_dialog').dialog('destroy').remove();
		$('#is_active_group_chat_window').val('no');
	});

	$(document).on('focus', '.chat_message', function(){
		var is_type = 'yes';
		$.ajax({
			url:"oc-chat/update_is_type_status.php",
			method:"POST",
			data:{is_type:is_type},
			success:function()
			{

			}
		})
	});

	$(document).on('blur', '.chat_message', function(){
		var is_type = 'no';
		$.ajax({
			url:"oc-chat/update_is_type_status.php",
			method:"POST",
			data:{is_type:is_type},
			success:function()
			{
				
			}
		})
	});
	
	$(document).on('click', '.remove_chat', function(){
		var chat_message_id = $(this).attr('id');
		if(confirm("Are you sure you want to remove this chat?"))
		{
			$.ajax({
				url:"oc-chat/remove_chat.php",
				method:"POST",
				data:{chat_message_id:chat_message_id},
				success:function(data)
				{
					update_chat_history_data();
				}
			})
		}
	});
</script>
