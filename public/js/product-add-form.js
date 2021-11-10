( $ => {

    $( () => {

        /**
         * Function to show appropriate attribute panel
         */
        const showProductAttribute = () => {

            const productType = $( '#productType' ).val();

            switch (productType) {
                
                case 'DVD':
                    
                    $('#DVD')
                    .css( 'display', 'flex' )
                    .find('input')
                    .prop( 'required', true );

                    $('#Furniture')
                    .hide()
                    .find('input')
                    .prop( 'required', false );

                    $('#Book')
                    .hide()
                    .find('input')
                    .prop( 'required', false );
                    
                    break;
                    
                case 'Furniture':
                    
                    $('#DVD')
                    .hide()
                    .find('input')
                    .prop( 'required', false );

                    $('#Furniture')
                    .css( 'display', 'flex' )
                    .find('input')
                    .prop( 'required', true );

                    $('#Book')
                    .hide()
                    .find('input')
                    .prop( 'required', false );

                    break;

                case 'Book':
                    
                    $('#DVD')
                    .hide()
                    .find('input')
                    .prop( 'required', false );

                    $('#Furniture')
                    .hide()
                    .find('input')
                    .prop( 'required', false );

                    $('#Book')
                    .css( 'display', 'flex' )
                    .find('input')
                    .prop( 'required', true );

                    break;
            
                default:

                    break;

            }

        };

        $( '#productType' )
        .on( 'change', showProductAttribute )
        .change();

    } );

} )( jQuery );