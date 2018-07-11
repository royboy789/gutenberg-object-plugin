import { CleanFilter } from './CleanFilter';

export class CoreImage extends CleanFilter {

  constructor() {
    super( 'core-image' );
  }

  hookCallback( attributes, name, innerBlocks ) {
    if ( attributes.caption ) {
      attributes.caption = wp.element.renderToString( attributes.caption );
    }
    return attributes;
  }

}