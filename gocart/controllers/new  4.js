bf_edit_post = function() {
	this.controller = '/buzzfeed/_public_admin';
	this.comment_moderation_controller = '/buzzfeed/comments_moderation';
	this.delete_related_links_controller = '/buzzfeed/_delete_related_links';
	this.uri_type = (window.location.pathname.split('/')).pop();

	this.init = function( args ) {
		if ( window.location.href.match('/dashboard') ) return;
		if ($('user_post_preview_iframe')) {
			$('close-preview').observe('click',function(e){$('user_post_preview').hide()});
			// $('user_post_preview_iframe').src='/static/html/quickpost_preview.html?cb='+(new Date()).getTime();
		}
		if ( !args || (args['load']) ) edit_post.load_buzz();
		edit_post.set_handlers();
		if ( edit_post.uri_type == 'delete_reaction' || edit_post.uri_type == 'delete_related_links' ) edit_post.setup_delete_reaction_form();
		if ( $('video-supported-text') ) $('video-supported-text').update(BF_VIDEO_TYPES_STRING);
		if ( $('quickpost-video-label') ) $('quickpost-video-label').update('Video URL <span class="note">(' + BF_VIDEO_TYPES_STRING + ')</span>');
        /* Fix for set min-height to #suplist_left_post_controls */
        if(typeof(bf_qp_sidebar) != 'undefined' ) {
            EventManager.observe('edit_post:load:done', function() {
                bf_qp_sidebar.validate_page_content_height();
            });
        }
	}

	this.set_handlers = function() {
		var user = new BF_User();
		if ( acl.user_can('general_admin') && $('quickpost-enhanced-settings') ) $('quickpost-enhanced-settings').show();
		var _set_handler = function(el,ev,fn) {
			if ($(el)) $(el).observe(ev,fn);
		}
		if ( $('quickpost-post-button') ) $('quickpost-post-button').stopObserving('click',user_post.save_quickpost);
		_set_handler( 'cancel-edit-button', 'click', edit_post.save_ok );
		_set_handler( 'cancel-delete-button', 'click', edit_post.cancel_delete );
		_set_handler( 'delete-button', 'click', edit_post.delete_item );
		_set_handler( 'cancel-remove-button', 'click', edit_post.cancel_delete );
		_set_handler( 'remove-button', 'click', edit_post.remove_item );
		_set_handler( 'quickpost-post-button', 'click', edit_post.save_quickpost );
		_set_handler( 'quickpost-post-draft-button', 'click', edit_post.save_quickpost_as_draft );
		if ( $$('.quickpost-view-draft').length ) {
			$$('.quickpost-view-draft').each(function(el) { _set_handler( el , 'click', edit_post.view_draft ); });
		}
		if ($('user_post_preview_iframe') && !superlist) {
			if ($('close-image')) $('close-image').observe('click',function(){BF_UI.closeDialog('user-image-edit')});
			if ($('close-preview')) $('close-preview').observe('click',function(){BF_UI.closeDialog('user_post_preview')});
			$('user_post_preview_iframe').src='/static/html/quickpost_preview.html?cb='+(new Date()).getTime();
		}
		user_post.set_shared_handlers();
	}

	this.view_draft = function() {
		var buzz_id = edit_post.getParameter('id') || edit_post.campaignid || user_post.buzz.id;
		window.open('/buzzfeed/_draft/' + buzz_id);
	}

	this.setup_delete_reaction_form = function() {
		var user = new BF_User();
		if (top.acl.user_can('edit_user_posts') ) {
			var buzz_name = edit_post.getParameter('buzz_name');
			if ($('post-headline')) $('post-headline').update( unescape(buzz_name) );
		}
		else {
			edit_post._load_buzz_error();
		}
	}

	this.delete_item = function(e) {
		e.stop();
		if ( edit_post.uri_type == 'delete_reaction' ) edit_post.delete_reaction(e);
		else if ( edit_post.uri_type == 'delete_contribution' ) edit_post.delete_contribution(e);
		else if ( edit_post.uri_type == 'delete_related_links' ) edit_post.delete_related_links(e);
		else edit_post.delete_quickpost(e);
	}

	this.remove_item = function(e) {
		e.stop();
		var acl = 'homepage_edit';
		var country = edit_post.getParameter('country');
		if ( country == 'uk' ) { acl = 'uk_homepage_edit'; }
		else if ( country == 'au' ) { acl = 'australia_homepage_edit'; }
		if ( !top.acl.user_can(acl) ) return;
		(new BF_Request).request('/buzzfeed/_admin', {
			method:'post',
			parameters: {
				action: 'remove_from_hp',
				buzz_id: edit_post.getParameter('id'),
				country: country
			},
			onComplete:function(){
				edit_post.cancel_delete();
				edit_post.reloadParent();
			}
		});
	}

	this.delete_reaction = function(e) {
		e.stop();
		var buzz_id = edit_post.getParameter('id');
		var user_id = edit_post.getParameter('user_id');
		var responses = edit_post.getParameter('responses');
		var comment_id = edit_post.getParameter('comment_id');

		var request = (new BF_Request()).request;
		request(edit_post.comment_moderation_controller, {
			method:'post',
			parameters:{action:'delete_reaction',buzz_id:buzz_id,responses:responses,user_id:user_id},
			onComplete:function(){
				if (parent.$(comment_id)) { parent.$(comment_id).update('<span style="color:red;">Item Deleted!</span>'); }
				edit_post.cancel_delete();
			}
		});
	}

	this.delete_contribution = function(e) {
		e.stop();
		var comment_id = edit_post.getParameter('comment_id');

		var request = (new BF_Request()).request;
		request(edit_post.comment_moderation_controller, {
			method:'post',
			parameters:{action:'update_contribution', f_deleted: 1,comment_id:comment_id},
			onComplete:function(){
				if (parent.$(comment_id)) { parent.$(comment_id).update('<span style="color:red;">Item Deleted!</span>'); }
				edit_post.cancel_delete();
			}
		});
	}

	this.delete_related_links = function(e) {
		e.stop();
		var campaignid = edit_post.getParameter('campaignid');
		var related_campaignid = edit_post.getParameter('related_campaignid');
		var request = (new BF_Request()).request;
		request(edit_post.delete_related_links_controller, {
			method:'post',
			parameters:{action:'delete',campaignid:campaignid,related_campaignid:related_campaignid},
			onComplete:function(){
				edit_post.cancel_delete();
			}
		});
	}

	this.delete_quickpost = function(e) {
		e.stop();
		if (edit_post.buzz && edit_post.buzz.campaignid) {
			if ( edit_post.buzz && edit_post.buzz.campaignid && $('post-'+edit_post.buzz.campaignid))
				$('post-'+edit_post.buzz.campaignid).parentNode.removeChild($('post-'+edit_post.buzz.campaignid));
			var params = { action:'delete',id:edit_post.buzz.campaignid};
			EventManager.fire('edit_post:delete:preparing', params);
			var request = (new BF_Request()).request;
			request(edit_post.controller, {
				method:'post',
				needsToken:true,
				parameters:params,
				onSuccess:function(){
					edit_post.cancel_delete();
					var user = new BF_User();
					user = user.getUserInfo().username;
					var regex = new RegExp('/'+user+'/.*');
					if ( parent.window.location.href.match(regex) ) {
						var url = parent.window.location.href;
						url = url.replace(regex,'/'+user);
						parent.window.location.href = url;
					}
					else {
						parent.$('post-' + edit_post.buzz.campaignid).hide();
						var draft_count_el = parent.$('draft-count');
						if ( draft_count_el ) {
							var draft_count = draft_count_el.getAttribute('rel:data');
							draft_count = eval('('+draft_count+')');
							draft_count.draft_count--;
							draft_count_el.setAttribute('rel:data', Object.toJSON(draft_count));
							draft_count_el.update(draft_count.draft_count);
						}
					}
				}
			});
		} else {
			EventManager.observe('edit_post:load:done', edit_post.delete_quickpost.bind(edit_post,e));
		}
	}

	this.save_quickpost_as_draft = function(e) {
		e.stop();
		var type = $F('buzz-type');
		var post_structure = user_post.STRUCTURE[type];
		if  (typeof post_structure['preprocess'] != 'undefined' )
		{
			post_structure.preprocess();
		}
		if ( typeof user_post.enhanced_js != 'undefined' ) {
			$('quickpost-enhanced-data').value = user_post.enhanced_js.as_string();
		}
		edit_post.save_quickpost(e, {save_as_draft:true});
	}

    this.save_quickpost = function (e, params, sl) {
       	try { // fix for IE8
			e.stop();
        } catch (err) { console.error(err); }
        if (typeof(params) == 'undefined') params = {};
        user_post.save_as_draft = params.save_as_draft ? params.save_as_draft : false;

        var buzz_type;
        if (!!sl || $('buzz-type')) { // superlist, we know where it is.
            buzz_type = $('buzz-type').getValue();
        } else if (e.target.form.elements['buzz-type']) {
            buzz_type = e.target.form.elements['buzz-type'].value;
        }
        if (!user_post.show_validation_errors(buzz_type, {draft:user_post.save_as_draft})) {
            var obj = user_post.build_post_object(buzz_type);

            if (edit_post.buzz) {
                if (edit_post.buzz.campaignid) obj.campaignid = edit_post.buzz.campaignid;
                if (edit_post.buzz.uri) obj.uri = edit_post.buzz.uri;
                if (obj.image == edit_post.buzz.image_buzz || obj.thumb == edit_post.buzz.image) {
                    obj.delete_images = 'no';
                }
            } else if (!obj.campaignid || obj.campaignid == 0) {
                obj.campaignid = edit_post.getParameter('id') || edit_post.campaignid || 1;
            }

            var user = new BF_User();
            if (!acl.user_can('general_admin')) {
                delete obj.categorization;
                delete obj.tags;
                delete obj.tame;
                delete obj.add_badges;
                delete obj.remove_badges;
                delete obj.additional_bylines;
            }
            else
            {
	            if ( 'edit_post_badge_ui' in window ) {
		            obj.add_badges = edit_post_badge_ui.add_badges || [];
		            obj.remove_badges = edit_post_badge_ui.remove_badges || [];
	            }
	            if ( 'superlist_bylines' in window ) {
	            	obj.additional_bylines = superlist_bylines.add_users.map(function(username) { return superlist_bylines.additional_bylines[username].id }).join(',');
	            }

            }
            obj.draft_public = 0;
            if ($('quickpost-public-draft') && $('quickpost-public-draft').checked) {
                obj.draft_public = 1;
            }
            user_post.preview_from_server(obj, function (r) {
                edit_post.preview_from_server_and_save(r, obj);
            });
        } else {
            EventManager.fire('edit_post:save:failed', {});
        }
    }

	this.preview_from_server_and_save = function( r, data ) {
		if ($('quickpost-spinner')) $('quickpost-spinner').show();
		if ($('edit_post_page_success_msg')) $('edit_post_page_success_msg').hide();
		if ($('quickpost-error-msg')) $('quickpost-error-msg').hide();
		var obj = r ? eval('('+r.responseText+')') : false;
		if ($('user_post_preview')) $('user_post_preview').hide();
		if(edit_post.buzz){
			data.id = edit_post.buzz.campaignid;
			data.origin = edit_post.buzz.origin;
			data.uri = edit_post.buzz.uri;
		}else{
			if( typeof(data.id) == "undefined" && typeof(data.campaignid) != "undefined"){
				data.id = data.campaignid;
			}
		}
		data.action = 'save';
		if ($('quickpost-queue') && $('quickpost-queue').checked) { data.queue_it = 1; }
		if ($('quickpost-queue-and-publish') && $('quickpost-queue-and-publish').value == 1) { data.queue_and_publish = 1; }
		EventManager.fire('edit_post:save:preparing', data);
		if (user_post.save_as_draft) data.draft = 1;
		['widget','promoted'].each(function(flag){
			if ( $('suplist_' + flag) && !$('suplist_' + flag).checked ) {
				data['f_' + flag] = 0;
			}
		});
		if (user_post.save_as_draft) data.draft = 1;
		if(data.f_index && data.f_index == 1 && acl.user_can('general_admin') && !acl.user_can('queue_super_admin')){
			if( !(data.draft && data.draft == 1) && !(data.queue_it && data.queue_it == 1) && !(data.queue_and_publish && data.queue_and_publish == 1) && !((new BF_User()).getUserInfo().f_ad == 'true') ){
				data.f_index = 0;
				data.fq_suggest = 1;
				if($('hp_queue_label')){
					$('hp_queue_label').innerHTML = " Suggest for HP Queue?";
				}
			}
		}
		if ( !obj || obj.success ) {
			if (BF_UserSwitcher.selected_user != null && edit_post.buzz && BF_UserSwitcher.selected_user != edit_post.buzz.username) {
				data.switch_username = data.username = BF_UserSwitcher.selected_user;
			}

			if( typeof superlist != 'undefined' && 'submit_to_username' in superlist && superlist.submit_to_username != '' ) {
				data.submit_to_microsite = superlist.submit_to_username;
			}

			if( data.list_format_visual && ( data.list_format_visual == 'dec_up' || data.list_format_visual == 'dec_down' ) ) {
				data.sub_buzz_ids_num = superlist.item_ids_num();
			}

			var request = (new BF_Request()).request;
			request(edit_post.controller, {
				method:'post',
				needsToken:true,
				parameters:data,
				onSuccess: function(resp){
					edit_post.check_community(resp, data, obj);
				},
				onFailure: function(resp){
					user_post.save_failed(resp);
				}, bf_auth: true
			});
		}
	}

	this.cancel_delete = function() {
		parent.BF_UI.closeDialog('user_post_delete');
	}

	this.check_community = function(resp, data, template) {
		var resp_obj = eval('('+resp.responseText+')');

		if ($('add_to_community') && $('add_to_community').checked && typeof resp_obj != 'undefined' && typeof resp_obj.community != 'undefined' ) {
			var action = resp_obj.community.action;
			if ( action == 'warn' ) {
				alert('You have used all of your community suggestions for today; you can suggest more tomorrow.');
			}
		}

		edit_post.save_ok(resp, data, template);
	}

	this.save_ok = function( resp, data, template ) {
		var resp_obj = eval('('+resp.responseText+')');
		if ( typeof resp_obj != 'undefined' ) BFW_Util.updateInfoCookie({last_active:resp_obj.last_active});

		if ( !resp_obj['updated'] ) {
			return user_post.save_failed(resp_obj);
		}

		var params = {
			loadDefaultDiv:'quickpost-spinner'
		};
		if ( typeof data != 'undefined' && typeof template != 'undefined' ) {
			params['onComplete'] = function(){
				if ( data.draft == 1 ) {
					parent.bf_editor.init();
					return;
				}
				var full_uri = '/'+data.username + '/' + data.uri ;
				var url_regex = new RegExp(full_uri);
				if ( parent.window.location.href.match(url_regex) ) {
					var html = '';
					for( var each in template ) { if ( each != 'snippet' ) {
							var template_list = data.template.split(' ');
							for ( var i=0; i < template_list.length; i++ ) {
								if ( template_list[i] == each )	html = template[each]
							}
						}
					}
					var div = parent.$('post-'+data.id).parentNode.parentNode;
					var newDiv = document.createElement('div');
					newDiv.className = div.className;
					try{
						div.parentNode.replaceChild( newDiv, div );
					} catch(e) {
						edit_post.reloadParent();
					}
					newDiv.innerHTML = html;
				}
				else {
					var li = parent.$('post-'+data.id);
					if ( li ) {
						try {
							li.update(template.snippet);
						} catch(e) {
							if ( parent.user_post ) parent.user_post.update_element('post-'+data.id,template.snippet);
							else
								// TRACKING FOR #55580386
								BF_Request.location( { reload_track: true } );
								// window.location.reload();
								// END #55580386
						}
					}
				}
				parent.bf_editor.init();
			}
		}

		var ifrm = parent.$('embed');
		if ( ifrm ) {
			ifrm = (ifrm.contentWindow) ? ifrm.contentWindow : (ifrm.contentDocument.document) ? ifrm.contentDocument.document : ifrm.contentDocument;
			var code = unescape(user_post.posted_buzz.code);
			ifrm.document.open();
			ifrm.document.write( code );
			ifrm.document.close();
		}

		if( !$('edit_post_page_success_msg') ){
			parent.BF_UI.closeDialog('user_post_edit',params);
		}

		// we are a list buzz, so load images hidden by progressive loading...
		if(parent.BF_IS_TOP_LIST) {
			try {
				var top_ul = parent.document.getElementById('top-list');
				var list_images = top_ul.getElementsByTagName('img');
				for(i = 0; i < list_images.length; i++) {
					progload_src = list_images[i].getAttribute('rel:bf_image_src');
					if(progload_src) {
						list_images[i].src = progload_src;
					}
				}
			} catch(e) { console.log(e); }
		}

		// Show queue dialog unless this buzz is already queued
		if ( ( edit_post.buzz && !edit_post.buzz.queue_data) && (resp_obj.queued || resp_obj.queue_and_publish) ) {
			user_post.queue_quickpost(data);
		}

		data.uri = resp_obj.uri;
		data['sub_buzz_errors'] = resp_obj['sub_buzz_errors'];
		EventManager.fire( 'edit_post:save:done', data );
		if ( data.draft != 1 && (!resp_obj.queued || resp_obj.queue_and_publish) ) {
			if ( $( 'edit_post_page_success_msg' ) ) {
				if ( $( 'quickpost-spinner' ) ) $( 'quickpost-spinner' ).hide();
				if ( BF_UserSwitcher.is_user_switcher && BF_UserSwitcher.selected_user != null && BF_UserSwitcher.selected_user != edit_post.buzz.username ) {
					var uri = (data['username'] && data['uri'] ? ((data['web_root'] ? data['web_root'] : '') + '/' + data['username'] + '/' + data['uri']) : null);
					edit_post.buzz.username = data.username;
					BF_UserSwitcher.latest_switch_list.each( function( ell ) {
						if ( ell.username == BF_UserSwitcher.selected_user ) {
							edit_post.buzz.userid = ell.userid;
							edit_post.buzz.user_displayname = ell.display_name;
						}
					} );

					BF_UserSwitcher.switcher.select( '.switch_user_list' )[0].hide();
					BF_UserSwitcher.selected_user = data.username;
					BF_UserSwitcher.apply_visibility();
				}
				else
					var uri = (
						superlist && superlist.publish_url() ? superlist.publish_url()
							: (data['username'] && data['uri'] ? ((data['web_root'] ? data['web_root'] : '') + '/' + data['username'] + '/' + data['uri'])
							: null)
						);
				var success_message = $( 'edit_post_page_success_msg' ).update( 'Your changes were successfully saved.' + (uri ? ' <a href="' + uri + '">View Post</a>' : '') ).show();
				if( typeof data.queue_and_publish == 'undefined' || data.queue_and_publish != 1){
					superlist.scrollToQuickpostMsg(success_message);
				}
			}
			if ( document.superfeedr ) document.superfeedr.submit();
		} else {
			if ( $( 'suplist_post_spinner' ) ) $( 'suplist_post_spinner' ).hide();
			if ( $( 'suplist_saved_draft_success' ) ) {
				$( 'suplist_saved_draft_success' ).show();
				setTimeout( function() {$( 'suplist_saved_draft_success' ).hide();}, 10000 );
			}
		}
	}

	this.reloadParent = function(){
		if ( self.parent.location.href.indexOf('?') == -1 ) {
			self.parent.location.href += '?';
		}
		self.parent.location.href += '&cb=' + (new Date()).getTime();
	}

	this.save_image = function(path, image, region, sendTo) {
		var params = region;
		if ( typeof sendTo == 'undefined' ) {
			sendTo = '/buzzfeed/_edit_user_image';
		}
		else {
			params.type = $('buzz-type').value + 'buzz';
		}
		if ($('user-loading')) $('user-loading').show();
		if ($('user-image-edit')) $('user-image-edit').hide();
		params.image = path.replace(/\.(jpg|gif)$/, '');
		params.action = 'imagecrop';
		var sr = function(resp) { edit_post.image_saved(resp) };
		var er = edit_post._server_error;
		var request = (new BF_Request()).request;
		request(sendTo, {method: 'post', parameters: params, onSuccess: sr, onFailure: er});
	}

	this.image_saved = function(resp) {
		try {
			if ( $( 'user-loading' ) ) $('user-loading').hide();
			var obj = eval('(' + resp.responseText + ')');
			if(obj.saved) {
				if ( typeof window['superlist'] != 'undefined' && !window.old_ui) return superlist.set_parent_image(resp);
				if ($('quickpost-link-image-file')) $('quickpost-link-image-file').value = obj.thumb_image;
				if ($('quickpost-quiz-image-file')) $('quickpost-quiz-image-file').value = obj.thumb_image;
				if ($('quickpost-video-image-file')) $('quickpost-video-image-file').value = obj.thumb_image;
				if ($('quickpost-image-image-thumb')) $('quickpost-image-image-thumb').value = obj.thumb_image;
				if ($('quickpost-image-image-file')) $('quickpost-image-image-file').value = obj.large_image;
				if ($('quickpost-embed-image-file')) $('quickpost-embed-image-file').value = obj.thumb_image;
				if ($('quickpost-enhanced-image-file')) $('quickpost-enhanced-image-file').value = obj.thumb_image;
				if ($('quickpost-super-image-file')) $('quickpost-super-image-file').value = obj.thumb_image;

				if ($('enhanced-thumbnail')) {
					$('enhanced-thumbnail').src=bf_ir+obj.thumb_image;
					$('enhanced-thumbnail').show();
				}
				if ($('embed-thumbnail')) {
					$('embed-thumbnail').src=bf_ir+obj.thumb_image;
					$('embed-thumbnail').show();
				}
				if ($('link-thumbnail')) {
					$('link-thumbnail').src=bf_ir+obj.thumb_image;
					$('link-thumbnail').show();
				}
				if ($('video-link-thumbnail')) {
					$('video-link-thumbnail').src = bf_ir+obj.thumb_image;
					$('video-link-thumbnail').show();
				}
				if ($('image-preview')) {
					$('image-preview').src = bf_ir+obj.thumb_image;
					if ($('image-preview-div')) $('image-preview-div').show();
					if (/super.*/.test(edit_post.buzz.form))
					{
						$('image-preview').show();

					} else if (edit_post.buzz.form=='image' ) {
						$('image-preview').show();
						$('img-form-preview').src = bf_ir+obj.large_image;
						$('img-form-preview').show();
						$('image-form-preview').show();
					}
				}
				if ($('quiz-thumbnail')) {
					$('quiz-thumbnail').src=bf_ir+obj.thumb_image;
					$('quiz-thumbnail').show();
				}
			} else {
				this.error(this.IMAGE_ERR)
				$('link-thumnail').hide();
				$('quiz-thumnail').hide();
				$('video-link-thumbnail').hide();
			}
		}
		catch (err) {
			console.error(err);
		}
	}

	this.load_buzz = function() {
		if ( edit_post.uri_type == 'delete_reaction' ) return;
		else if ( edit_post.uri_type == 'delete_related_links' ) return;
		if ($('quickpost-spinner')) $('quickpost-spinner').show();
		var id = edit_post.getParameter('id') || edit_post.campaignid || 1;
		var params = {
			action:'get',
			id:id
		};
		EventManager.fire('edit_post:load:preparing', params);
		var request = (new BF_Request()).request;
		request(edit_post.controller, {
			method : 'post',
			parameters: params,
			onSuccess: edit_post._load_buzz,
			onFailure:edit_post._server_error
		});
	}

	this._load_buzz = function(r) {
		try {
			// parse data from response
			var obj = eval( '('+r.responseText+')' );
			// show error if failed to retrieve buzz
			if ( !obj.success ) {
				edit_post._load_buzz_error( obj.error );
				return;
			}

			if (/^super.*/.test(obj.buzz.buzz_type)) {
				obj.buzz.buzz_type = 'super';
			}

			// save buzz data on object for future use, then populate fields with data
			edit_post.buzz = obj.buzz;
			var structure_key = obj.buzz.buzz_type;
			if ( structure_key == 'enhanced' ) {
				for ( var each in user_post.ID_TO_ENHANCED_MAP ) {
					if ( user_post.ID_TO_ENHANCED_MAP[ each ] == obj.buzz.enhanced_id ) {
						user_post.trigger_element = each;
					}
				}
			}

			var post_structure = user_post.STRUCTURE[structure_key];
			var fields = post_structure.form_to_obj_map;

			obj.buzz.tags = user_post.sync_tags_with_primary_keyword(obj.buzz.tags, obj.buzz.primary_keyword);
			if (typeof superlist_special_tags != 'undefined') superlist_special_tags.special_tags_warning(obj.buzz.tags);
			user_post.duplicate_tags_warning(obj.buzz.tags);

			for( var field in fields ) {
				var id = fields[field].field;
				if ( $(field) && obj.buzz[id] ) {
					// hack to forch html entities to render
					$('quickpost-edit-cleaner').innerHTML = obj.buzz[id];
					$(field).value = $('quickpost-edit-cleaner').innerHTML;
				}
			}

			if ( obj.buzz.category_id ) {
				universal_dom.get_bucket_elements('select_vertical').each( function(select){
					for( var i = 0; i < select.options.length; i++ ) {
						if ( select.options[i].value == obj.buzz.category_id ) {
							select.options[i].selected = true;
							user_post.select_vertical_changed({target:select});
						}
					}
				});
			}

			if(obj.buzz && typeof superlist_bylines != 'undefined') superlist_bylines.set_user_preview( obj.buzz );
			
			if ( $(obj.buzz['supertags']) ) {
				var tweet_info;
				if (obj.buzz.tweet_info) tweet_info = obj.buzz.tweet_info.evalJSON();
				var all_supertags = $(obj.buzz['supertags']);
				var supertags = [];
				
				if ( typeof superlist_special_tags != 'undefined') {
					all_supertags.each(function(supertag) {
						try {
							superlist_special_tags.load_supertag(supertag, obj, tweet_info);
						} catch (err) {
							console.dir(err)
						}
					});
					if ($('quickpost-supertags')) {
						try {
							superlist_special_tags.update_special_tags_ui();
						} catch (err) {
							console.dir(err)
						}
					}
				}
			}

			if ($('quickpost-link-image-file') && $('quickpost-link-image-file').value != 'undefined' && $('link-thumbnail')) {
				$('link-thumbnail').src = top.BF_STATIC.image_root + $('quickpost-link-image-file').value;
				$('link-thumbnail').show();
			}
			if ($('quickpost-video-image-file') && $('quickpost-video-image-file').value != 'undefined' && $('video-link-thumbnail')) {
				$('video-link-thumbnail').src = top.BF_STATIC.image_root + $('quickpost-video-image-file').value;
				$('video-link-thumbnail').show();
			}
			if ($('quickpost-enhanced-image-file') && $('quickpost-enhanced-image-file').value != 'undefined' && $('enhanced-thumbnail')) {
				$('enhanced-thumbnail').src = top.BF_STATIC.image_root + $('quickpost-enhanced-image-file').value;
				$('enhanced-thumbnail').show();
			}
			if ($('quickpost-embed-image-file') && $('quickpost-embed-image-file').value != 'undefined' && $('embed-thumbnail')) {
				$('embed-thumbnail').src = top.BF_STATIC.image_root + $('quickpost-embed-image-file').value;
				$('embed-thumbnail').show();
			}
			if ( typeof post_structure.init != 'undefined' ) {
				post_structure.init(structure_key);
				edit_post.when_ready(
					function(){return typeof ClassifyQuiz != 'undefined' && typeof ClassifyQuiz.restore != 'undefined'},
					function(){ClassifyQuiz.restore(eval('('+edit_post.buzz.enhanced_data+')'))}
				);
				edit_post.when_ready(
					function(){return typeof TopList != 'undefined' && typeof TopList.restore != 'undefined'},
					function(){TopList.restore({responseText:edit_post.buzz.enhanced_data})}
				);
			}
			//highlight rating
			edit_post.when_ready(
				function() {return $$( 'input[type=radio][name=quickpost-tame]:checked' ).length;},
				function() {$$( 'input[type=radio][name=quickpost-tame]:checked' )[0].up().addClassName( 'active' )}
			);

			if ($('quickpost-spinner')) $('quickpost-spinner').hide();

			if ($('post-headline')) $('post-headline').update(edit_post.buzz.name);
			else {
				if (structure_key=='image' && obj.buzz.image != null) edit_post.image_saved({responseText:Object.toJSON({saved:'ok',thumb_image:obj.buzz.image,large_image:obj.buzz.image_buzz})});
				if ( obj.buzz.buzz_type == 'video' ) {
					user_post.upload_video({stop:function(){},target:{value:obj.buzz.video_url}});
				}
			}
			if( !acl.user_can('homepage_edit')){
				$$('.vertical_options').each(function(el) { el.addClassName("hidden"); });
			}

			if(acl.user_can('general_admin')){
				if( obj.buzz.status == "live" ){
					if ($('quickpost-queue-super')) $('quickpost-queue-super').hide();
					if ($('suplist_queued')) $('suplist_queued').hide();
					if ($('suplist_published')) $('suplist_published').show();
					if ($('quickpost-create-super')) $('quickpost-create-super').show();
					if ($('quickpost-save-draft-super')) $('quickpost-save-draft-super').hide();
					if ($('quickpost-edit-super')) $('quickpost-edit-super').hide();
					if ( $$('.quickpost-view-draft').length ) {
						$$('.quickpost-view-draft').each(function(el) { el.hide(); });
					}
					if ($('quickpost-preview-super')) $('quickpost-preview-super').show();
				}else if ( obj.buzz && obj.buzz.queue_data && $('suplist_queued')){
					var href = BF_STATIC.web_root + '/drafts/' + obj.buzz.username;
					$('suplist_queued').innerHTML = "<span>&nbsp;</span>Queued for " + obj.buzz.queue_data.run_at + " (" + obj.buzz.queue_data.queued_for + ") - <a href=\"" + href + "\">Edit</a>";
					$('suplist_queued').show();
					if ( typeof obj.buzz.queue_data.params != 'undefined' && obj.buzz.queue_data.params.index && acl.user_can('homepage_edit') ) { $('suplist_index').checked = true; }
					$('quickpost-queue-super').innerHTML = 'Save Draft';
					$('quickpost-queue-super').show();
					$('left_post_buttons').insertBefore($('quickpost-queue-super'), $('left_post_buttons').firstChild);
					if ($('quickpost-create-super')) $('quickpost-create-super').hide();
					if ($('quickpost-save-draft-super')) $('quickpost-save-draft-super').hide();
					if ($('quickpost-edit-super')) $('quickpost-edit-super').hide();
					if ( $$('.quickpost-view-draft').length ) {
						$$('.quickpost-view-draft').each(function(el) { el.show(); });
					}
					if ($('quickpost-preview-super')) $('quickpost-preview-super').hide();
				}else{
					if ($('suplist_queued')) $('suplist_queued').hide();
					if( !! superlist ){
						superlist.show_hide_queue_button();
					}else{
						$('quickpost-queue-super').show();
					}
				}
			}else{
				if ($('suplist_queued')) $('suplist_queued').hide();
				if ($('quickpost-queue-super')) $('quickpost-queue-super').hide();
			}
			if(obj.buzz.status=='draft' && $$('.quickpost-view-draft').length ){
				var show_flag = false;
				if (acl.user_can('edit_user_posts')) {show_flag = true;}
				if (acl.user_can('partners_manage') && (parseInt(obj.buzz.user_ad) || parseInt(obj.buzz.user_partner) || (new BF_User()).getUserInfo().username == obj.buzz.username)) {show_flag = true;}
				if (show_flag) {
					$$('.quickpost-view-draft').each(function(el) { el.show(); });
					if ( $( 'quickpost-preview-super' ) ) {$( 'quickpost-preview-super' ).hide();}
				}
			}

			// old post builder
			if (obj.buzz.status=='draft' && $('quickpost-post-draft-button')) {
				$('quickpost-post-draft-button').show();
				$('quickpost-post-button').value = 'Publish Now';
				$('quickpost-post-button').removeClassName('bf_submit');
			}
			else if ($('quickpost-post-button')) {
				$('quickpost-post-button').value = 'Save Changes';
				$('quickpost-post-button').addClassName('bf_submit');
			}
			// If user can manage partners and this buzz was created by an advertiser or a partner...
			if ( acl.user_can('partners_manage') && (parseInt(obj.buzz.user_ad) || parseInt(obj.buzz.user_partner) || (new BF_User()).getUserInfo().username == obj.buzz.username) ) {
				if ($('quickpost-public-draft-div')) $('quickpost-public-draft-div').show();
			}

			if ($('quickpost-public-draft')) {
				$('quickpost-public-draft').checked = obj.buzz.draft_public == '1';
			}

			if(obj.buzz.status=='draft' && $$('.quickpost-view-draft').length ){
				var show_flag = false;
				if (acl.user_can('edit_user_posts')) {show_flag = true;}
				if (show_flag) {
					$$('.quickpost-view-draft').each(function(el) { el.show(); });
					if ( $( 'quickpost-preview-super' ) ) {$( 'quickpost-preview-super' ).hide();}
				}
			}

			if (obj.buzz.origin == 'partner') $('quickpost-link-url').disable();
			if($("page_container")) $("page_container").show();
			if($('quickpost-tame')) $('quickpost-tame').checked = !obj.buzz.nsfw;

			if ( obj.buzz.f_ad == 1 ) {
				universal_dom.get_bucket_elements( 'enable_for_general_advertiser' ).each( function( el ) { el.removeAttribute( 'disabled' ); } );
			}

			if ( 'edit_post_badge_ui' in window ) edit_post_badge_ui.init();
			EventManager.fire( 'edit_post:load:done', obj );
			if ( typeof BF_UserSwitcher != 'undefined' ) BF_UserSwitcher.init( edit_post.buzz.username );

			return obj;
		} catch (err) { 
			console.dir(err);
		}
	}

	this.when_ready = function( test, action, count ) {
		if ( typeof count == 'undefined' ) count = 0;
		if ( count > 25 ) { return; }
		if ( test() ) {action()}
		else window.setTimeout(function(){edit_post.when_ready(test,action,count+1)}, 200 );
	}

	this._load_buzz_error = function(msg) {
		var user = new BF_User();
		var user_info = user.getUserInfo();
		if ($('delete-quickpost-form')) $('delete-quickpost-form').hide();
		if ($('edit-quickpost-form')) $('edit-quickpost-form').hide();
		if ($('quickpost-spinner')) $('quickpost-spinner').hide();
		if ( acl.user_can('general_admin') ) {
			if ($('error-message-dialog')) {
				var buzz_id = edit_post.getParameter('id');
				$('error-message-dialog').update('<span>Sorry, this buzz can only be edited in the <a href="'+parent.BF_STATIC.terminal_root_url+'?action=buzz_edit&bid='+buzz_id+'" target="_blank">terminal</a>.</span>');
				$('error-message-dialog').show();
			}
		}
		else {
			if ( msg == 'You cannot edit once the buzz has appeared on the homepage or has been promoted' ) {
				if ($('error-message-dialog')) {
					$('error-message-dialog').update('<span>Sorry, this post has been promoted by BuzzFeed editors so it can no longer be edited or deleted. Contact community@buzzfeed.com for more info.</span>');
					$('error-message-dialog').show();
				}
			}
			else if (edit_post.invalid_user) {
				if ($('error-message-dialog')) $('error-no-permission-dialog').show();
			}
			else {
				if ($('error-message-dialog')) {
					if (msg) $('error-message-dialog').update(msg);
					$('error-message-dialog').show();
				}
			}
		}
		if($("page_container")) $("page_container").show();
	}

	this._server_error = function(r) {
		alert( 'server error' );
	}

	this.getParameter = function( key ) {
		if (typeof this.__parameters == 'undefined') {
			this.__parameters = {};
			var stuff = window.location.search.substring(1);
			stuff = stuff.split('&');
			for( var i = 0; i < stuff.length; i++ ) {
				var pairs = stuff[i].split( '=' );
				this.__parameters[pairs[0]] = typeof pairs[1] == 'undefined' ? '' : pairs[1];
			}
		}
		return this.__parameters[key] ;
	}
	
}

var edit_post = new bf_edit_post();
user_setting = {save_image:edit_post.save_image};
document.observe('dom:loaded',function() { edit_post.init({load: edit_post.uri_type=='delete' || edit_post.uri_type=='link'}) });
