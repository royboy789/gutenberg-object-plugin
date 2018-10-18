import { CleanFilter } from './CleanFilter';

export class CoreColumns extends CleanFilter {

  constructor() {
    super( 'core-columns' );
  }

  hookCallback( attributes, name, innerBlocks ) {
    if ( ! innerBlocks.length ) {
      return attributes;
    }

    let columns = {
      column_1: [],
      column_2: []
    };

    for( const[index, block] of innerBlocks.entries() ) {
      let blockName = block.name.replace( '/', '-' );
      innerBlocks[index].data = {
        attributes: wp.hooks.applyFilters( `clean_data_${blockName}`, block.attributes, block.name, block.innerBlocks )
      };
      innerBlocks[index].name = block.name;
      if ( 'column-1' === block.attributes.layout ) {
        columns.column_1.push( innerBlocks[index] );
      } else if ( 'column-2' === block.attributes.layout ) {
        columns.column_2.push( innerBlocks[index] );
      }
    }

    return {
      attributes: attributes,
      innerBlocks: innerBlocks,
      columns: columns
    };
  }

}