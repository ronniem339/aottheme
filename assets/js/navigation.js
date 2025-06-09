/**
 * File navigation.js.
 *
 * Handles toggling the primary navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus. Also handles the toggling of sub-menus on mobile.
 */
( function() {
	const siteNavigation = document.getElementById( 'site-navigation' ); // Get the <nav> element
    const menuToggle = document.querySelector( '.menu-toggle' ); // Get the menu button

	// Return early if either the navigation or the toggle button don't exist.
	if ( ! siteNavigation || ! menuToggle ) {
		return;
	}

	// --- Main Menu Toggle ---
	// Add an event listener to the menu button.
	menuToggle.addEventListener( 'click', function() {
		// Toggle the .toggled-on class on the <nav> element.
        siteNavigation.classList.toggle( 'toggled-on' );

		// Toggle the aria-expanded attribute on the button.
        const isExpanded = menuToggle.getAttribute( 'aria-expanded' ) === 'true';
		menuToggle.setAttribute( 'aria-expanded', !isExpanded );

		// Optional: Change button text (if you prefer 'Close' instead of 'Menu')
		// if (!isExpanded) {
        //     menuToggle.textContent = escHTML__( 'Close', 'allout-travel' ); // Requires localization setup for JS
		// } else {
		//     menuToggle.textContent = escHTML__( 'Menu', 'allout-travel' );
		// }
	} );


    // --- Sub Menu Toggle (for Mobile) ---
    // Find all menu items that have children (sub-menus)
    const subMenuItems = siteNavigation.querySelectorAll( '.menu-item-has-children, .page_item_has_children' );

    subMenuItems.forEach( function( item ) {
        const subMenu = item.querySelector( '.sub-menu, .children' ); // Find the sub-menu ul
        if ( ! subMenu ) {
            return; // Skip if no sub-menu found
        }

        // Get the link element within the menu item
        const link = item.querySelector( 'a' );

        // Create a button for toggling the sub-menu
        let button = document.createElement('button');
        button.classList.add('sub-menu-toggle');
        button.setAttribute('aria-expanded', 'false');
        // Use an SVG icon or simple text for the toggle indicator - SVG preferred for styling
        button.innerHTML = '<span class="sr-only">Toggle submenu</span> +'; // Simple '+' indicator for now

        // Insert the button after the link
        if (link && link.parentNode === item) { // Ensure link is direct child before inserting
            link.parentNode.insertBefore(button, link.nextSibling);
        } else {
             item.appendChild(button); // Fallback append if structure is unexpected
        }


        // Add event listener to the toggle button
        button.addEventListener('click', function(e) {
            e.preventDefault(); // Prevent the click from bubbling up or navigating

            // Toggle the .toggled-on class on the sub-menu ul
            subMenu.classList.toggle( 'toggled-on' );

            // Toggle the aria-expanded attribute on the button
            const isExpanded = button.getAttribute( 'aria-expanded' ) === 'true';
            button.setAttribute( 'aria-expanded', !isExpanded );

            // Change indicator on toggle (optional)
             button.innerHTML = !isExpanded ? '<span class="sr-only">Toggle submenu</span> –' : '<span class="sr-only">Toggle submenu</span> +';
        });
    });


	// Optional: Close mobile menu if the user clicks outside of it
	// document.addEventListener( 'click', function( event ) {
	// 	const isClickInsideNav = siteNavigation.contains( event.target );
	// 	const isClickInsideToggle = menuToggle.contains( event.target );

	// 	if ( ! isClickInsideNav && ! isClickInsideToggle && siteNavigation.classList.contains( 'toggled-on' ) ) {
	// 		siteNavigation.classList.remove( 'toggled-on' );
	// 		menuToggle.setAttribute( 'aria-expanded', 'false' );
    //         // Reset button text if using that option
	// 	}
	// } );

}() );