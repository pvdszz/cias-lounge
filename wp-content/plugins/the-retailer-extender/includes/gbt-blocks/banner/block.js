( function( blocks, components, editor, i18n, element ) {

	const el = element.createElement;

	/* Blocks */
	const registerBlockType = blocks.registerBlockType;

	const {
		TextControl,
		ToggleControl,
		RangeControl,
		PanelBody,
		Button,
		SVG,
		Path,
	} = wp.components;

	const {
		InspectorControls,
		RichText,
		BlockControls,
		MediaUpload,
		PanelColorSettings,
	} = wp.blockEditor;

	/* Register Block */
	registerBlockType( 'getbowtied/tr-banner', {
		title: i18n.__( 'Banner', 'the-retailer-extender' ),
		icon: el( SVG, { xmlns:'http://www.w3.org/2000/svg', viewBox:'0 0 24 24' },
				el( Path, { d:'M21 3H3c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h18c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H3V5h18v14zM5 15h14v3H5z' } )
			),
		category: 'theretailer',
		supports: {
			align: [ 'center', 'wide', 'full' ],
		},
		attributes: {
			title: {
				type: 'string',
				default: 'Banner Title',
			},
			subtitle: {
				type: 'string',
				default: 'Banner Subtitle',
			},
		    imgURL: {
	            type: 'string',
	            attribute: 'src',
	            default: '',
	        },
	        imgID: {
	            type: 'number',
	        },
	        imgAlt: {
	            type: 'string',
	            attribute: 'alt',
	        },
	        url: {
	        	type: 'string',
	        	default: '#',
	        },
	        blank: {
	        	type: 'boolean',
	        	default: true
	        },
			titleColor: {
				type: 'string',
				default: '#fff'
			},
			subtitleColor: {
				type: 'string',
				default: '#fff'
			},
			innerStrokeThickness: {
				type: 'number',
				default: '2'
			},
			innerStrokeColor: {
				type: 'string',
				default: '#fff'
			},
			backgroundColor: {
				type: 'string',
				default: '#464646'
			},
			height: {
				type: 'number',
				default: '300',
			},
			titleSize: {
				type: 'number',
				default: '38'
			},
			subtitleSize: {
				type: 'number',
				default: '18'
			},
		},

		edit: function( props ) {

			let attributes = props.attributes;

			function getColors() {

				let colors = [
					{
						label: i18n.__( 'Title Color', 'the-retailer-extender' ),
						value: attributes.titleColor,
						onChange: function( newColor) {
							props.setAttributes( { titleColor: newColor } );
						},
					},
					{
						label: i18n.__( 'Subtitle Color', 'the-retailer-extender' ),
						value: attributes.subtitleColor,
						onChange: function( newColor) {
							props.setAttributes( { subtitleColor: newColor } );
						},
					},
					{
						label: i18n.__( 'Background Color', 'the-retailer-extender' ),
						value: attributes.backgroundColor,
						onChange: function( newColor) {
							props.setAttributes( { backgroundColor: newColor } );
						},
					}
				];

				if( attributes.innerStrokeThickness > 0 ) {
					colors.push(
						{
							label: i18n.__( 'Inner Stroke Color', 'the-retailer-extender' ),
							value: attributes.innerStrokeColor,
							onChange: function( newColor) {
								props.setAttributes( { innerStrokeColor: newColor } );
							},
						}
					);
				}

				return colors;
			}

			return [
				el(
					InspectorControls,
					{
						key: 'gbt_18_tr_banner_inspector'
					},
					el(
						PanelBody,
						{
							key: 'gbt_18_tr_banner_settings_panel',
							title: 'General Settings',
							initialOpen: false,
						},
						el(
							TextControl,
							{
								key: 'gbt_18_tr_banner_url',
								type: 'string',
								label: i18n.__( 'URL', 'the-retailer-extender' ),
								value: attributes.url,
								onChange: function( newURL ) {
									props.setAttributes( { url: newURL } );
								},
							}
						),
						el(
							ToggleControl,
							{
								key: "gbt_18_tr_banner_new_tab",
	              				label: i18n.__( 'Open link in new tab?', 'the-retailer-extender' ),
	              				checked: attributes.blank,
	              				onChange: function() {
									props.setAttributes( { blank: ! attributes.blank } );
								},
							}
						),
						el(
							RangeControl,
							{
								key: "gbt_18_tr_banner_height",
								value: attributes.height,
								allowReset: false,
								initialPosition: 300,
								min: 0,
								max: 1000,
								label: i18n.__( 'Height' ),
								onChange: function( newNumber ) {
									props.setAttributes( { height: newNumber } );
								},
							}
						),
					),
					el(
						PanelBody,
						{
							key: 'gbt_18_tr_banner_font_panel',
							title: 'Font Settings',
							initialOpen: false,
						},
						el(
							RangeControl,
							{
								key: "gbt_18_tr_banner_title_size",
								value: attributes.titleSize,
								allowReset: false,
								initialPosition: 38,
								min: 10,
								max: 72,
								label: i18n.__( 'Title Font Size', 'the-retailer-extender' ),
								onChange: function( newNumber ) {
									props.setAttributes( { titleSize: newNumber } );
								},
							}
						),
						el(
							RangeControl,
							{
								key: "gbt_18_tr_banner_subtitle_size",
								value: attributes.subtitleSize,
								allowReset: false,
								initialPosition: 18,
								min: 10,
								max: 72,
								label: i18n.__( 'Subtitle Font Size', 'the-retailer-extender' ),
								onChange: function( newNumber ) {
									props.setAttributes( { subtitleSize: newNumber } );
								},
							}
						),
					),
					el(
						PanelBody,
						{
							key: 'gbt_18_tr_banner_immer_stroke_settings',
							title: i18n.__( 'Inner Stroke', 'the-retailer-extender' ),
							initialOpen: false
						},
						el(
							RangeControl,
							{
								key: "gbt_18_tr_banner_inner_stroke_thickness",
								value: attributes.innerStrokeThickness,
								min: '0',
								max: '30',
								initialPosition: '2',
								allowReset: false,
								label: i18n.__( 'Inner Stroke Thickness', 'the-retailer-extender' ),
								onChange: function( newNumber ) {
									props.setAttributes( { innerStrokeThickness: newNumber } );
								},
							}
						),
					),
					el(
						PanelColorSettings,
						{
							key: 'gbt_18_tr_banner_color_settings',
							title: i18n.__( 'Colors', 'the-retailer-extender' ),
							initialOpen: false,
							colorSettings: getColors()
						},
					),
				),
				el(
					'div',
					{
						key: 'gbt_18_tr_editor_banner',
						className: 'gbt_18_tr_editor_banner',
					},
					el(
						'div',
						{
							key: 'gbt_18_tr_editor_banner_wrapper',
							className: 'gbt_18_tr_editor_banner_wrapper',
							style:
							{
								height: attributes.height + 'px',
							}
						},
						el(
							'div',
							{
								key: 'gbt_18_tr_editor_banner_wrapper_inner',
								className: 'gbt_18_tr_editor_banner_wrapper_inner',
							},
							el( 'div',
								{
									key: 'gbt_18_tr_editor_banner_background',
									className: 'gbt_18_tr_editor_banner_background',
									style:
									{
										backgroundColor: attributes.backgroundColor,
										backgroundImage: 'url(' + attributes.imgURL + ')'
									},
								}
							),
							el(
								MediaUpload,
								{
									key: 'gbt_18_tr_editor_banner_img_upload',
									allowedTypes: [ 'image' ],
									formattingControls: [ 'align' ],
									buttonProps: { className: 'components-button button button-large' },
			              			value: attributes.imgID,
									onSelect: function( img ) {
										props.setAttributes( {
											imgID: img.id,
											imgURL: img.url,
											imgAlt: img.alt,
										} );
									},
			              			render: function( img ) {
			              				return [
				              				! attributes.imgID && el(
				              					Button,
				              					{
				              						key: 'gbt_18_tr_editor_banner_add_image_button',
				              						className: 'button gbt_18_tr_editor_banner_add_image',
				              						onClick: img.open
				              					},
				              					i18n.__( 'Add Image', 'the-retailer-extender' )
			              					),
			              					!! attributes.imgID && el(
			              						Button,
												{
													key: 'gbt_18_tr_editor_banner_remove_image_button',
													className: 'button gbt_18_tr_editor_banner_remove_image',
													onClick: function() {
														img.close;
														props.setAttributes({
											            	imgID: null,
											            	imgURL: null,
											            	imgAlt: null,
											            });
													}
												},
												i18n.__( 'Remove Image', 'the-retailer-extender' )
											),
			              				];
			              			},
								},
							),
							el(
								'div',
								{
									key: 'gbt_18_tr_editor_banner_content',
									className: 'gbt_18_tr_editor_banner_content',
									style:
									{
										border: attributes.innerStrokeThickness + 'px solid ' + attributes.innerStrokeColor
									},
								},
								el(
									'div',
									{
										key: 'gbt_18_tr_editor_banner_text_content',
										className: 'gbt_18_tr_editor_banner_text_content',
									},
									el(
										RichText,
										{
											key: 'gbt_18_tr_editor_banner_title',
											style:
											{
												color: attributes.titleColor,
												fontSize: attributes.titleSize + 'px'
											},
											className: 'gbt_18_tr_editor_banner_title',
											allowedFormats: [],
											tagName: 'h3',
											format: 'string',
											value: attributes.title,
											placeholder: i18n.__( 'Add Title', 'the-retailer-extender' ),
											onChange: function( newTitle) {
												props.setAttributes( { title: newTitle } );
											}
										}
									),
									el(
										RichText,
										{
											key: 'gbt_18_tr_editor_banner_subtitle',
											style:
											{
												color: attributes.subtitleColor,
												fontSize: attributes.subtitleSize + 'px'
											},
											className: 'gbt_18_tr_editor_banner_subtitle',
											tagName: 'p',
											format: 'string',
											value: attributes.subtitle,
											allowedFormats: [],
											placeholder: i18n.__( 'Add Subtitle', 'the-retailer-extender' ),
											onChange: function( newSubtitle) {
												props.setAttributes( { subtitle: newSubtitle } );
											}
										}
									),
								),
							),
						),
					),
				),
			];
		},
		save: function(props) {

			let attributes = props.attributes;

			return el( 'div',
				{
					key: 'gbt_18_tr_banner',
					className: 'gbt_18_tr_banner',
					style:
					{
						height: attributes.height + 'px',
					}
				},
				el( 'a',
					{
						key: 'gbt_18_tr_banner_wrapper',
						className: 'gbt_18_tr_banner_wrapper',
						href: attributes.url,
						target: attributes.blank ? '_blank' : '_self',
						rel: 'noopener noreferrer'
					},
					el( 'div',
						{
							key: 'gbt_18_tr_banner_wrapper_inner',
							className: 'gbt_18_tr_banner_wrapper_inner',
						},
						el( 'div',
							{
								key: 'gbt_18_tr_banner_background',
								className: 'gbt_18_tr_banner_background',
								style:
								{
									backgroundColor: attributes.backgroundColor,
									backgroundImage: 'url(' + attributes.imgURL + ')'
								},
							}
						),
						el( 'div',
							{
								key: 'gbt_18_tr_banner_content',
								className: 'gbt_18_tr_banner_content',
								style:
								{
									border: attributes.innerStrokeThickness + 'px solid ' + attributes.innerStrokeColor
								},
							},
							el( 'div',
								{
									key: 'gbt_18_tr_banner_text_content',
									className: 'gbt_18_tr_banner_text_content',
								},
								el( 'h3',
									{
										key: 'gbt_18_tr_banner_title',
										className: 'gbt_18_tr_banner_title',
										style:
										{
											color: attributes.titleColor,
											fontSize: attributes.titleSize + 'px'
										},
									},
									i18n.__( attributes.title, 'the-retailer-extender' )
								),
								el( 'p',
									{
										key: 'gbt_18_tr_banner_subtitle',
										className: 'gbt_18_tr_banner_subtitle',
										style:
										{
											color: attributes.subtitleColor,
											fontSize: attributes.subtitleSize + 'px'
										}
									},
									i18n.__( attributes.subtitle, 'the-retailer-extender' )
								)
							)
						)
					)
				)
			);
		},
	} );

} )(
	window.wp.blocks,
	window.wp.components,
	window.wp.editor,
	window.wp.i18n,
	window.wp.element,
);
