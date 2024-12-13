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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="<?php echo str_replace('_', '-', osc_current_user_locale()); ?>">
<head>
<?php osc_current_web_theme_path('common/head.php') ; ?>
	<link rel="stylesheet" href="oc-chat/css/jquery-ui-1.12.1/jquery-ui.css">
	<link rel="stylesheet" href="oc-chat/css/emojionearea.min.css">
	<link rel="stylesheet" href="oc-chat/css/chat-box.css">
  	<script src="oc-chat/js/jquery-ui.js"></script>
	<script src="oc-chat/js/emojionearea.min.js"></script>
	<script src="oc-chat/js/jquery.form.js"></script>
</head>

<body <?php osclasswizards_body_class(); ?>>
<header id="header">
  <div class="top_links">
    <div class="container">
      <div class="language">
        <?php ?>
        <?php if ( osc_count_web_enabled_locales() > 1) { ?>
        <?php osc_goto_first_locale(); ?>
        <strong>
        <?php _e('Language:', OSCLASSWIZARDS_THEME_FOLDER); ?>
        </strong> <span>
        <?php $local = osc_get_current_user_locale(); echo $local['s_name']; ?>
        <i class="fas fa-caret-down"></i></span>
        <ul>
          <?php $i = 0;  ?>
          <?php while ( osc_has_web_enabled_locales() ) { ?>
          <li><a <?php if(osc_locale_code() == osc_current_user_locale() ) echo "class=active"; ?> id="<?php echo osc_locale_code(); ?>" href="<?php echo osc_change_language_url ( osc_locale_code() ); ?>"><?php echo osc_locale_name(); ?></a></li>
          <?php if( $i == 0 ) { echo ""; } ?>
          <?php $i++; ?>
          <?php } ?>
        </ul>
        <?php } ?>
      </div>
      <?php if(osclasswizards_welcome_message()){ ?>
      <p class="welcome-message"><?php echo osclasswizards_welcome_message(); ?></p>
      <?php } ?>
      <ul>
        <?php if( osc_is_static_page() || osc_is_contact_page() ){ ?>
        <li class="search"><a class="ico-search icons" data-bclass-toggle="display-search"></a></li>
        <li class="cat"><a class="ico-menu icons" data-bclass-toggle="display-cat"></a></li>
        <?php } ?>
        <?php if( osc_users_enabled() ) { ?>
        <?php if( osc_is_web_user_logged_in() ) { ?>
        <li class="first logged"> <span><?php echo sprintf(__('Hi %s', OSCLASSWIZARDS_THEME_FOLDER), osc_logged_user_name() . '!'); ?> </span> &#10072; <strong>
          <a href="#Message" class="inbox"> Messages </a></strong><span id="inbox_unseen_message" class="badge badge-danger"></span>&#10072;<a href="<?php echo osc_user_dashboard_url(); ?>"><strong>
		  <?php _e('My account', OSCLASSWIZARDS_THEME_FOLDER); ?>
          </a></strong> &#10072; <a href="<?php echo osc_user_logout_url(); ?>">
          <?php _e('Logout', OSCLASSWIZARDS_THEME_FOLDER); ?>
          </a> </li>
        <?php } else { ?>
        <li><a id="login_open" href="<?php echo osc_user_login_url(); ?>">
          <?php _e('Login', OSCLASSWIZARDS_THEME_FOLDER) ; ?>
          </a></li>
        <?php if(osc_user_registration_enabled()) { ?>
        <li><a href="<?php echo osc_register_account_url() ; ?>">
          <?php _e('Register for a free account', OSCLASSWIZARDS_THEME_FOLDER); ?>
          </a></li>
        <?php }; ?>
        <?php } ?>
        <?php } ?>
      </ul>
    </div>
  </div>

  <nav class="navbar navbar-expand-lg">
            <div class="container"> 
                   
                    <div class="navbar-brand" id="logo">
                        <?php echo logo_header(); ?>
                    </div>

                    <ul class="nav" id="toggle-publish">
                      <?php if( osc_users_enabled() || ( !osc_users_enabled() && !osc_reg_user_post() )) { ?>
                        <a class="btn btn-success" href="<?php echo osc_item_post_url_in_category() ; ?>">
                        <?php _e('Publish your ad for free', OSCLASSWIZARDS_THEME_FOLDER);?>
                        </a>
                        <?php } ?>
                  </ul>
                      
                    <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbar-collapse" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>                      
                    </button>

                <div class="collapse navbar-collapse" id="navbar-collapse">

                    <ul class="navbar-nav" id="main-navbar">
                      <?php
                        osc_reset_static_pages();
                        while( osc_has_static_pages() ) { ?>
                        <li class="nav-item"> <a class="nav-link" href="<?php echo osc_static_page_url(); ?>"><?php echo osc_static_page_title(); ?></a> </li>
                        <?php
                        }
                      osc_reset_static_pages();
                        ?>
                        <li class="nav-item"> <a class="nav-link" href="<?php echo osc_contact_url(); ?>">
                          <?php _e('Contact', OSCLASSWIZARDS_THEME_FOLDER); ?>
                          </a> </li>
                    </ul>
                </div>
            
            <div class="pull-right">
              <ul class="nav" id="right-navbar">
                  <?php if( osc_users_enabled() || ( !osc_users_enabled() && !osc_reg_user_post() )) { ?>
                    <a class="btn btn-success" href="<?php echo osc_item_post_url_in_category() ; ?>">
                    <?php _e('Publish your ad for free', OSCLASSWIZARDS_THEME_FOLDER);?>
                    </a>
                    <?php } ?>
              </ul>
            </div>
        </div>
    </nav>
    
  <?php 
	if( osc_is_home_page() ) {
		if(osc_get_preference('show_banner', 'osclasswizards_theme')=='1'){
			echo '<div id="header_map">';
			if(homepage_image()) { 
				echo homepage_image(); 
			} else {
			
				echo '<img src="'.osc_current_web_theme_url('images/banner.jpg').'" />';

			} 
			echo '</div>';
		}
?>
  <div class="banner_none" id="form_vh_map">
    <form action="<?php echo osc_base_url(true); ?>" id="main_search" method="get" class="search nocsrf" >
      <div class="container">
        <input type="hidden" name="page" value="search"/>
        <div class="main-search">
          <div class="form-filters">
            <div class="row">
              <?php $showCountry  = (osc_get_preference('show_search_country', 'osclasswizards_theme') == '1') ? true : false; ?>
              <div class="col-md-<?php echo ($showCountry)? '3' : '4'; ?>">
                <div class="cell">
                  <input type="text" name="sPattern" id="query" class="input-text" value="" placeholder="<?php echo osc_esc_html(__(osc_get_preference('keyword_placeholder', 'osclasswizards_theme'), OSCLASSWIZARDS_THEME_FOLDER)); ?>" />
                </div>
              </div>
              <div class="col-md-2">
                <?php  if ( osc_count_categories() ) { ?>
                <div class="cell selector">
                  <?php osclasswizards_categories_select('sCategory', null, osc_esc_html(__('Select a category', OSCLASSWIZARDS_THEME_FOLDER))) ; ?>
                </div>
                <?php  } ?>
              </div>
              <?php if($showCountry) { ?>
              <div class="col-md-2">
                <div class="cell selector">
                  <?php osclasswizards_countries_select('sCountry', 'sCountry', __('Select a country', OSCLASSWIZARDS_THEME_FOLDER));?>
                </div>
              </div>
              <?php } ?>
              <div class="col-md-2">
                <div class="cell selector">
                  <?php osclasswizards_regions_select('sRegion', 'sRegion', __('Select a region', OSCLASSWIZARDS_THEME_FOLDER)) ; ?>
                </div>
              </div>
              <div class="col-md-2">
                <div class="cell selector">
                  <?php osclasswizards_cities_select('sCity', 'sCity', __('Select a city', OSCLASSWIZARDS_THEME_FOLDER)) ; ?>
                </div>
              </div>
              <div class="col-md-<?php echo ($showCountry)? '1' : '2'; ?>">
                <div class="cell reset-padding">
                  <button  class="btn btn-success btn_search"><i class="fas fa-search"></i> <span <?php echo ($showCountry)? '' : 'class="showLabel"'; ?>><?php echo osc_esc_html(__("Search", OSCLASSWIZARDS_THEME_FOLDER));?></span> </button>
                </div>
              </div>
            </div>
          </div>
          <div id="message-seach"></div>
        </div>
      </div>
    </form>
  </div>
  <?php
	
	} 
