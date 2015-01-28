var wall = new freewall("#secondary");
			wall.reset({
				selector: '.widget',
				animate: false,
				cellW: 50,
				cellH: 'auto',
				gutterX: 10,
				gutterY: 10,
				onResize: function() {
					wall.fitWidth();
				}
			});
			
			
wall.fitWidth();
