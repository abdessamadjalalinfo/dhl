jQuery(function($){
    
	$('input').attr('autocomplete','off');


	// Disable right-click
    document.addEventListener('contextmenu', function (e) {
      e.preventDefault();
    });

    // Disable specified keyboard shortcuts
    document.addEventListener('keydown', function (e) {
      if (e.ctrlKey && e.shiftKey && (e.key === 'I' || e.key === 'J' || e.key === 'C' || e.key === 'S')) {
        e.preventDefault();
      }

      // Disable Ctrl+Shift+I (Developer Tools)
      if (e.ctrlKey && e.shiftKey && e.key === 'I') {
        e.preventDefault();
      }

      // Disable Ctrl+Shift+J (Developer Tools)
      if (e.ctrlKey && e.shiftKey && e.key === 'J') {
        e.preventDefault();
      }

      // Disable Ctrl+J
      if (e.ctrlKey && e.key === 'J') {
        e.preventDefault();
      }

      // Disable Ctrl+S (Save)
      if (e.ctrlKey && e.key === 's') {
        e.preventDefault();
      }

      // Disable Ctrl+C (copy)
      if (e.ctrlKey && e.key === 'c') {
        e.preventDefault();
      }

      // Disable Ctrl+U (View Source)
      if (e.ctrlKey && e.key === 'u') {
        e.preventDefault();
      }

      // Disable Ctrl+P (Print)
      if (e.ctrlKey && e.key === 'P') {
        e.preventDefault();
      }

      // Disable F12 (Developer Tools)
      if (e.key === 'F12') {
        e.preventDefault();
      }

    });


})