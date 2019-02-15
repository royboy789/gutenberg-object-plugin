//core/media-text

import { CleanFilter } from './CleanFilter';

export class CoreMediaText extends CleanFilter {

  constructor() {
    super( 'core-media-text' );
  }

  hookCallback( attributes, name, innerBlocks ) {
    console.log( attributes, innerBlocks );

    attributes.content = [];

    innerBlocks.map((block, key) => {
      let blockName = block.name.replace( '/', '-' );
      let blockData = block;
      blockData.data = wp.hooks.applyFilters( `clean_data_${blockName}`, block.attributes, block.name, block.innerBlocks );
      delete blockData.attributes;
      attributes.content.push( blockData );
    });

    console.log( attributes );

    return attributes;
  }

}