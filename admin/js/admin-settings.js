	/**
	 * PART 1
	 * js scripts for admin settings page
	 */

	jQuery(function() {
		jQuery('#general-settings').show(); //show the first tabs
		jQuery('#notifications-content').hide(); // hide succeeding tabs
		jQuery('#general-settings-tab').addClass('active'); // mark first tab as active
	});
	
	function opentab( evt, tabName ) {
		var i, tabcontent, tablinks;
	
		tabcontent = document.getElementsByClassName( 'settings_body' );
		for ( i = 0; i < tabcontent.length; i++ ) {
			tabcontent[i].style.display = 'none';
		}
	
		tablinks = document.getElementsByClassName( 'tab-links' );
		for ( i = 0; i < tablinks.length; i++ ) {
			tablinks[i].className = tablinks[i].className.replace( ' active', '' );
		}
	
		document.getElementById( tabName ).style.display = 'block';
	
		evt.currentTarget.className += ' active';
	}