?>
  <?php osc_show_widgets('header'); ?>
</header>
<div class="wrapper-flash">
  <?php
        $breadcrumb = osc_breadcrumb('<span id="breadcrumb_divider">/</span>', false, get_breadcrumb_lang());
        if( $breadcrumb !== '') { ?>
  <div class="breadcrumb">
    <div class="container"> <?php echo $breadcrumb; ?> </div>
  </div>
  <?php
        }
    ?>
  <?php osc_show_flash_message(); ?>
</div>
<?php osc_run_hook('before-content'); ?>
<div class="wrapper" id="content">
<div class="container">
<?php if( osc_get_preference('header-728x90', 'osclasswizards_theme') !=""){ ?>
<div class="ads_header ads-headers"> <?php echo osc_get_preference('header-728x90', 'osclasswizards_theme'); ?> </div>
<?php } ?>
<div id="main">
<div id="user_model_details"></div>
<div id="user_inbox_details"></div>

<script>
	function make_inbox_dialog_box(user_id)
	{
		var inbox_content = '<div id="inbox_dialog_'+user_id+'" class="user_dialog" title="Inbox">';
		inbox_content += '<div style="height:400px; border:1px solid #ccc; overflow-y: scroll; margin-bottom:24px; padding:16px;" id="inbox_frame_'+user_id+'">';
		inbox_content += fetch_inbox(user_id);
		inbox_content += '</div>';
		$('#user_inbox_details').html(inbox_content);
	}
	function make_inbox_chat_dialog_box(to_user_id, from_user_id, to_user_name)
	{
		var modal_content = '<div id="user_dialog_'+to_user_id+'" class="user_dialog" title="You have chat with '+to_user_name+'">';
		modal_content += '<div style="height:400px; border:1px solid #ccc; overflow-y: scroll; margin-bottom:24px; padding:16px;" class="chat_history" data-touserid="'+to_user_id+'" id="chat_history_'+to_user_id+'">';
		modal_content += fetch_user_chat_history(to_user_id, from_user_id);
		modal_content += '</div>';
		modal_content += '<div class="form-group">';
		modal_content += '<textarea name="chat_message_'+to_user_id+'" id="chat_message_'+to_user_id+'" class="form-control chat_message"></textarea>';
		modal_content += '</div><div class="form-group" align="right">';
		modal_content+= '<button type="button" name="inbox_send_chat" id="'+to_user_id+'" class="btn btn-info inbox_send_chat">Send</button></div></div>';
		$('#user_model_details').html(modal_content);
	}

	$(document).on('click', '.inbox', function(){

		<?php if(osc_logged_user_id() != 0) { ?>
			var user_id = <?php echo osc_logged_user_id()?>;
			make_inbox_dialog_box(user_id);
			$("#inbox_dialog_"+user_id).dialog({
				autoOpen:false,
				width:600
			});
			$('#inbox_dialog_'+user_id).dialog('open');
		<?php     } else {?>
			location.href = '<?php echo osc_user_login_url(); ?>';
		<?php     } ?>
	});
	
	$(document).on('click', '.inbox_start_chat', function(){

		<?php if(osc_logged_user_id() != 0) { ?>
			var to_user_id = $(this).data('touserid');
			var to_user_name = $(this).data('tousername');
			var from_user_id = <?php echo osc_logged_user_id()?>;
			make_inbox_chat_dialog_box(to_user_id, from_user_id, to_user_name);
			$("#user_dialog_"+to_user_id).dialog({
				autoOpen:false,
				width:400,
				close: function() {
					$( ".user_dialog" ).remove();
				}
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
	
	$(document).on('click', '.inbox_send_chat', function(){
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
	
	function fetch_inbox(user_id)
	{
		$.ajax({
			url:"oc-chat/fetch_inbox.php",
			method:"POST",
			data:{user_id:user_id},
			success:function(data){
				$('#inbox_frame_'+user_id).html(data);
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
	
	function fetch_inbox_unseen_message(user_id)
	{
		$.ajax({
			url:"oc-chat/fetch_inbox_unseen_message.php",
			method:"POST",
			data:{user_id:user_id},
			success:function(data){
				$('#inbox_unseen_message').html(data);
			}
		})	
	}
	
	$(document).ready(function(){

		setInterval(function(){
			fetch_inbox_unseen_message(<?php echo osc_logged_user_id()?>);
			fetch_inbox(<?php echo osc_logged_user_id()?>);
			update_last_activity();
			update_chat_history_data();
		}, 5000);
	}); 

	$(document).on('click', '.inbox_ui-button-icon', function(){
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
	
	$(document).on('click', '.inbox_remove_chat', function(){
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
