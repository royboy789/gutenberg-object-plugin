import { CleanFilter } from './CleanFilter';

export class CoreList extends CleanFilter {

  constructor() {
    super( 'core-list' );
  }

  hookCallback( attributes, name, innerBlocks ) {
    for ( let [ index, value ] of attributes.values.entries() ) {
      attributes.values[index] = wp.element.renderToString( attributes.values[index] );
    }
    return attributes;
  }

}