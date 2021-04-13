Event.observe ( 
	window, 
	'load', 
		function() { 
			new Cropper.ImgWithPreview( 
				't3soeta',
				{
					minWidth: 800, 
					minHeight: 400,
		            ratioDim: { x: 600, y: 200 },
					displayOnInit: true, 
					onEndCrop: saveCoords,
		            onloadCoords: { x1: 0, y1: 0, x2: 200, y2: 200 },
		            previewWrap: 'preview'
				}
			) 
		}
);

Event.observe ( 
		window, 
		'load', 
			function() { 
				new Cropper.ImgWithPreview( 
					't3soeta2',
					{
						minWidth: 350, 
						minHeight: 263,
			            ratioDim: { x: 350, y: 263 },
						displayOnInit: true, 
						onEndCrop: saveCoords,
			            onloadCoords: { x1: 0, y1: 0, x2: 200, y2: 200 },
			            previewWrap: 'preview'
					}
				) 
			}
	);
    
function saveCoords (coords, dimensions)
{
	$( 'x1' ).value = coords.x1;
	$( 'y1' ).value = coords.y1;
	$( 'width' ).value = dimensions.width;
	$( 'height' ).value = dimensions.height;
}
